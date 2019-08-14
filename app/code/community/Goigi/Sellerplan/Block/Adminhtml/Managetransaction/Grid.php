<?php

class Goigi_Sellerplan_Block_Adminhtml_Managetransaction_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('sellerplanGrid');
      $this->setDefaultSort('bidplaninvoiceid');
      $this->setDefaultDir('ASC');
	  $this->setSaveParametersInSession(true);
  }
   public function getEmail(){
		$data = Mage::getModel('customer/customer')->getCollection();
		$data->addNameToSelect();
		$data->addAttributeToSelect(array('firstname', 'lastname', 'email'));		
		foreach($data as $val){			
		$email[$val->getId()]=$val->getFirstname() . ' ' . $val->getLastname().' ('.$val->getEmail().')';	
		}		
		return $email;
	}

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('sellerplan/managetransaction')->getCollection();
      $this->setCollection($collection);	  
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('bidplaninvoiceid', array(
          'header'    => Mage::helper('sellerplan')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'bidplaninvoiceid',
      ));

	   $this->addColumn('invoice', array(
          'header'    => Mage::helper('sellerplan')->__('Invoice Number'),
          'align'     =>'left',
		   'width'     => '150px',
          'index'     => 'invoice',
      ));
	  
	   $this->addColumn('customeremail', array(
          'header'    => Mage::helper('sellerplan')->__('Customer Email Address'),
          'align'     =>'left',
		   'width'     => '300px',
          'index'     => 'customeremail',
		   'type'      => 'options',
		  'options' => $this->getEmail(),
      ));
	  
	  	  
      $this->addColumn('txn_id', array(
          'header'    => Mage::helper('sellerplan')->__('Transaction Number'),
          'align'     =>'left',
		   'width'     => '300px',
          'index'     => 'txn_id',
      ));
	  
	   $this->addColumn('created_time', array(
          'header'    => Mage::helper('sellerplan')->__('Transaction Date'),
          'align'     =>'left',
		   'width'     => '200px',
          'index'     => 'created_time',
      ));
	  
	   $this->addColumn('bidplantype', array(
          'header'    => Mage::helper('sellerplan')->__('Plan Type'),
          'align'     =>'left',
		   'width'     => '100px',
          'index'     => 'bidplantype',
      ));
	  
	   $this->addColumn('bidprice', array(
          'header'    => Mage::helper('sellerplan')->__('Amount'),
          'align'     =>'left',
		   'width'     => '200px',
          'index'     => 'bidprice',
      ));
	  
	   $this->addColumn('payment_status', array(
          'header'    => Mage::helper('sellerplan')->__('Payment Status'),
          'align'     =>'left',
		   'width'     => '200px',
          'index'     => 'payment_status',
      ));
	  
	
	  	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('sellerplan')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('sellerplan')->__('View'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('sellerplan')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('sellerplan')->__('XML'));
	  
      return parent::_prepareColumns();
  }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}