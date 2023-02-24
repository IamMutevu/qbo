<?php

class Configuration{
    public static function configure(){
        if(file_exists($_SERVER['DOCUMENT_ROOT'].'/qbo/qbo/config.json')){
            $configs = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/qbo/qbo/config.json'));
            
            if(!defined("APP")){
                define("APP", $configs->app);
            }
            if(!defined("AUTH_MODE")){
                define("AUTH_MODE", $configs->auth_mode);
            }
            if(!defined("CLIENT_ID")){
                define("CLIENT_ID", $configs->client_id);
            }
            if(!defined("CLIENT_SECRET")){
                define("CLIENT_SECRET", $configs->client_secret);
            }
            if(!defined("REDIRECT_URI")){
                define("REDIRECT_URI", $configs->redirect_uri);
            }
            if(!defined("SCOPE")){
                define("SCOPE", $configs->scope);
            }
            if(!defined("BASE_URL")){
                define("BASE_URL", $configs->base_url);
            }
            if(!defined("SERVER_NAME")){
                define("SERVER_NAME", $configs->server_name);
            }
            if(!defined("DATABASE")){
                define("DATABASE", $configs->database);
            }
            if(!defined("DB_USER")){
                define("DB_USER", $configs->db_user);
            }
            if(!defined("DB_PASSWORD")){
                define("DB_PASSWORD", $configs->db_password);
            }

        }
        else{
            echo "Configuration file missing";
            exit;
        }
    }
}