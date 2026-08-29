<?php
session_start();//Start new or resume existing session
// session_regenerate_id();//regenerate new session id and delete the old one THIS IS TO  PREVENT SESSION HIJACK
require 'vendor/autoload.php';
use App\Controllers\Utility;
use App\Controllers\User;
use App\Controllers\Database;
use App\Controllers\Hash;
$ut = new Utility;
$user = new User;
$db = new Database;


$user  = new User;
if (!$user_id = $user->authenticate()){
  $ut->redirectTo('login.php');
}


//this page activates the atm card requests;

//now lets process the page params

	$errors = [];


	//throws an error if there is no action parameter added to the requests parameters
	//eg if the request was fake or a hack attempt
	if(  !isset($_GET['a'])  || empty(trim($_GET['a'])) ){
		
		$errors[] = "Sorry An Error Occured While Processing Your Request! action";
	}


	//throw an error if no atm card id is passed

	if(  !isset($_GET['id'])  || empty(trim($_GET['id'])) ){
		
		$errors[] = "Sorry An Error Occured While Processing Your Request! id";
	}



	//lets check if there are no errors this far

	if(count($errors) > 0){
			$ut->redirect_with_errors('atm-card-requests.php', $errors);
	}
	else{

		
		//there are no errors with the requests this far so we can continue processing the form

	//first let's check if the atm card provided does exist evwen before we do anything next
	$atmCard_exists = $user->getThisAtmCard($_GET['id']);

	if(!$atmCard_exists){
		//no atm card record means the request  is fake so lets throw an error and redirect back to atm card requeests page
		$errors[] = "Sorry An Error Occured While Processing Your Request! no card";
		$ut->redirect_with_errors('atm-card-requests.php', $errors);
		exit();
	}
	else{
		//if there are no errors till now
		// then we can go ahead to activate the atm card
		//and redirect the user with a success message
		$activate = $user->activateAtmCard($_GET['id']);
		if($activate){
			$msg = "ATM Card Activated Successfully!";
  		$ut->redirect_with_success('atm-card-requests.php', $msg);
		exit();
		}
		

		


	}
}


	



 ?>