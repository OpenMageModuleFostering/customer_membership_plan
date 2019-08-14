<?php

class Goigi_Sellerplan_Adminhtml_SellerplanController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('sellerplan/plan')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Plan Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('sellerplan/sellerplan')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('sellerplan_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('sellerplan/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Plan Manager'), Mage::helper('adminhtml')->__('Plan Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Plan News'), Mage::helper('adminhtml')->__('Plan News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('sellerplan/adminhtml_sellerplan_edit'))
				->_addLeft($this->getLayout()->createBlock('sellerplan/adminhtml_sellerplan_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('sellerplan')->__('Plan does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			
			if(isset($_FILES['plan_image']['name']) && $_FILES['plan_image']['name'] != '') {
				try {	
					/* Starting upload */	
					$uploader = new Varien_File_Uploader('plan_image');
					
					// Any extention would work
	           		$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(false);										
					$uploader->setFilesDispersion(false);	
					$path = Mage::getBaseDir('media') . DS .'plan/';											
					$uploader->save($path, $_FILES['plan_image']['name'] );
					
				} catch (Exception $e) {
		      
		        }	        
		        //this way the name is saved in DB				
				$data['plan_image'] = $_FILES['plan_image']['name'];	  			
			}
							
			if(is_array($data['plan_image'])){											
				$data['plan_image'] = $data['plan_image']['value'];						
			}
			$price = $data['plan_price'];
			$offer_price = $data['offer_price'];
	  			
//				echo "<pre>"; print_r($data); die;
	  			
			$model = Mage::getModel('sellerplan/sellerplan');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				if ($price < $offer_price ) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
	Mage::getSingleton('adminhtml/session')->addError(Mage::helper('sellerplan')->__('Unable to save offer is getter than price'));
					return;
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
				$model = Mage::getModel('sellerplan/sellerplan');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Plan was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $sellerplanIds = $this->getRequest()->getParam('sellerplan');
        if(!is_array($sellerplanIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select plan(s)'));
        } else {
            try {
                foreach ($sellerplanIds as $sellerplanId) {
                    $sellerplan = Mage::getModel('sellerplan/sellerplan')->load($sellerplanId);
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
        $sellerplanIds = $this->getRequest()->getParam('sellerplan');
        if(!is_array($sellerplanIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select plan(s)'));
        } else {
            try {
                foreach ($sellerplanIds as $sellerplanId) {
                    $sellerplan = Mage::getSingleton('sellerplan/sellerplan')
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
        $fileName   = 'sellerplan.csv';
        $content    = $this->getLayout()->createBlock('sellerplan/adminhtml_sellerplan_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'sellerplan.xml';
        $content    = $this->getLayout()->createBlock('sellerplan/adminhtml_sellerplan_grid')
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