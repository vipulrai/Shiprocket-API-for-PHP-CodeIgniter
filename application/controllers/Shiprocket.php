<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shiprocket extends CI_Controller {

	public function __construct(){
	    error_reporting(0);
        parent::__construct();
        $this->load->library(array('form_validation','session','cart'));
		//$this->load->database();
    }
	
	public function index(){
		$this->load->view('shiprocketView');
	}

	public function shiprocketAuth(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/auth/login',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "email": "info@codypaste.com",
            "password": "asdfgadf9876^%$"
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        $tknresponse = curl_exec($curl);
        curl_close($curl);
        $tknres =   json_decode($tknresponse, true);
        $tokenRes   = $tknres['token'];
        return $tokenRes;
    }
	
	public function shiprocketSendToCustomer(){		
		$order_id				=   "CODYPASTE-01"; // Unique order id
		$order_date				=   "2022-12-14"; // Current date, YY-MM-DD
		$channel_id				=   "123456"; // From Shiprocket Panel, Login to shiprocket dashboard
		$billing_customer_name	=  "Vipul"; // Courier Receiver Name
		$billing_last_name		=   "Rai"; // Courier Receiver Last Name
		$billing_address		=   "401, Frinds Enclave"; // Courier Receiver
		$billing_address_2		=   "Shahberi"; // Courier Receiver
		$billing_city			=   "Noida"; // Courier Receiver
		$billing_state			=   "Uttarpradesh"; // Courier Receiver		
		$billing_pincode		=   "201009";		
		$billing_email			=   "info@asd.com";
		$billing_phone			=   "9999999999";		
		$name					=   "Cody Paste T-Shirt"; // Product name
		$sku					=   "CPTS-01"; // Product SKU
		$units					=   "1"; // Number of product
		$selling_price			=   "450"; // Price of product
		$discount				=   "0"; // discount of product
		$payment_method			=   "Prepaid";
		$sub_total				=   "450"; // Subtotal of product
		$length					=   "30"; // in centimeter
		$breadth				=   "25"; // in centimeter
		$height					=   "10"; // in centimeter
		$weight					=   "1.59";	//in Kilogram (KG)	
		
		$tokenRes   = $this->shiprocketAuth();
		$curl 		= curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/orders/create/adhoc',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>'{
			"order_id": "'.$order_id.'",
			"order_date": "'.$order_date.'",
			"pickup_location": "Primary",
			"channel_id": "'.$channel_id.'",
			"comment": "Cody Paste",
			"billing_customer_name": "'.$billing_customer_name.'",
			"billing_last_name": "'.$billing_last_name.'",
			"billing_address": "'.$billing_address.'",
			"billing_address_2": "'.$billing_address_2.'",
			"billing_city": "'.$billing_city.'",
			"billing_pincode": '.$billing_pincode.',
			"billing_state": "'.$billing_state.'",
			"billing_country": "India",
			"billing_email": "'.$billing_email.'",
			"billing_phone": "'.$billing_phone.'",
			"shipping_is_billing": true,
			"shipping_customer_name": "Cody Paste",
			"shipping_last_name": "",
			"shipping_address": "",
			"shipping_address_2": "",
			"shipping_city": "",
			"shipping_pincode": "",
			"shipping_country": "",
			"shipping_state": "",
			"shipping_email": "",
			"shipping_phone": "",
			
			"order_items": [
			{
			  "sku": "'.$sku.'",
			  "name": "'.$name.'",
			  "units": '.$units.',
			  "selling_price": '.$selling_price.',
			  "discount": '.$discount.',
			  "qc_enable":false,
			  "hsn": "",
			  "brand":"",
			  "qc_size":""
			   }
			],
			"payment_method": "'.$payment_method.'",
			"shipping_charges": 0,
			"giftwrap_charges": 0,
			"transaction_charges": 0,
			"total_discount": 0,
			"sub_total": '.$sub_total.',
			"length": '.$length.',
			"breadth": '.$breadth.',
			"height": '.$height.',
			"weight": '.$weight.'
			}',
		  CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json',
			'Authorization: Bearer '.$tokenRes.''
		  ),
		));
		
		$response = curl_exec($curl);
		
		curl_close($curl);
	}
	
	public function shiprocketPickupFromCustomer(){
		$order_id                   =   "CODYPASTE-02"; // Unique order id
		$order_date                 =   "2022-12-14"; // Current date, YY-MM-DD
		$channel_id                 =   "123456"; // From Shiprocket Panel, Login to shiprocket dashboard
		$pickup_customer_name       =   "Vipul"; // Customer name, from whre you want to pickup
		$pickup_last_name           =   "Rai"; // Customer
		$pickup_address             =   "401, Living Homes";
		$pickup_address_2           =   "Friends Enclave";
		$pickup_city                =   "Noida";
		$pickup_state               =   "Uttarpradesh";		
		$pickup_pincode             =   "201009";
		$pickup_email               =   "vips.rai@gmail.com";
		$pickup_phone               =   "9999999999";
		$shipping_customer_name     =   "Cody Paste"; // Name of Courier Sender.
		$shipping_address           =   "345, Canaught Place";
		$shipping_address_2         =   "Kamala Market";
		$shipping_city              =   "New Delhi";
		$shipping_country           =   "India";
		$shipping_pincode           =   "110033";
		$shipping_state             =   "Delhi";
		$shipping_email             =   "info@codypaste.com";
		$shipping_phone             =   "8989899878";
		$order_items                =   "/";
		$name                       =   "Cody Paste T-Shirt"; // Order Product Name
		$sku                        =   "CPTS01"; // Product SKU
		$units                      =   "1"; // Number of products
		$selling_price				=   "450"; // Price of product
		$discount					=   "0"; // discount of product
		$payment_method				=   "Prepaid";
		$sub_total					=   "450"; // Subtotal of product
		$length						=   "30"; // in centimeter
		$breadth					=   "25"; // in centimeter
		$height						=   "10"; // in centimeter
		$weight						=   "1.59";	//in Kilogram (KG)	
		
		$tokenRes   = $this->shiprocketAuth();
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/orders/create/return',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>'{
			"order_id": "'.$order_id.'",
			"order_date": "'.$order_date.'",
			"channel_id": "'.$channel_id.'",
			"pickup_customer_name": "'.$pickup_customer_name.'",
			"pickup_last_name": "'.$pickup_last_name.'",
			"company_name":"Cody Paste",
			"pickup_address": "'.$pickup_address.'",
			"pickup_address_2": "'.$pickup_address_2.'",
			"pickup_city": "'.$pickup_city.'",
			"pickup_state": "'.$pickup_state.'",
			"pickup_country": "India",
			"pickup_pincode": '.$pickup_pincode.',
			"pickup_email": "'.$pickup_email.'",
			"pickup_phone": "'.$pickup_phone.'",
			"pickup_isd_code": "91",
			"shipping_customer_name": "'.$shipping_customer_name.'",
			"shipping_last_name": "",
			"shipping_address": "'.$shipping_address.'",
			"shipping_address_2": "'.$shipping_address_2.'",
			"shipping_city": "'.$shipping_city.'",
			"shipping_country": "India",
			"shipping_pincode": '.$shipping_pincode.',
			"shipping_state": "'.$shipping_state.'",
			"shipping_email": "'.$shipping_email.'",
			"shipping_isd_code": "91",
			"shipping_phone": '.$shipping_phone.',
			"order_items": [
			{
			  "sku": "'.$sku.'",
			  "name": "'.$name.'",
			  "units": '.$units.',
			  "selling_price": '.$selling_price.',
			  "discount": '.$discount.',
			  "qc_enable":false,
			  "hsn": "",
			  "brand":"",
			  "qc_size":""
			   }
			],
			"payment_method": "'.$payment_method.'",
			"total_discount": "0",
			"sub_total": '.$sub_total.',
			"length": '.$length.',
			"breadth": '.$breadth.',
			"height": '.$height.',
			"weight": '.$weight.'
			}',
		  CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json',
			'Authorization: Bearer '.$tokenRes.''
		  ),
		));
		
		$response = curl_exec($curl);
		
		curl_close($curl);
		//echo $response;
    		    
	}
	
	
}