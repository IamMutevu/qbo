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
                "TotalAmt" => $data['amount'],
                "TxnDate" => $data['pay_date'],
                "Line" => []
            ]);

            $resultingObj = $dataService->Add($theResourceObj);

            if($resultingObj){
                return $resultingObj;
            }
            else{
                $error = $dataService->getLastError();
                throw new Exception("Payment not added. Error: ".json_encode($error->getResponseBody()));
                error_log("Payment not added. Error: ".json_encode($error->getResponseBody()));
            }
        } 
        catch (\Throwable $th) {
            error_log($th->getMessage());
            throw new Exception("An error. Error: ".json_encode($th->getMessage()));
        }

    }
}