<?php

class Goigi_Sellerplan_Model_Mysql4_Sellerplan extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the sellerplan_id refers to the key field in your database table.
        $this->_init('sellerplan/sellerplan', 'sellerplan_id');
    }
}