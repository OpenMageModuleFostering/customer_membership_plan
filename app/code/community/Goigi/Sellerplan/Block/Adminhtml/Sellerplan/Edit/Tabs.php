<?php

class Goigi_Sellerplan_Block_Adminhtml_Sellerplan_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('sellerplan_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('sellerplan')->__('Plan Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('sellerplan')->__('Plan Information'),
          'title'     => Mage::helper('sellerplan')->__('Plan Information'),
          'content'   => $this->getLayout()->createBlock('sellerplan/adminhtml_sellerplan_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}