<?php

class Goigi_Sellerplan_Block_Adminhtml_Managetransaction_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('managetransaction_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('sellerplan')->__('Transaction Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('sellerplan')->__('Transaction Information'),
          'title'     => Mage::helper('sellerplan')->__('Transaction Information'),
          'content'   => $this->getLayout()->createBlock('sellerplan/adminhtml_managetransaction_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}