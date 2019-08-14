<?php

class Goigi_Sellerplan_Model_Mysql4_Managecustomer extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {            
        $this->_init('sellerplan/managecustomer', 'sellercustomerbid_id');
    }
}