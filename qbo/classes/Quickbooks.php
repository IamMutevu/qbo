<?php

require 'Customer.php';
require 'Payment.php';

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
        return QBOCustomer::addCustomer($data);
    }

    public function getCustomerById($id){
        QBOCustomer::getCustomerById($id);
    }

    public function addPayment($data){
        $customer = $this->getCustomerLink($data['customer']['id']);
        if($customer){
            $api_customer_id = $customer->api_customer_id;
        }
        else{
            $api_customer_id = QBOCustomer::addCustomer($data['customer']);
        }

        QBOPayment::addPayment($data['payment'], $api_customer_id);
    }

    public function testPayment($data, $api_customer_id){
        QBOPayment::addPayment($data, $api_customer_id);
    }

    private function getCustomerLink($id){
        $connection = DatabaseConnection::connect();
        $query = $connection->prepare("SELECT api_customer_id FROM apis_customer_link WHERE app = ? AND client_id = ? LIMIT 1");
        $query->execute(array(APP, $id));
        $connection = null;
        return $query->fetch(PDO::FETCH_OBJ);
    }
}