<?php

class Goigi_Sellerplan_Model_Mysql4_Managetransaction extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {            
        $this->_init('sellerplan/managetransaction', 'bidplaninvoiceid');
    }
}