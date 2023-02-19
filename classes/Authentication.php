<?php

require 'Configuration.php';

use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Core\OAuth\OAuth2\OAuth2LoginHelper;

Configuration::configure();
require 'DatabaseConnection.php';

class Authentication{
    public static function getAuthorizationUrl(){
        $dataService = self::getBasicDataService();
        
        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $authorizationCodeUrl = $OAuth2LoginHelper->getAuthorizationCodeURL();
        return $authorizationCodeUrl;
    }

    public static function getAccessToken($code, $realmId, $user_id){
        $dataService = self::getBasicDataService();

        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $accessTokenObj = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($code, $realmId);

        $access_token = array(
            'access_token' => $accessTokenObj->getAccessToken(),
            'refresh_token' => $accessTokenObj->getRefreshToken(),
        );

        self::storeAccessToken($user_id, json_encode($access_token));
    }

    public static function revokeAccessToken(){
        $access_token = json_decode(self::retrieveAccessToken()->access_token);

        //The first parameter of OAuth2LoginHelper is the ClientID, second parameter is the client Secret
        $oauth2LoginHelper = new OAuth2LoginHelper(CLIENT_ID,  CLIENT_SECRET);
        
        $revokeResult = $oauth2LoginHelper->revokeToken($access_token['refresh_token']);
        
        if($revokeResult){
            // Update token state to revoked
            echo "RefreshToken Token revoked.";
        }
    }

    public static function retrieveAccessToken(){
        $connection = DatabaseConnection::connect();
        $query = $connection->prepare("SELECT access_tokens.token, access_tokens.updated_at  FROM access_tokens WHERE app = ?");
        $query->execute(array(APP));
        $connection = null;
        return $query->fetch(PDO::FETCH_OBJ);
    }

    private function storeAccessToken($user_id, $access_token){
        $connection = DatabaseConnection::connect();
        $query = $connection->prepare("INSERT INTO `access_tokens`(token, user_id, app, created_at, updated_at) VALUES(?, ?, ?, ?, ?)");
        $query->execute(array($access_token, $user_id, APP, date("d-m-Y H:i"), date("d-m-Y H:i")));
        $connection = null;
    }

    private static function updateStoredAccessToken($access_token){
        $connection = DatabaseConnection::connect();
        $query = $connection->prepare("UPDATE `access_tokens` SET token = ?, updated_at = ? WHERE app = ? ");
        $query->execute(array($access_token, date("d-m-Y H:i"), APP));
        $connection = null;
    }

    public static function getBasicDataService(){
        $dataService = DataService::Configure(array(
            'auth_mode' => AUTH_MODE,
            'ClientID' => CLIENT_ID,
            'ClientSecret' => CLIENT_SECRET,
            'RedirectURI' => REDIRECT_URI,
            'scope' => SCOPE,
            'baseUrl' => BASE_URL
        ));

        return $dataService;
    }

    private static function getAuthenticatedDataService(){
        $dataService = DataService::Configure(array(
            'auth_mode' => AUTH_MODE,
            'ClientID' => CLIENT_ID,
            'ClientSecret' => CLIENT_SECRET,
            'RedirectURI' => REDIRECT_URI,
            'scope' => SCOPE,
            'baseUrl' => BASE_URL
        ));

        return $dataService;
    }
}