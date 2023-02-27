<?php

use QuickBooksOnline\API\Facades\Customer;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;

class QBOCustomer{
	public static function addCustomer($data){
		try {
			$dataService = Authentication::getAuthenticatedDataService();
			$customer = self::validateCustomerData($data);
	
			$customerToCreate = Customer::create([
				"FullyQualifiedName" => $customer->name,
				"PrimaryEmailAddr" => [
					"Address" => $customer->email,
				],
				"DisplayName" => $customer->name,
				"Suffix" => $customer->suffix,
				"Title" => $customer->title,
				"MiddleName" => $customer->middle_name,
				"Notes" => $customer->notes,
				"FamilyName" => $customer->sur_name,
				"PrimaryPhone" => [
					"FreeFormNumber" => $customer->phone,
				],
				"CompanyName" => $customer->company_name,
				"BillAddr" => [
					"CountrySubDivisionCode" => $customer->country_code,
					"City" => $customer->city,
					"PostalCode" => $customer->postal_code,
					"Line1" => $customer->line,
					"Country" => $customer->country,
				],
				"GivenName" => $customer->given_name,
			]);	
	
			$resultObj = $dataService->Add($customerToCreate);
			self::linkCustomerRecord($customer->id, $resultObj->Id);
			return $resultObj->Id;
		} 
		catch (\Throwable $th) {
			error_log($th->getMessage());
		}

	}

	public static function getCustomerById($id){
		$dataService = Authentication::getAuthenticatedDataService();
		$customer = $dataService->FindbyId('customer', $id);
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

	}

	private static function linkCustomerRecord($client_id, $api_customer_id){
        $connection = DatabaseConnection::connect();
        $query = $connection->prepare("INSERT INTO `apis_customer_link`(client_id, api_customer_id, app, created_at, updated_at, timestamp) VALUES(?, ?, ?, ?, ?)");
        $query->execute(array($client_id, $api_customer_id, APP, date("d-m-Y H:i"), date("d-m-Y H:i"), time()));
        $connection = null;
	}

	private static function validateCustomerData($data){
		return json_decode(json_encode($data));
	}
}