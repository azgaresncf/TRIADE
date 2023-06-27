<?php 
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: dilicom.class.php,v 1.5 2018-10-04 13:24:12 vtouchard Exp $

require_once($class_path.'/curl.class.php');

class dilicom {
	protected $parameters;
	protected $curl_instance;
	
	public function __construct(){
		global $pmb_pnb_param_login, $pmb_pnb_param_password;
		$this->curl_instance = new Curl();
		$this->curl_instance->set_option('CURLOPT_SSL_VERIFYPEER', false);
		$this->curl_instance->set_option('CURLOPT_HTTPAUTH', CURLAUTH_BASIC);
		$this->curl_instance->set_option('CURLOPT_USERPWD', $pmb_pnb_param_login.':'.$pmb_pnb_param_password);
		$this->init_parameters();
	}
	
	public function query($function = '', $parameters = array()){
		global $pmb_pnb_param_dilicom_url;
		$parameters = array_merge($this->parameters, $parameters);
		if(is_string($function) && $function != ""){
			$response = $this->curl_instance->post($pmb_pnb_param_dilicom_url.$function, $parameters);
			return $response->__toString();
		}
		return false;
	}
	
	protected function init_parameters() {
		global $pmb_pnb_param_login;
		$this->parameters = array(
				'glnContractor' => $pmb_pnb_param_login
		);
	}
	
	public static function is_pnb_active(){
	    global $pmb_pnb_param_login, $pmb_pnb_param_password, $pmb_pnb_param_dilicom_url;
	    if(!empty($pmb_pnb_param_login) && !empty($pmb_pnb_param_password) && !empty($pmb_pnb_param_dilicom_url)){
	        return true;
	    }
	    return false;
	}
}