<?php
class Goigi_Sellerplan_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {    	
		$this->loadLayout();     
		$this->renderLayout();
    }
		
	public function accountplanAction()
    {	
		$wholedata=$this->getRequest()->getParams();
		$txn_id	= $wholedata['tx'];	
		$txn_status	= $wholedata['st'];	
		$amount	= Mage::helper('core')->currency($wholedata['amt']);
			
		if(!empty($txn_id)){
			Mage::getSingleton('core/session')->addSuccess('Your Payment for '.$amount.' is ' .$txn_status. '. Your Transcation Number is '.$txn_id.'</br> Your membership plan information will be updated soon...');
			
			$customer = Mage::getSingleton('customer/session')->getCustomer();    
			$firstname = $customer->getFirstname(); // First Name    
			$lastname = $customer->getLastname(); // Last Name      
			$email = $customer->getEmail();
						
			$senderemail = Mage::getStoreConfig('goigi/bidding_contact/email_address');
			$sendername  = Mage::getStoreConfig('goigi/bidding_contact/email_name');

			$name=$firstname. ' '.$lastname;
			
			$storeId=Mage::app()->getStore()->getId();			
			$mailer = Mage::getModel('core/email_template_mailer');
			$emailInfo = Mage::getModel('core/email_info');
			$emailInfo->addTo((string)$email,(string) $name);
			$mailer->addEmailInfo($emailInfo);			
			$mailer->setSender(array('email'=>(string) $senderemail,'name'=> (string)$sendername));
			$mailer->setStoreId($storeId);
			$mailer->setTemplateId((string) 'bidding_plan_email_template');
			$mailer->send();			
		}		
	
		if (!Mage::getSingleton('customer/session')->isLoggedIn()):
            $this->_redirect('customer/account/login');
            return;
        endif;
    
		$this->loadLayout(array('default','sellerplan_index_account'));
		$this->getLayout()->getBlock('head')->setTitle( Mage::helper('sellerplan')->__('Select Plan View'));
		$this->renderLayout();
	}
	
	
	 public function viewdetailAction()
    {
		$id = $_REQUEST['id'];		
		$data = Mage::getModel('sellerplan/sellerplan')->load($id);
		$_finalPrice = $data->getplan_price();
		$_price = $data->getoffer_price();		
		$html = "<div class='modal-content'>";
        $html .= "<div class='modal-header'>";
        $html .= "<button type='button' class='close' data-dismiss='modal'>&times;</button>";
		$html .= "<h4 class='modal-title'>Plan Name :- ".$data->getplan_title()."</h4>";		  
        $html .= "</div>";
        $html .= "<div class='modal-body'>";
		$html .= "<p>Membership Duration :- ".$data->getproduct_num()."</p>";
		if(!empty($_finalPrice)) {
		$html .= "<p>Regular Price :- ".Mage::helper('core')->currency($_finalPrice)."</p>";
		}
		if(!empty($_price)) {		
			$html .= "<p>Offer Price :- ".Mage::helper('core')->currency($_price)."</p>";
		}
        $html .= "<p>".$data->getplan_desc()."</p>";		  		  
        $html .= "</div>";
        $html .= "<div class='modal-footer'>";        
		$html .= "<button type='button' class='btn btn-primary' onclick='checklogin(".$id.")' id='submit_plan'>Submit Now</button>";
        $html .= "</div>";
		$html .= "</div>";
		
		echo $html;    	
	}
	
	public function checkloginAction(){
		$id = $_REQUEST['id'];	
		
		if(!Mage::getSingleton('customer/session')->isLoggedIn()){
			
			$html = "<div class='login_modal modal-content'>";
			$html .= "<div class='modal-header'>";
			$html .= "<button type='button' class='close' data-dismiss='modal'>&times;</button>";			
			$html .= "<h2 class='modal-title form-signin-heading'>Please sign in</h2>";			
			$html .= "</div>";
			$html .= "<div class='modal-body'>";
			
			$html .= "<span class='error_message'></span>";
			$html .= "<label for='inputEmail' class='sr-only'>Email address</label>";
			$html .= "<input type='email' id='inputEmail' name='email' class='form-control cu_input' placeholder='Email address' required autofocus>";
			$html .= "<label for='inputPassword' class='sr-only'>Password</label>";
			$html .= "<input type='password' id='inputPassword' name='password' class='form-control cu_input' placeholder='Password' required>";
			$html .=  "<button id='login_sub' onclick='login_sub(".$id.")' class='btn btn-primary btn-block cu_btn_login' type='submit'>Sign in</button>";
			$html .= "<a href='".Mage::getUrl('customer/account/forgotpassword')."' class='create_account_forget pull-right' >Forget Password</a>";
			//$html .= "</form>";			
			$html .= "</div>";
			$html .= "<div class='clearfix'></div>";
			$html .= "<div class='modal-footer'>";
			$html .= "<a href='".Mage::getUrl('customer/account/create')."' class='btn btn-primary create_account_modal' >Create an Account</a>";
			$html .= "</div>";
			$html .= "</div>";
			echo $html;		
		}else{
			 echo 1; 			
		}
	}
	
	public function bidloginAction(){
		$email = $_REQUEST['email'];	
		$password = $_REQUEST['pass'];	
		$id = $_REQUEST['id'];	
		
		$websiteId = Mage::app()->getWebsite()->getId();
		$store = Mage::app()->getStore();
		$customer = Mage::getModel("customer/customer");
		$customer->website_id = $websiteId;
		$customer->setStore($store);
		try {
			$customer->loadByEmail($email);
			$session = Mage::getSingleton('customer/session')->setCustomerAsLoggedIn($customer);
			$session->login($email, $password);		
			echo 1; 
		}catch(Exception $e){
			print_r($e->getMessage());
		}		
	}
	
	
	public function sellerplanreviewAction()
    {		
		$this->loadLayout(array('default','sellerplan_index_review'));
		$this->getLayout()->getBlock('head')->setTitle( Mage::helper('sellerplan')->__('Plan Review'));
		$this->renderLayout();
	}
	
	public function paynowdataAction(){
		
		$planid = $_REQUEST['planid'];
		if(!empty($planid)) {
			$data = Mage::getModel('sellerplan/sellerplan')->load($planid);
			$planname = $data->getplan_title();
			$planproduct = trim($data->getproduct_num());
			$_finalPrice = $data->getplan_price();
			$_price = $data->getoffer_price();

			if(!empty($_price)) {
				$amount	= trim($data->getoffer_price());
			} else {
				$amount	= trim($data->getplan_price());
			}
			//$famount = round($amount/$planproduct);
			
			$merchant = Mage::getStoreConfig('goigi/goigi_group/sandbox_email');
			$currency_code = Mage::app()->getStore()->getCurrentCurrencyCode();		
			$customer = Mage::getSingleton('customer/session')->getCustomer();    
			$firstname = $customer->getFirstname(); // First Name    
			$lastname = $customer->getLastname(); // Last Name      
			$email = $customer->getEmail();
			$cid = $customer->getId();	
			
			$data = "<input id='business' name='business' value='".$merchant."' type='hidden'/>";
			$data .= "<input id='invoice' name='invoice' value='".rand(000,99999).'-'.$cid."' type='hidden'/>";
			$data .= "<input id='currency_code' name='currency_code' value='".$currency_code."' type='hidden'/>";
			$data .= "<input id='paymentaction' name='paymentaction' value='sale' type='hidden'/>";
			
			$data .= "<input id='return' name='return' value='".Mage::getBaseUrl().'sellerplan/index/accountplan/'."' type='hidden'/>";
			$data .= "<input id='cancel_return' name='cancel_return' value='".Mage::getBaseUrl().'sellerplan/index/sellerplanreview/'.'id/'.$planid."' type='hidden'/>";
			$data .= "<input id='notify_url' name='notify_url' value='".Mage::getBaseUrl().'sellerplan/index/ipnnotify'."' type='hidden'/>";
			$data .= "<input id='bn' name='bn' value='Varien_Cart_WPS_US' type='hidden'/>";
			$data .= "<input id='charset' name='charset' value='utf-8' type='hidden'/>";
			$data .= "<input id='item_name_1' name='item_name_1' value='".$planname."' type='hidden'/>";
			
			$data .= "<input id='amount_1' name='amount_1' value='".$amount."' type='hidden' />";
			$data .= "<input id='quantity_1' name='quantity_1' value='1' type='hidden'/>";
			
			$data .= "<input id='cmd' name='cmd' value='_cart' type='hidden'/>";
			$data .= "<input id='upload' name='upload' value='1' type='hidden'/>";
			$data .= "<input id='tax_cart' name='tax_cart' value='0.00' type='hidden'/>";
			$data .= "<input id='discount_amount_cart' name='discount_amount_cart' value='0.00' type='hidden'/>";
			$data .= "<input id='custom' name='custom' value='".$cid."/".$planproduct."' type='hidden'/>";			
			$data .= "<input id='email_id' name='email_id' value='".$email."' type='hidden'/>";
			$data .= "<input id='first_name' name='first_name' value='".$firstname."' type='hidden'/>";
			$data .= "<input id='last_name' name='last_name' value='".$lastname."' type='hidden'/>";		
			
			echo $data;
			die;
		} else {
			echo "false";
			die;
		}
	}
	
	public function transaction($wholedata)
    {				
		$custom = $wholedata['custom'];
				
		$pieces = explode("/", $custom);
		$email = $pieces[0]; // email
		$tplanpro = $pieces[1]; // qty	
				
		$data['customeremail'] 		= $email;
		$data['bidplantype'] 		= $wholedata['item_name1'];
		$data['bidproduct'] 		= $tplanpro;
		$data['invoice']			= $wholedata['invoice'];	
		$data['payer_id']			= $wholedata['payer_id'];
		$data['payer_status'] 		= $wholedata['payer_status'];
		$data['payer_email'] 		= $wholedata['payer_email'];
		$data['payment_date'] 		= $wholedata['payment_date'];
		$data['payment_status']		= $wholedata['payment_status'];		
		$data['pending_reason']		= $wholedata['pending_reason'];		
		$data['verify_sign']		= $wholedata['verify_sign'];		
		$data['txn_id']				= $wholedata['txn_id'];		
		$data['payment_gross']		= $wholedata['payment_gross'];		
		$data['bidprice']			= $wholedata['payment_gross'];		
		$data['mc_currency']		= $wholedata['mc_currency'];		
		$data['ipn_track_id']		= $wholedata['ipn_track_id'];		
		$data['status']				= 1;	
		
		$model = Mage::getModel('sellerplan/managetransaction');		
		$model->setData($data)->setId($this->getRequest()->getParam('id'));

		try {
			if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
				$model->setCreatedTime(now())
					->setUpdateTime(now());
			} else {
				$model->setUpdateTime(now());
			}											
			
			$model->save();
				echo "Record successfully Update";
			} catch (Exception $e) {
				echo "Record successfully Not Update";
			}	
			$this->afterpayment($data);
	}
	
	public function afterpayment($data)
    {				
		$txn_id =  $data['txn_id'];		
		$email =  $data['customeremail'];		
		$transmodel = Mage::getModel('sellerplan/managetransaction')->load($txn_id,'txn_id');	
		$payment_status		= $transmodel['payment_status'];			
		
		$data['customeremail'] =  $email;		
		$data['bidplantype']	= $transmodel['bidplantype'];
		$data['bidprice'] 		= $transmodel['bidprice'];
		$data['bidproduct']		= $transmodel['bidproduct'];
		$data['status']			= 1;
				
		$results = Mage::getModel('sellerplan/managecustomer')->load($email,'customeremail');
			
		$cid = $results['sellercustomerbid_id'];			
		
		if(!empty($cid)){
			if($payment_status == 'Completed'){
				$customerdata = Mage::getModel('sellerplan/managecustomer')->load($cid);$availableproduct = $customerdata->getBidavailable();
				$data['bidavailable']	= $data['bidproduct'] + $availableproduct;	
			} else {
				$data['bidavailable']	= $data['bidproduct'];
			}
		} else {			
			$data['bidavailable']	= $data['bidproduct'];
		}
				
		$model = Mage::getModel('sellerplan/managecustomer');		
		$model->setData($data)->setId($cid);
					
		try {
			if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
				$model->setCreatedTime(now())
					->setUpdateTime(now());
			} else {
				$model->setUpdateTime(now());
			}											
			
			$model->save();			
			} catch (Exception $e) {
				Mage::log(print_r($e->Message(), true), null, 'paypal.log');				
			}			   		
	}
			
	public function ipnnotifyAction(){			
		$wholedata=$this->getRequest()->getParams();		
		$this->transaction($wholedata);		
	}			
}