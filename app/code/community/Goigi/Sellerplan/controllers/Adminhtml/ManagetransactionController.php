<?php

class Goigi_Sellerplan_Adminhtml_ManagetransactionController extends Mage_Adminhtml_Controller_action
{
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('sellerplan/transaction')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('transaction Manager'));
		
		return $this;
	}   
 
	public function indexAction() {			
		$this->_initAction()
			->renderLayout();
	}
	
	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('sellerplan/managetransaction')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}
			$customerId = $model->getCustomeremail();
			$customer = Mage::getModel('customer/customer')->load($customerId);
			$model->setCustomeremail($customer->getEmail());
			
			Mage::register('managetransaction_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('sellerplan/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('transaction Manager'), Mage::helper('adminhtml')->__('transaction Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('transaction News'), Mage::helper('adminhtml')->__('transaction News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('sellerplan/adminhtml_managetransaction_edit'))
				->_addLeft($this->getLayout()->createBlock('sellerplan/adminhtml_managetransaction_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('sellerplan')->__('transaction does not exist'));
			$this->_redirect('*/*/');
		}
	}
			
	public function newAction() {
		$this->_forward('edit');
	}
 
	 public function saveAction() {
			if ($data = $this->getRequest()->getPost()) {		
	//		echo "<pre>"; print_r($data); die;
				$data['bidplantype']	= 'Assign By Admin';
				$data['bidprice']	= '0.00';
				$data['bidavailable']	= $data['bidproduct'];
				$model = Mage::getModel('sellerplan/managetransaction');		
				$model->setData($data)
					->setId($this->getRequest()->getParam('id'));
				
				try {
					if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
						$model->setCreatedTime(now())
							->setUpdateTime(now());
					} else {
						$model->setUpdateTime(now());
					}											
					
					$model->save();
					Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('sellerplan')->__('Plan was successfully saved'));
					Mage::getSingleton('adminhtml/session')->setFormData(false);

					if ($this->getRequest()->getParam('back')) {
						$this->_redirect('*/*/edit', array('id' => $model->getId()));
						return;
					}
					$this->_redirect('*/*/');
					return;
				} catch (Exception $e) {
					Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
					Mage::getSingleton('adminhtml/session')->setFormData($data);
					$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
					return;
				}
			}
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('sellerplan')->__('Unable to find plan to save'));
			$this->_redirect('*/*/');
		}
	
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('sellerplan/managetransaction');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('transaction was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $sellerplanIds = $this->getRequest()->getParam('managetransaction');
        if(!is_array($sellerplanIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select transaction(s)'));
        } else {
            try {
                foreach ($sellerplanIds as $sellerplanId) {
                    $sellerplan = Mage::getModel('sellerplan/managetransaction')->load($sellerplanId);
                    $sellerplan->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($sellerplanIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
		
	public function massStatusAction()
    {
        $sellerplanIds = $this->getRequest()->getParam('managetransaction');
        if(!is_array($sellerplanIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select transaction(s)'));
        } else {
            try {
                foreach ($sellerplanIds as $sellerplanId) {
                    $sellerplan = Mage::getSingleton('sellerplan/managetransaction')
                        ->load($sellerplanId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($sellerplanIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }	
		
		
	public function exportCsvAction()
    {
        $fileName   = 'managetransaction.csv';
        $content    = $this->getLayout()->createBlock('sellerplan/adminhtml_managetransaction_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'managetransaction.xml';
        $content    = $this->getLayout()->createBlock('sellerplan/adminhtml_managetransaction_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
		
}