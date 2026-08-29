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


$auth_user =  $user->detailsById($user_id);


//lets be sure the form is sent as a post request to get rid of spoofed forms

if (!$ut->request_is_post()){

	die('Access To this page is Forbidden!');
}


if (!$ut->request_is_same_domain()){
	//the page request is post so lets continue to process the form
	// but lets check if the form originates from our 
	die("Sorry we didn't understand your request!");

}

//now let's check for cross site request forgery csrf

if (!$ut->valid_csrf()){
	//the page request is post so lets continue to process the form
	// but lets check if the form originates from our 

	$error = ['Your Request has Timed Out! Refresh!'];

	$ut->redirect_with_errors('atm-cards.php', $error);
	exit();
}


//now lets process the page params

	$errors = [];

	$atmCard = $user->getAtmCard($user_id);

	if(!$atmCard){
		//no atm card record means the user is requesting for the first time
		$add_request = $user->new_atm_card_request($user_id);
		$msg = "ATM Card Requested Successfully!";
  		$ut->redirect_with_success('atm-cards.php', $msg);
		exit();
	}



	if($atmCard[0]->status == "pending"){
	//no atm card record means the user is requesting for the first time
	$error = ['You have a Pending ATM Card Request!'];
    $ut->redirect_with_errors('atm-cards.php', $error);
   exit();
	}
	else{
		$add_request = $user->atm_card_renewal($user_id);
		$msg = "New ATM Card Requested Successfully!";
  		$ut->redirect_with_success('atm-cards.php', $msg);
		exit();
	}



	


	// var_dump($errors);
	//lets check if there are no errors this far

	// if(count($errors) > 0){
	// 		$ut->redirect_with_errors('atm-cards.php.php', $errors);
	// }
	// else{

	// 	$payload = [
	// 		'email' =>$db->mysql_prep($_POST['email']),
	// 		'password' =>$db->mysql_prep($hash->encrypt($_POST['password']))
	// 	];

	// 	//

	// 	if($user->attempt_login($payload)){
	// 			//user has been logged in so let's redirect to the dashboard
	// 		$ut->redirectTo('atm-cards.php.php');

	// 	}
	// 	else{
	// 		$error = ['Invalid Email or Password!'];
	// 		$ut->redirect_with_errors('login.php', $error);
	// 	}

	// 	// if($created = $user->create_user($payload)){
	// 	// 	$msg = "Account Created. Login Now!";

	// 	// 	// $user->send_verification_email($created);

		
	// 	// 	$ut->redirect_with_success('login.php', $msg);
	// 	// }
		 






 ?>