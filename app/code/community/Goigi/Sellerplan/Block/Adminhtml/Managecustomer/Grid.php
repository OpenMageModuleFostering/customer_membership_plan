
<?php

class Goigi_Sellerplan_Block_Adminhtml_Managecustomer_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('sellerplanGrid');
      $this->setDefaultSort('sellercustomerbid_id');
      $this->setDefaultDir('ASC');
	  $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('sellerplan/managecustomer')->getCollection();
      $this->setCollection($collection);	  
      return parent::_prepareCollection();
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
  
  protected function _prepareColumns()
  {
      $this->addColumn('sellercustomerbid_id', array(
          'header'    => Mage::helper('sellerplan')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'sellercustomerbid_id',
      ));

	   $this->addColumn('customeremail', array(
          'header'    => Mage::helper('sellerplan')->__('Customer Email Address'),
          'align'     =>'left',
		   'width'     => '200px',
          'index'     => 'customeremail',
		   'type'      => 'options',
		  'options' => $this->getEmail(),
      ));
	  
	  $this->addColumn('bidplantype', array(
          'header'    => Mage::helper('sellerplan')->__('Plan Type'),
          'align'     =>'left',
		   'width'     => '200px',
          'index'     => 'bidplantype',
      ));
	  
      $this->addColumn('bidproduct', array(
          'header'    => Mage::helper('sellerplan')->__('Plan Product'),
          'align'     =>'left',
		   'width'     => '200px',
          'index'     => 'bidproduct',
      ));
	  
	   $this->addColumn('bidprice', array(
          'header'    => Mage::helper('sellerplan')->__('Plan Price'),
          'align'     =>'left',
		   'width'     => '200px',
          'index'     => 'bidprice',
      ));
	  
	  $this->addColumn('bidavailable', array(
          'header'    => Mage::helper('sellerplan')->__('Available Duration'),
          'align'     =>'left',
		   'width'     => '200px',
          'index'     => 'bidavailable',
      ));
	  
	  

      $this->addColumn('status', array(
          'header'    => Mage::helper('sellerplan')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('sellerplan')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('sellerplan')->__('Delete'),
                        'url'       => array('base'=> '*/*/delete'),
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
      //return $this->getUrl('*/*/delete', array('id' => $row->getId()));
  }

}