<?php
class Goigi_Sellerplan_Block_Sellerplan extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getSellerplan()     
     { 
        if (!$this->hasData('sellerplan')) {
            $this->setData('sellerplan', Mage::registry('sellerplan'));
        }
        return $this->getData('sellerplan');
        
    }
}