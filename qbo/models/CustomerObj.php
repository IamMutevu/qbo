<?php

class CustomerObj{
    public $id = '';
    public $name = '';
    public $email = '';
    public $phone = '';
    public $suffix = '';
    public $title = '';
    public $middle_name = '';
    public $notes = '';
    public $sur_name = '';
    public $country_code = '';
    public $city = '';
    public $postal_code = '';
    public $line = '';
    public $country = '';
    public $given_name = '';
    public $company_name = '';

    public function __construct($array){
        if(array_key_exists("name",$array)){
            $this->name = $array['name'];
        }
        else{
            throw new Exception("Missing name");
            exit;
        }

        if(array_key_exists("phone",$array)){
            $this->phone = $array['phone'];
        }
        else{
            throw new Exception("Missing phone");
            exit;
        }

        if(array_key_exists("id",$array)){
            $this->id = $array['id'];
        }
        if(array_key_exists("email",$array)){
            $this->email = $array['email'];
        }
        if(array_key_exists("title",$array)){
            $this->title = $array['title'];
        }
        if(array_key_exists("suffix",$array)){
            $this->suffix = $array['suffix'];
        }
        if(array_key_exists("middle_name",$array)){
            $this->middle_name = $array['middle_name'];
        }
        if(array_key_exists("notes",$array)){
            $this->notes = $array['notes'];
        }
        if(array_key_exists("sur_name",$array)){
            $this->sur_name = $array['sur_name'];
        }
        if(array_key_exists("country_code",$array)){
            $this->country_code = $array['country_code'];
        }
        if(array_key_exists("city",$array)){
            $this->city = $array['city'];
        }
        if(array_key_exists("postal_code",$array)){
            $this->postal_code = $array['postal_code'];
        }
        if(array_key_exists("line",$array)){
            $this->line = $array['line'];
        }
        if(array_key_exists("country",$array)){
            $this->country = $array['country'];
        }
        if(array_key_exists("given_name",$array)){
            $this->given_name = $array['given_name'];
        }
        if(array_key_exists("company_name",$array)){
            $this->company_name = $array['company_name'];
        }
    }
}