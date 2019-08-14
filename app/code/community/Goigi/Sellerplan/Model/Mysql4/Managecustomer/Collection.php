<?php

class Goigi_Sellerplan_Model_Mysql4_Managecustomer_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('sellerplan/managecustomer');
    }
}