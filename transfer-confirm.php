<?php

session_start();//Start new or resume existing session
 //session_regenerate_id();//regenerate new session id and delete the old one THIS IS TO  PREVENT SESSION HIJACK
require 'vendor/autoload.php';
use App\Controllers\Utility;
use App\Controllers\Session;
use App\Controllers\User;

$ut = new Utility;

$session = new Session;
// $session->clear('user');
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

	$ut->redirect_with_errors('login.php', $error);
	exit();
}



$recepient = $user->confirm_recepient_exists($_POST['recepient_account_number']);

// var_dump($recepient);


?>


<?php require '_templates/backend/header.php'; ?>

 

     <div class="col-md-9">
			
			<div class="row content-wrapper">



			<?php

				if(!$recepient){
				echo "<h2 style='color:red;'> The Recepient (#" . $_POST['recepient_account_number'] .") doesn't exist! </h2>";
			}
			
			

			else if( ($auth_user[0]->balance < 1) || ($auth_user[0]->balance < $_POST['transfer_amount']) ){
				echo "<h2 style='color:red;'> You don't have enough Funds to make this Transfer! </h2>";
			}
			else if($auth_user[0]->id == $recepient[0]->id){
				echo "<h2 style='color:red;'> You can't transfer money to Yourself! </h2>";
			}
		
			else{

				$remaining =  $auth_user[0]->balance - $_POST['transfer_amount'];
			
				echo "
					
      <div class='col-lg-6 transfer-form'>
  <div class='col-lg-12'>
    
      <table class='table table-striped custab' >
        <thead>
          <tr>
            <th>Session</th>
            <th>Details</th>
          </tr>
        </thead>
        <tbody>
          <tr>
			
            <td>Recepient Account Number </td>
            <td> " .$recepient[0]->id . "</td>
          </tr>

          <tr>
            <td>Recepient Name </td>
            <td> ".$recepient[0]->first_name. ' ' . $recepient[0]->last_name ." </td>
          </tr>


          <tr>
            <td>Transfer Amount </td>
            <td> ".$_POST['transfer_amount']." </td>
          </tr>

          <tr>
            <td>Available Balance </td>
            <td>  " .$auth_user[0]->balance." </td>
          </tr>

          <tr>
            <td>Remaining Balance </td>
            <td> " .$remaining." </td>
          </tr>
        </tbody>
      </table>

      

            <form action='transfer-process.php' method='POST'>
        <input type='hidden' name='recepient_id' value='".$recepient[0]->id ."'>
        <input type='hidden' name='sender_id' value='".$auth_user[0]->id ."'>
        <input type='hidden' name='amount' value='". $_POST['transfer_amount'] ."'>
        <button class='btn btn-outlined btn-block btn-primary' type='submit'><i class='icon-login'></i> Transfer</button>";
 echo $ut->csrf_token_tag();
    echo "</form>

  </div>
</div>

				";
			}

			?>


		  </div>
		  </div>




<?php require '_templates/backend/footer.php'; ?>




