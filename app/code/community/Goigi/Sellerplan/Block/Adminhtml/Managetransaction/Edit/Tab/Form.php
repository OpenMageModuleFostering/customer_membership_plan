<?php
class Goigi_Sellerplan_Block_Adminhtml_Managetransaction_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
	  	
      $this->setForm($form);
	  
      $fieldset = $form->addFieldset('managetransaction_form', array('legend'=>Mage::helper('sellerplan')->__('Item information')));    
	  
		$fieldset->addField('invoice', 'text', array(
			'label'     => Mage::helper('sellerplan')->__('Invoice Number'),
			'required'  => true,
			'name'      => 'invoice',	
			'readonly' => true,
		));
	  
		$fieldset->addField('customeremail', 'text', array(
			'label'     => Mage::helper('sellerplan')->__('Customer Email Address'),
			'required'  => true,
			'name'      => 'customeremail',
			'readonly' => true,		  
		));
	  				
		$fieldset->addField('bidplantype', 'text', array(
			'label'     => Mage::helper('sellerplan')->__('Plan Type'),
			'required'  => true,
			'name'      => 'bidplantype',
			'readonly' => true,	
		));
		  
		$fieldset->addField('bidproduct', 'text', array(
			'label'     => Mage::helper('sellerplan')->__('Membership Duration'),
			'required'  => true,
			'name'      => 'bidproduct',
			'readonly' => true,	
		));
		
		$fieldset->addField('payer_email', 'text', array(
			'label'     => Mage::helper('sellerplan')->__('Payer Email Address'),
			'required'  => true,
			'name'      => 'payer_email',
			'readonly' => true,	
		));
		$fieldset->addField('payer_status', 'text', array(
			'label'     => Mage::helper('sellerplan')->__('Payer Status'),
			'required'  => true,
			'name'      => 'payer_status',
			'readonly' => true,	
		));
		
		$fieldset->addField('txn_id', 'text', array(
			'label'     => Mage::helper('sellerplan')->__('Transaction Number'),
			'required'  => true,
			'name'      => 'txn_id',	
			'readonly' => true,
		));
	  
		$fieldset->addField('bidprice', 'text', array(
			'label'     => Mage::helper('sellerplan')->__('Amount'),
			'required'  => true,
			'name'      => 'bidprice',
			'readonly' => true,	
		));

		$fieldset->addField('payment_date', 'text', array(
			'label'     => Mage::helper('sellerplan')->__('Payment Date'),
			'required'  => true,
			'name'      => 'payment_date',
			'readonly' => true,	
		));
		
		$fieldset->addField('payment_status', 'text', array(
			'label'     => Mage::helper('sellerplan')->__('Payment Status'),
			'required'  => true,
			'name'      => 'payment_status',
			'readonly' => true,	
		));
		
		          
      if ( Mage::getSingleton('adminhtml/session')->getManagetransactionData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getManagetransactionData());
          Mage::getSingleton('adminhtml/session')->setManagetransactionData(null);
      } elseif ( Mage::registry('managetransaction_data') ) {
          $form->setValues(Mage::registry('managetransaction_data')->getData());		  
      }
      return parent::_prepareForm();
  }
}