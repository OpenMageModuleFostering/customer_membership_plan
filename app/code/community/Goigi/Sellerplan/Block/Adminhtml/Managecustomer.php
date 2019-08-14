<?php
class Goigi_Sellerplan_Block_Adminhtml_Managecustomer extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_managecustomer';
    $this->_blockGroup = 'sellerplan';
    $this->_headerText = Mage::helper('sellerplan')->__('Customer Manager');
    $this->_addButtonLabel = Mage::helper('sellerplan')->__('Add Customer');
	
    parent::__construct();
  }
}