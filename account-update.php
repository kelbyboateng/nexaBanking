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
$hash = new Hash;

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

	$ut->redirect_with_errors('account.php', $error);
	exit();
}


//now lets process the page params and update our account details


	$errors = [];
if(  !isset($_POST['first_name'])  || empty(trim($_POST['first_name'])) ){
		
		$errors[] = "Provide a valid First Name";
	}

	if(  !isset($_POST['last_name'])  || empty(trim($_POST['last_name'])) ){
		
		$errors[] = "Provide a valid Last Name";
	}


	if(  !isset($_POST['password'])  || empty(trim($_POST['password'])) ){
		
		$errors[] = "Provide a valid Password";
	}
	

	// var_dump($errors);
	//lets check if there are no errors this far

	if(count($errors) > 0){
			$ut->redirect_with_errors('account.php', $errors);
	}
	else{

		$payload = [
			'user_id' => $user_id,
			'first_name' =>$db->mysql_prep($_POST['first_name']),
			'last_name' =>$db->mysql_prep($_POST['last_name']),
			'password' =>$db->mysql_prep($hash->encrypt($_POST['password']))
		];

		//if all details are provided in the right format we can now update the account details

	
		if($updated = $user->update_user($payload)){
			//once the account details is changed we have to log the user out
			$msg = "Account Details Changed. Login Now!";
			
			$ut->redirect_with_success('login.php', $msg);
			exit();

		}
		 


	}



	




 ?>