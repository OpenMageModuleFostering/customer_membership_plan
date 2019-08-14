<?php
class Goigi_Sellerplan_Block_Adminhtml_Managetransaction extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_managetransaction';
    $this->_blockGroup = 'sellerplan';
    $this->_headerText = Mage::helper('sellerplan')->__('Transaction Manager');
   // $this->_addButtonLabel = Mage::helper('sellerplan')->__('Add Transaction');
	
    parent::__construct();
	$this->_removeButton('add');
  }
}