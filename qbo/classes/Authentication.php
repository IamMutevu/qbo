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
            'realmId' => $realmId
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
            $connection = DatabaseConnection::connect();
            $query = $connection->prepare("UPDATE `access_tokens` SET state = ?, updated_at = ? WHERE app = ? ");
            $query->execute(array("revoked", date("d-m-Y H:i"), APP));
            $connection = null;
        }
    }

    public static function retrieveAccessToken(){
        $connection = DatabaseConnection::connect();
        $query = $connection->prepare("SELECT access_tokens.token, access_tokens.updated_at FROM access_tokens WHERE app = ? AND state = ? ORDER BY id DESC");
        $query->execute(array(APP, "active"));
        $connection = null;
        return $query->fetch(PDO::FETCH_OBJ);
    }

    private function storeAccessToken($user_id, $access_token){
        $connection = DatabaseConnection::connect();
        $query = $connection->prepare("INSERT INTO `access_tokens`(token, user_id, app, state, created_at, updated_at, timestamp) VALUES(?, ?, ?, ?, ?, ?, ?)");
        $query->execute(array($access_token, $user_id, APP, "active", date("d-m-Y H:i"), date("d-m-Y H:i"), time()));
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

    public static function getAuthenticatedDataService(){
        $access_token_record = self::retrieveAccessToken();
        $access_token_object = json_decode($access_token_record->token);
        $elapsed_time = time() - strtotime($access_token_record->updated_at);
        

        if($elapsed_time >= 3600){
            $dataService = DataService::Configure(array(
                'auth_mode' => AUTH_MODE,
                'ClientID' => CLIENT_ID,
                'ClientSecret' => CLIENT_SECRET,
                'accessTokenKey' => $access_token_object->access_token,
                'refreshTokenKey' => $access_token_object->refresh_token,
                'QBORealmID' => $access_token_object->realmId,
                'baseUrl' => BASE_URL
            ));

            $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
            $refreshedAccessTokenObj = $OAuth2LoginHelper->refreshToken();
            $error = $OAuth2LoginHelper->getLastError();
            
            if($error){

            }
            else{
              //Refresh Token is called successfully
              $dataService->updateOAuth2Token($refreshedAccessTokenObj);
            }
        }
        else{
            $dataService = DataService::Configure(array(
                'auth_mode' => AUTH_MODE,
                'ClientID' => CLIENT_ID,
                'ClientSecret' => CLIENT_SECRET,
                'accessTokenKey' => $access_token_object->access_token,
                'refreshTokenKey' => $access_token_object->refresh_token,
                'QBORealmID' => $access_token_object->realmId,
                'baseUrl' => BASE_URL
            ));
        }

        $dataService->throwExceptionOnError(true);
        return $dataService;
    }
}