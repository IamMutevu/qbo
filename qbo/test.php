<?php
// include $_SERVER['DOCUMENT_ROOT'].'/qbo/index.php';

require 'vendor/autoload.php';

use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Facades\Customer;


// Get parameters of incoming requests
if (!empty($_POST)) {
    $params = $_POST;

} elseif (!empty($_GET)) {
    $params = $_GET;
} else {
    $params = json_decode(file_get_contents("php://input"), true);
}


try {
    $dataService = DataService::Configure(array(
        'auth_mode' => 'oauth2',
        'ClientID' => "ABtJcXZSsRvc8To63FdSLJGlXSM5BIMhqJEVHhos4NITtEEtP6",
        'ClientSecret' => "tJRGvHQ9o38eWz9TnfMkbiMZN20x04RlqteDUdm9",
        'RedirectURI' => "https://4af8-102-2-154-5.in.ngrok.io/qbo/test.php",
        'scope' => "com.intuit.quickbooks.accounting",
        'baseUrl' => "Production"
    ));

    $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();

    $accessTokenObj = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($params['code'], $params['realmId']);

    $dataService = DataService::Configure(array(
        'auth_mode' => 'oauth2',
        'ClientID' => "ABtJcXZSsRvc8To63FdSLJGlXSM5BIMhqJEVHhos4NITtEEtP6",
        'ClientSecret' => "tJRGvHQ9o38eWz9TnfMkbiMZN20x04RlqteDUdm9",
        'accessTokenKey' => $accessTokenObj->getAccessToken(),
        'refreshTokenKey' => $accessTokenObj->getRefreshToken(),
        'QBORealmID' => $params['realmId'],
        'baseUrl' => "Production"
    ));

    $dataService->setLogLocation("qbo-log");
    $dataService->throwExceptionOnError(true);


$customer = $dataService->FindbyId('customer', 1);
$error = $dataService->getLastError();
if ($error) {
    echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
    echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
    echo "The Response message is: " . $error->getResponseBody() . "\n";
}
else {
    echo "Created Id={$customer->Id}. Reconstructed response body:\n\n";
    $xmlBody = XmlObjectSerializer::getPostXmlFromArbitraryEntity($customer , $urlResource);
    echo $xmlBody . "\n";
}

    // $theResourceObj = Customer::create([
    //     "BillAddr" => [
    //         "Line1" => "123 Main Street",
    //         "City" => "Mountain View",
    //         "Country" => "USA",
    //         "CountrySubDivisionCode" => "CA",
    //         "PostalCode" => "92"
    //     ],
    //     "Notes" => "Here are other details.",
    //     "Title" => "Mr",
    //     "GivenName" => "CRUD",
    //     "MiddleName" => "B",
    //     "FamilyName" => "CRUD",
    //     "Suffix" => "Jr",
    //     "FullyQualifiedName" => "JamesCRUD Test",
    //     "CompanyName" => "King L CRUD",
    //     "DisplayName" => "James CRUD",
    //     "PrimaryPhone" => [
    //         "FreeFormNumber" => "(555) 545-5555"
    //     ],
    //     "PrimaryEmailAddr" => [
    //         "Address" => "redsaw@myemail.com"
    //     ]
    // ]);


    // $resultingObj = $dataService->Add($theResourceObj);
    // $result = json_encode($resultingObj, JSON_PRETTY_PRINT);
    // echo $result;  
} catch (Exception $e) {
    echo $e->getMessage();
    error_log($e->getMessage());
}
