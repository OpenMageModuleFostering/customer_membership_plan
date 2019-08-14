<?php

class Goigi_Sellerplan_Block_Adminhtml_Managetransaction_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
         $this->_removeButton('save');        
		 $this->_removeButton('delete');    
		 $this->_removeButton('reset');    
		 
        $this->_objectId = 'id';
        $this->_blockGroup = 'sellerplan';
        $this->_controller = 'adminhtml_managetransaction';
        
       /* $this->_updateButton('save', 'label', Mage::helper('sellerplan')->__('Save transaction'));
        $this->_updateButton('delete', 'label', Mage::helper('sellerplan')->__('Delete transaction'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
*/
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('sellerplan_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'sellerplan_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'sellerplan_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('managetransaction_data') && Mage::registry('managetransaction_data')->getId() ) {
            return Mage::helper('sellerplan')->__("View transaction '%s'", $this->htmlEscape(Mage::registry('managetransaction_data')->getTitle()));
        } else {
            return Mage::helper('sellerplan')->__('Add transaction');
        }
    }
}