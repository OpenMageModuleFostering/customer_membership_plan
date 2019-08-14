<?php
$installer = $this;
$installer->startSetup();
$installer->run("
	-- DROP TABLE IF EXISTS {$this->getTable('bid_sellerplan')};
	CREATE TABLE {$this->getTable('bid_sellerplan')} (
	  `sellerplan_id` int(11) unsigned NOT NULL auto_increment,
	  `plan_title` varchar(255) NOT NULL default '',
	  `plan_image` varchar(255) NOT NULL default '',
	  `plan_desc` text NOT NULL default '',
	  `product_num` varchar(255) NOT NULL default '',
	  `plan_price` varchar(255) NOT NULL default '',
	  `offer_price` varchar(255) NOT NULL default '',
	  `status` smallint(6) NOT NULL default '0',
	  `created_time` datetime NULL,
	  `update_time` datetime NULL,
	  PRIMARY KEY (`sellerplan_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	-- DROP TABLE IF EXISTS {$this->getTable('bid_sellercustomerbid')};
	CREATE TABLE {$this->getTable('bid_sellercustomerbid')} ( 
		`sellercustomerbid_id` int (11) unsigned NOT NULL auto_increment,
		`customeremail` varchar(255) DEFAULT '',
		`bidplantype` varchar(255) NOT NULL,
		`bidprice` varchar(255) NOT NULL,
		`bidproduct` varchar(255) DEFAULT '',
		`bidavailable` varchar(255) NOT NULL,
		`status` smallint(6) NOT NULL DEFAULT '0',
		`created_time` datetime DEFAULT NULL,
		`update_time` datetime DEFAULT NULL,
	  PRIMARY KEY (`sellercustomerbid_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	
	
	-- DROP TABLE IF EXISTS {$this->getTable('bid_bidplaninvoice')};
	CREATE TABLE {$this->getTable('bid_bidplaninvoice')} ( 
		`bidplaninvoiceid` int (11) unsigned NOT NULL auto_increment,
		`customeremail` varchar(255) NOT NULL,
		`payer_email` varchar(255) DEFAULT NULL,
		`bidplantype` varchar(255) DEFAULT NULL,
		`bidprice` varchar(255) DEFAULT NULL,
		`invoice` varchar(255) DEFAULT NULL,
		`payer_id` varchar(255) NOT NULL,
		`payer_status` varchar(255) NOT NULL,
		`payment_date` varchar(255) NOT NULL,
		`payment_status` varchar(255) NOT NULL,
		`pending_reason` varchar(255) NOT NULL,
		`verify_sign` text NOT NULL,
		`txn_id` varchar(255) NOT NULL,
		`payment_gross` varchar(255) NOT NULL,
		`mc_currency` varchar(255) NOT NULL,
		`ipn_track_id` varchar(255) NOT NULL,
		`bidproduct` varchar(255) DEFAULT NULL,
		`status` varchar(255) NOT NULL,
		`created_time` datetime NOT NULL,
		`update_time` datetime NOT NULL,
	  PRIMARY KEY (`bidplaninvoiceid`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	
	
	

	
	
 ");
$installer->endSetup(); 


