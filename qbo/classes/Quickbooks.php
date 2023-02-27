<?php

require 'Customer.php';

class Quickbooks{
    public function __construct(){
    }

    public function getAuthUrl(){
        return Authentication::getAuthorizationUrl();
    }

    public function isAuthenticated(){
        $token = Authentication::retrieveAccessToken();

        if($token != false){
            return true;
        }
        else{
            return false;
        }
    }

    public function testAuth(){
        Authentication::getAuthenticatedDataService();
    }

    public function addCustomer($data){
        QBOCustomer::addCustomer($data);
    }

    public function getCustomerById($id){
        QBOCustomer::getCustomerById($id);
    }

    public function addPayment(){
        
    }
}