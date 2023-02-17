<?php

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

}