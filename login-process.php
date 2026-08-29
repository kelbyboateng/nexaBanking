<?php
session_start();//Start new or resume existing session

//this line autoloads all the Controller Classes needed to process the forms
require 'vendor/autoload.php';
use App\Controllers\Utility;
use App\Controllers\User;
use App\Controllers\Database;
use App\Controllers\Hash;
$ut = new Utility;
$user = new User;
$db = new Database;
$hash = new Hash;


//this checks to be sure the form is sent as a post request to get rid of spoofed forms


if (!$ut->request_is_post()){

	die('Access To this page is Forbidden!');
}


if (!$ut->request_is_same_domain()){
	//the page request is post so lets continue to process the form
	// but lets check if the form originates from our website and not a spoofed form
	die("Sorry we didn't understand your request!");

}

//now let's check for cross site request forgery csrf

if (!$ut->valid_csrf()){

	//if the form doesn't have a unique identifier token then we kill the page
	$error = ['Your Request has Timed Out! Refresh!'];

	$ut->redirect_with_errors('login.php', $error);
	exit();
}

//when all the above steps are passed then we can continue to process the login request
//now lets process the page params

	$errors = [];

	//check if a valid email was submitted with the form
	if(  !isset($_POST['email'])  || empty(trim($_POST['email'])) ){
		
		$errors[] = "Provide a valid Email";
	}

	//check if a valid password was submitted with the form

	if(  !isset($_POST['password'])  || empty(trim($_POST['password'])) ){
		
		$errors[] = "Provide a Password";
	}

	


	//lets check if there are no errors this far
	//if there are any errors, we'll redirect back to the homepage and display the errors

	if(count($errors) > 0){
			$ut->redirect_with_errors('login.php', $errors);
	}
	else{
		//there are no errors so let's attempt a login
		$payload = [
			'email' =>$db->mysql_prep($_POST['email']),
			'password' =>$db->mysql_prep($hash->encrypt($_POST['password']))
		];

		//attempt a login with the user given credentials

		if($user->attempt_login($payload)){
				//user has been logged in so let's redirect to the dashboard
			$ut->redirectTo('dashboard.php');

		}
		else{
			//invalid login credentials so lets redirect back to the login page and display this errors
			$error = ['Invalid Email or Password!'];
			$ut->redirect_with_errors('login.php', $error);
		}

		 


	}



 ?>