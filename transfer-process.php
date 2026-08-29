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


//this authenticates the user to be sure he's logged in before we continue any further transactions
$user  = new User;
if (!$user_id = $user->authenticate()){
  $ut->redirectTo('login.php');
}


$auth_user =  $user->detailsById($user_id);
$recepient =  $user->detailsById($_POST['recepient_id']);



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

  $ut->redirect_with_errors('login.php', $error);
  exit();
}


  //lets see if the user has enough balance to make the transfer 
  //if not we will redirect him back to the transfer page with the error
if($auth_user[0]->balance < $_POST['amount']){
    $error = ['Not Enough Funds for this Transfer!'];
    $ut->redirect_with_errors('transfer.php', $error);
   exit();
}
else{
    //there's enough funds in the user's account so let's initiate the transfer

    $recepient_id = $_POST['recepient_id'];
    $amount = $_POST['amount'];
    $sender_id = $_POST['sender_id'];
    $sender_name = $auth_user[0]->first_name . " " . $auth_user[0]->last_name;
     $recepient_name = $recepient[0]->first_name . " " . $recepient[0]->last_name;
     $details = "Money Transfer";

    //there are 3 database queries that are run to complete the transfer
     // 1. The sender's account balance is debitted
     // 2. The recepient account balance is credited
     // 3. A record of the transaction is inserted into the record table


     ///these are the queries that are run for each step

 // 1. The sender's account balance is debitted
  $debit_sql = "UPDATE users SET balance = balance - $amount WHERE id=$sender_id LIMIT 1";

    // 2. The recepient account balance is credited
  $credit_sql = "UPDATE users SET balance = balance + $amount WHERE id=$recepient_id LIMIT 1";

   // 3. A record of the transaction is inserted into the record table
  $transaction_sql = "INSERT INTO transactions (type,sender_id,sender_name,recepient_name,recepient_id,amount,details,created_at)
                 VALUES ('transfer','$sender_id','$sender_name', '$recepient_name','$recepient_id','$amount','$details',now())";

//lets make a database connection to run the above queries
  $db = new Database;

 $db->query($debit_sql); //runs the query for the debit
 $db->query($credit_sql); //runs the query for the credit
  // 

 //runs the query for the transactional record
  if($db->query($transaction_sql)){
    
    //if all the queries are run successfully we will redirect the user to the transfer page with 
    // the suceess message

    $msg = "Success Transfering Money!";
  $ut->redirect_with_success('transfer.php', $msg);
exit();
   
}

}

//now lets process the page params

  // $errors = [];

  // if(  !isset($_POST['email'])  || empty(trim($_POST['email'])) ){
    
  //   $errors[] = "Provide a valid Email";
  // }

  // if(  !isset($_POST['password'])  || empty(trim($_POST['password'])) ){
    
  //   $errors[] = "Provide a Password";
  // }

  


  // var_dump($errors);
  //lets check if there are no errors this far

  // if(count($errors) > 0){
  //     $ut->redirect_with_errors('login.php', $errors);
  // }
  // else{

  //   $payload = [
  //     'email' =>$db->mysql_prep($_POST['email']),
  //     'password' =>$db->mysql_prep($hash->encrypt($_POST['password']))
  //   ];

  //   //

  //   if($user->attempt_login($payload)){
  //       //user has been logged in so let's redirect to the dashboard
  //     $ut->redirectTo('dashboard.php');

  //   }
  //   else{
  //     $error = ['Invalid Email or Password!'];
  //     $ut->redirect_with_errors('login.php', $error);
  //   }


  // }



 ?>