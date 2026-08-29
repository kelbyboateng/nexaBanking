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
	// but lets check if the form originates from our website

	$error = ['Your Request has Timed Out! Refresh!'];

	$ut->redirect_with_errors('register.php', $error);
	exit();
}


//now lets process the page params by checking if all the required parameters were all provided or throw errors

	$errors = [];
	if(  !isset($_POST['first_name'])  || empty(trim($_POST['first_name'])) ){
		
		$errors[] = "Provide a valid First Name";
	}

	if(  !isset($_POST['last_name'])  || empty(trim($_POST['last_name'])) ){
		
		$errors[] = "Provide a valid Last Name";
	}

	if(  !isset($_POST['email'])  || empty(trim($_POST['email'])) ){
		
		$errors[] = "Provide a valid Email";
	}


	if(  !isset($_POST['password'])  || empty(trim($_POST['password'])) ){
		
		$errors[] = "Provide a valid Email";
	}


	//after checking the required form parameters we'll check if there are any errors this far
	//lets check if there are no errors this far

	if(count($errors) > 0){
		//if there are any errors we'll redirect to the register page
			$ut->redirect_with_errors('register.php', $errors);
	}
	else{

		//at this point there are no errors with the registration request so we can start the registration process

		$payload = [
			'first_name' =>$db->mysql_prep($_POST['first_name']),
			'last_name' =>$db->mysql_prep($_POST['last_name']),
			'email' =>$db->mysql_prep($_POST['email']),
			'password' =>$db->mysql_prep($hash->encrypt($_POST['password']))
		];

		//before we crate a new user, we need to check if no user exists with the same email

		if($user->check_email_exists($payload['email'])){
			//throw an error if the email submitted already exists

			$errors[] = "Your Email " . $payload['email'] . " is already Taken";

			//redirect back to the registration page and display that error
			$ut->redirect_with_errors('register.php', $errors);
		}

		//now there are no errors this far so we can go ahead to create a new user account

		if($created = $user->create_user($payload)){
			//after creating the user account, we redirect the user to the register page with an account creation success message 
			//so they can go ahead to log in
			$msg = "Account Created. Login Now!";
		
			$ut->redirect_with_success('register.php', $msg);
		}
		 


	}


 ?>