<?php
class Goigi_Sellerplan_Block_Adminhtml_Sellerplan extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_sellerplan';
    $this->_blockGroup = 'sellerplan';
    $this->_headerText = Mage::helper('sellerplan')->__('Plan Manager');
    $this->_addButtonLabel = Mage::helper('sellerplan')->__('Add Plan');
	
    parent::__construct();
  }
}