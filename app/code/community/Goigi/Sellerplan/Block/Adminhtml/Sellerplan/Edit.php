<?php

class Goigi_Sellerplan_Block_Adminhtml_Sellerplan_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'sellerplan';
        $this->_controller = 'adminhtml_sellerplan';
        
        $this->_updateButton('save', 'label', Mage::helper('sellerplan')->__('Save Plan'));
        $this->_updateButton('delete', 'label', Mage::helper('sellerplan')->__('Delete Plan'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

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
        if( Mage::registry('sellerplan_data') && Mage::registry('sellerplan_data')->getId() ) {
            return Mage::helper('sellerplan')->__("Edit Plan '%s'", $this->htmlEscape(Mage::registry('sellerplan_data')->getTitle()));
        } else {
            return Mage::helper('sellerplan')->__('Add Plan');
        }
    }
}