<?php

class Configuration{
    public static function configure(){
        if(file_exists($_SERVER['DOCUMENT_ROOT'].'/qbo/config.json')){
            $configs = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/qbo/config.json'));
            
            define("APP", $configs->app);
            define("AUTH_MODE", $configs->auth_mode);
            define("CLIENT_ID", $configs->client_id);
            define("CLIENT_SECRET", $configs->client_secret);
            define("REDIRECT_URI", $configs->redirect_uri);
            define("SCOPE", $configs->scope);
            define("BASE_URL", $configs->base_url);
            define("SERVER_NAME", $configs->server_name);
            define("DATABASE", $configs->database);
            define("DB_USER", $configs->db_user);
            define("DB_PASSWORD", $configs->db_password);
        
        }
        else{
            echo "Configuration file missing";
            exit;
        }
    }
}