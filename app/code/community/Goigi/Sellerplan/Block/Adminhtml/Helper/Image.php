<?php
class Goigi_Sellerplan_Block_Adminhtml_Helper_Image
    extends Varien_Data_Form_Element_Image {
    protected function _getUrl(){
        $url = false;
        if ($this->getValue()) {
            $url = Mage::getBaseUrl('media').'plan/'.$this->getValue();
        }
        return $url;
    }
}
?>