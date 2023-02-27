<?php

use QuickBooksOnline\API\Facades\Payment;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;

class QBOPayment{
    public static function addPayment($data, $customer_id){
        $dataService = Authentication::getAuthenticatedDataService();

        $theResourceObj = Payment::create([
            "CustomerRef" =>
            [
                "value" => $customer_id
            ],
            "TotalAmt" => $data->amount,
            "Line" => [
            [
                "Amount" => $data->amount,
                "LinkedTxn" => [
                [
                    "TxnId" => "210",
                    "TxnType" => "Invoice"
                ]]
            ]]
          ]);

          $resultingObj = $dataService->Add($theResourceObj);
          $error = $dataService->getLastError();
          if ($error) {
              echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
              echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
              echo "The Response message is: " . $error->getResponseBody() . "\n";
          }
          else {
              echo "Created Id={$resultingObj->Id}. Reconstructed response body:\n\n";
              $xmlBody = XmlObjectSerializer::getPostXmlFromArbitraryEntity($resultingObj, $urlResource);
              echo $xmlBody . "\n";
          }
    }
}