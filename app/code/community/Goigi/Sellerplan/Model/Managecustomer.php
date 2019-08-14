<?php

class Goigi_Sellerplan_Model_Managecustomer extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('sellerplan/managecustomer');
    }
}