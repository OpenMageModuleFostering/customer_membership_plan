<?php

class Goigi_Sellerplan_Block_Adminhtml_Sellerplan_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('sellerplan_form', array('legend'=>Mage::helper('sellerplan')->__('Item information')));
      $fieldset->addType('image', 'Goigi_Sellerplan_Block_Adminhtml_Helper_Image');
	  
      $fieldset->addField('plan_title', 'text', array(
          'label'     => Mage::helper('sellerplan')->__('Plan Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'plan_title',
      ));

      $fieldset->addField('plan_image', 'image', array(
          'label'     => Mage::helper('sellerplan')->__('Plan Image'),
          'required'  => true,
          'name'      => 'plan_image',
	  ));
	
	  
	  $fieldset->addField('plan_desc', 'editor', array(
          'name'      => 'plan_desc',
          'label'     => Mage::helper('sellerplan')->__('Plan Description'),
          'title'     => Mage::helper('sellerplan')->__('Plan Description'),
          'style'     => 'width:275px; height:250px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
	  
		$fieldset->addField('product_num', 'text', array(
          'label'     => Mage::helper('sellerplan')->__('Membership Duration'),
          'required'  => true,
          'name'      => 'product_num',
		));

		$fieldset->addField('plan_price', 'text', array(
          'label'     => Mage::helper('sellerplan')->__('Price'),
          'required'  => true,
          'name'      => 'plan_price',
		));		
		$fieldset->addField('offer_price', 'text', array(
          'label'     => Mage::helper('sellerplan')->__('Offer Price'),
          'required'  => false,
          'name'      => 'offer_price',
		));	
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('sellerplan')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('sellerplan')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('sellerplan')->__('Disabled'),
              ),
          ),
      ));
                
      if ( Mage::getSingleton('adminhtml/session')->getSellerplanData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getSellerplanData());
          Mage::getSingleton('adminhtml/session')->setSellerplanData(null);
      } elseif ( Mage::registry('sellerplan_data') ) {
          $form->setValues(Mage::registry('sellerplan_data')->getData());
      }
      return parent::_prepareForm();
  }
}