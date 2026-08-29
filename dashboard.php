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

if($auth_user[0]->role !== 'user'){
	$ut->redirectTo('admin-dashboard.php');
	exit();
}



$transactions = $user->userTransactions($user_id);

// var_dump($transactions);

?>




<?php require '_templates/backend/header.php'; ?>

 <span id="dashboard" class="link-activate"></span>

     <div class="col-md-9">
			
		
			<div class="transactions-table">

				<?php

			if(!$transactions){
				echo '<h2> No Transaction Records Yet! </h2>';
			}

			else{
				echo "
				<h3> <i class='icon icon-chart'> </i> Transactions Summary </h3>

			<div class=''>
    <div class=' col-md-12 custyle'>
    <table class='table table-striped custab' >
    <thead>
<!--     <a href='#' class='btn btn-primary btn-xs pull-right'><b>+</b> Add new categories</a> -->
        <tr>
         <th></th>
            <th>ID</th>
            <th>Date</th>
            <th>Type</th>
           	 <th>Sender </th>
              <th>Recepient </th>
             
                <th>Amount Gh&cent;</th>
                
                 <th>Details</th>
      
        </tr>
    </thead>";
 	
    foreach ($transactions as $transaction) {
    	//var_dump($transaction);
    	if($transaction->recepient_id == $auth_user[0]->id){
			
			 echo " <tr>
			   <td> <div class='indicator indicator-green'> <i class='icon icon-logout'> <i> </div></td>
           <td>$transaction->id</td>
			<td>" . date('M j, Y', strtotime($transaction->created_at)) ."</td>
			<td>Cash In</td>
			<td>$transaction->sender_name</td>
			<td><span class='success-strong-text'> $transaction->recepient_name </span></td>
			<td><span class='success-strong-text'>  $transaction->amount </span></td>

			<td> $transaction->details </td>
			
    </tr>";
    	}
    	else{
    		 echo " <tr>
    		  <td> <div class='indicator indicator-red'> <i class='icon icon-paper-plane'> <i> </div></td>
           <td>$transaction->id</td>
			<td>" . date('M j, Y', strtotime($transaction->created_at)) ."</td>
			<td>$transaction->type</td>
			<td>$transaction->sender_name</td>
			<td><span class='success-strong-text'>  $transaction->recepient_name </span></td>
			<td><span class='danger-strong-text'>  $transaction->amount </span></td>

			<td> $transaction->details </td>
			
    </tr>";
    }
  
    }
          echo " </table>
    	</div>
			</div>";

			}
			?>




			</div>
		
  </div>




<?php require '_templates/backend/footer.php'; ?>




