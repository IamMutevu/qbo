<?php

use QuickBooksOnline\API\DataService\DataService;

class Authentication{
    public static function getAuthorizationUrl(){
        $dataService = DataService::Configure(array(
            'auth_mode' => 'oauth2',
            'ClientID' => "ABtJcXZSsRvc8To63FdSLJGlXSM5BIMhqJEVHhos4NITtEEtP6",
            'ClientSecret' => "tJRGvHQ9o38eWz9TnfMkbiMZN20x04RlqteDUdm9",
            'RedirectURI' => "https://mutevu.com/authorize.php",
            'scope' => "com.intuit.quickbooks.accounting",
            'baseUrl' => "Production"
        ));
        
        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $authorizationCodeUrl = $OAuth2LoginHelper->getAuthorizationCodeURL();
        return $authorizationCodeUrl;
    }
}