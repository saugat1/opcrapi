<?php


function post_data($datas=null, $headers = null){

$url = "http://opcrinfo.000webhostapp.com/api/opcrinfo/newclient";

$ch = curl_init($url);

if($headers != null){
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

}


if($datas != null ){

	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);

}

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE );
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$result = curl_exec($ch);
curl_close($ch);

return $result;



}


$json_input = file_get_contents("php://input");

$decoded_json_data = json_decode($json_input,true);

if(array_key_exists("add", $decoded_json_data)){
	//now add the record with oauthor 

	$data = [
		'name' => $decoded_json_data['name'],
		"email" =>$decoded_json_data['email'],
		"father" =>$decoded_json_data['father'],
		"mother" =>$decoded_json_data['mother'],
		"dob" =>$decoded_json_data['dob'],
		"gender" =>$decoded_json_data['gender'],
		"password" =>  $decoded_json_data['password'] ?? 'password123',
		"author" => 1
	];
	
	
	$headers = null;
	
	$response = post_data($data, $headers);
	echo json_encode($response, JSON_PRETTY_PRINT);

}else{
	json_encode(["success" => false]);
	exit;
}





?>
