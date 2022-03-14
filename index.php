<?php 

if($_SERVER['REQUEST_MEDHOD'] == 'GET'){
	echo "hello this is index page running now \n welcome back";
	exit();
}

header("Access-Control-Allow-Origin: *");
 header("Access-Control-Allow-Credentials: true");
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$api_url = "http://ecommerceapi2021.000webhostapp.com/opcr/api.php";


$json = file_get_contents("php://input");
$decoded_json = json_decode($json,true);

if(isset($decoded_json['name'])){
	// echo json_encode($decoded_json);exit;
	$name = $decoded_json['name'];
	$email = $decoded_json['email'];
	$father = $decoded_json['father'];
	$mother = $decoded_json['mother'];
	$gender = $decoded_json['gender'];
	$dob = $decoded_json['dob'];

$jsondata = json_encode([
	"name" => $name, "email" => $email, "father" => $father, "mother" => $mother, "gender" => $gender,
	"dob" => $dob, "add" => true
]);

//post data with url and json 
$l = postApi($api_url, $json);

if($l){
	//success 
	echo json_encode($l);
	exit;
	
}else{
	//failed 
echo json_encode($l);
exit;
}


}


function postApi($url,$jsond)  {

	$ch = curl_init( $url );
# Setup request to send json via POST.
$payload = $jsond;
curl_setopt($ch, CURLINFO_HEADER_OUT, true);

// Use POST request
curl_setopt($ch, CURLOPT_POST, true);

curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );

// Set HTTP Header for POST request 
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($payload))
);

# Return response instead of printing.
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
# Send request.
$result = curl_exec($ch);
curl_close($ch);
# Print response.
$res = json_decode($result,true);
if(curl_error($ch)){

	echo json_encode(["message" => curl_error($ch), "success" => false]);
	exit;
}
return $result;
// if(isset($res['success']) && $res['success'] == 'true'){
// 	return true;
// } else{
// 	return false;
// }

}





?>
