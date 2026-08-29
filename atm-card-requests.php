<?php

session_start();//Start new or resume existing session
 //session_regenerate_id();//regenerate new session id and delete the old one THIS IS TO  PREVENT SESSION HIJACK
require 'vendor/autoload.php';
use App\Controllers\Utility;
use App\Controllers\Session;
use App\Controllers\User;

$ut = new Utility;

$session = new Session;

//authenticate the current user
$user  = new User;
if (!$user_id = $user->authenticate()){
	$ut->redirectTo('login.php');
}


//get the authenticated user's details
$auth_user =  $user->detailsById($user_id);

//redirect the user if he's not an admin
//this prevent the regular users from seeing this page
if($auth_user[0]->role !== 'admin'){
  $ut->redirectTo('dashboard.php');
  exit();
}



//get all the atm cards
$atmCard = $user->getAllAtmCards();

// var_dump($transactions);

?>




<?php require '_templates/backend/header.php'; ?>

 <span id="atm-requests" class="link-activate"></span>

     <div class="col-md-9">
			
		
			<div class="transactions-table">


        <?php

if(isset($_SESSION['page_errors'])){
   
    if(count($_SESSION['page_errors']) > 0 ){
       echo "   <div class='alertbox alert-danger'> <ul> ";
   foreach ($_SESSION['page_errors'] as $error) {
         echo "<li> <i class='icon-close'> </i>$error</li>";
   }
    echo "</ul> </div>";
   $session->clear('page_errors');
 }
 }


 if(isset($_SESSION['success'])){
  echo " <div class='alertbox alert-success'> <ul> <li> <i class='icon-close'> </i> ". $_SESSION['success'] . "</li> </ul> </div>";
   $session->clear('success');
 }

 


   ?>


				<?php

			if(!$atmCard){
				echo "<h2> No  ATM Card  Requests Yet! </h2>";


			}

			else{
				echo "
				<h3> <i class='icon icon-wallet'> </i> ATM Card Requests Summary </h3>
	<div class=''>
    <div class='col-md-12 custyle'>
    <table class='table table-striped custab' >
    <thead> <tr>
            <th>USER</th>
            <th>CARD NUMBER</th>
            <th>REQUESTED ON</th>
           	 <th>STATUS </th>
              <th>ISSUED </th>
             
                <th>EXPIRES</th>
                 <th>ACTION</th>
                
   
      
        </tr>
    </thead>";
 	
    foreach ($atmCard as $atmCard) {

      $card_number = substr($atmCard->card_number, 0, 4) .'-'.
                  substr($atmCard->card_number, 4, 4) .'-'.
                  substr($atmCard->card_number, 8, 4) .'-'.
                    substr($atmCard->card_number, 12, 4);

                 // 1406 1009 0509 3255


    	if($atmCard->status == 'pending'){
    		$action =  "<a href='atm-action.php?a=activate&id=".$atmCard->id."' class='label label-success'> Activate </a>";
    		$issued = "Not Yet";
    		$expires = "Not Yet";
    		$status =  "<a href='atm-action.php?' class='label label-default'> Pending </a>";
    	

    	}
    	elseif ($atmCard->status == 'active'){
    		$action =  "<span  class='label label-danger'> Is Active </span>";
    			$issued =date('M, Y', strtotime($atmCard->issued_at));
    		$expires = date('M, Y', strtotime($atmCard->expires_at));
    		$status =  "<span class='label label-primary'> Active </span>";
    		
    	}

   echo " <tr>
    <td> ". $atmCard->first_name. " " . $atmCard->last_name ." </td>
			   <td> ".$card_number ." </td>
			   <td>" . date('M j, Y', strtotime($atmCard->created_at)) ."</td>
			    <td> ".  $status ." </td>
			     <td> ".   $issued ." </td>

			      <td> ". $expires  ." </td>

			      	      <td> ".  $action." </td>
			      
          
			
			</tr>";
} echo "
         </table>
    	</div>
			</div>";

			}
		
			?>




			</div>
		
  </div>




<?php require '_templates/backend/footer.php'; ?>




