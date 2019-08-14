<?php

class Goigi_Sellerplan_Block_Adminhtml_Managecustomer_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	public function getEmail(){
		$data = Mage::getModel('customer/customer')->getCollection();
		$data->addNameToSelect();
		$data->addAttributeToSelect(array('firstname', 'lastname', 'email'));		
		foreach($data as $val){			
		$email[$val->getId()]=$val->getFirstname() . ' ' . $val->getLastname().' ('.$val->getEmail().')';	
		}		
		return $email;
	}
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
	  	
      $this->setForm($form);
	  
      $fieldset = $form->addFieldset('managecustomer_form', array('legend'=>Mage::helper('sellerplan')->__('Item information')));    
	  
      $fieldset->addField('customeremail', 'select', array(
          'label'     => Mage::helper('sellerplan')->__('Customer Email Address'),
          'required'  => true,
          'name'      => 'customeremail',
		  'values'    => $this->getEmail(),
	  ));
		  
  
	  
		$fieldset->addField('bidproduct', 'text', array(
          'label'     => Mage::helper('sellerplan')->__('Membership Duration'),
          'required'  => true,
          'name'      => 'bidproduct',
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
                
      if ( Mage::getSingleton('adminhtml/session')->getManagecustomerData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getManagecustomerData());
          Mage::getSingleton('adminhtml/session')->setManagecustomerData(null);
      } elseif ( Mage::registry('managecustomer_data') ) {
          $form->setValues(Mage::registry('managecustomer_data')->getData());		  
      }
      return parent::_prepareForm();
  }
}