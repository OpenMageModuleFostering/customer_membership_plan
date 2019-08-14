<?php

class Goigi_Sellerplan_Block_Adminhtml_Managecustomer_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('managecustomer_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('sellerplan')->__('Customer Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('sellerplan')->__('Customer Information'),
          'title'     => Mage::helper('sellerplan')->__('Customer Information'),
          'content'   => $this->getLayout()->createBlock('sellerplan/adminhtml_managecustomer_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}