<?php

use QuickBooksOnline\API\Facades\Payment;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;

class QBOPayment{
    public static function addPayment($data, $customer_id){
        try {
            $dataService = Authentication::getAuthenticatedDataService();

            $theResourceObj = Payment::create([
                "CustomerRef" =>
                [
                    "value" => $customer_id
                ],
                "TotalAmt" => $data->amount,
              ]);
    
              $resultingObj = $dataService->Add($theResourceObj);
              $error = $dataService->getLastError();
              return $resultingObj;
        } 
        catch (\Throwable $th) {
            error_log($th->getMessage());
        }

    }
}