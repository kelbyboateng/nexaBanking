<?php

session_start();//Start new or resume existing session
 //session_regenerate_id();//regenerate new session id and delete the old one THIS IS TO  PREVENT SESSION HIJACK
require 'vendor/autoload.php';
use App\Controllers\Utility;
use App\Controllers\Session;
use App\Controllers\User;

$ut = new Utility;

$session = new Session;

//authenticate the logged in user
$user  = new User;
if (!$user_id = $user->authenticate()){
	$ut->redirectTo('login.php');
}

//get all the user's login details
$auth_user =  $user->detailsById($user_id);

//get the user's current atm card details
$atmCard = $user->getAtmCard($user_id);



?>




<?php require '_templates/backend/header.php'; ?>

 <span id="atm" class="link-activate"></span>

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
				echo "<h2> You do not have an ATM Card Yet! </h2>
				<form action='atm-request.php' method='POST'>
			<button type='submit' class='btn btn-outlined btn-primary'> Request New ATM Card</button>".
			 $ut->csrf_token_tag() ."
			 </form>

				";


			}

			else if($atmCard[0]->status == 'pending'){
					echo "

				<h3> <i class='icon icon-wallet'> </i> ATM CARD Summary </h3>
				

				  <div class='row'>
  	
  	  <div class='col-md-6'></div>
  	    <div class='col-md-6'>
			<img src='cdn/img/cc.png' width='300'/>
			<p> Card Number: ".'<strong> XXXX-XXXX-XXXX-'.substr( $atmCard[0]->card_number,-4)
 . "</strong> </p>	
		
			<p> Status: <span class='label label-danger'> Pending Approval </span></p>
			
			
			
		
  	    </div>
  	    
  </div>

	
 	
   
    	</div>
			</div>";
			}

			else{
				echo "

				<h3> <i class='icon icon-wallet'> </i> ATM CARD Summary </h3>
				

				  <div class='row'>
  	
  	  <div class='col-md-6'></div>
  	    <div class='col-md-6'>
			<img src='cdn/img/cc.png' width='300'/>
			<p> Card Number: ".'<strong> XXXX-XXXX-XXXX-'.substr( $atmCard[0]->card_number,-4)
 . "</strong> </p>	
			<p> Issued at: <strong>". $atmCard[0]->issued_at ." </strong> </p>
			<p> Status: <span class='badge '>". $atmCard[0]->status." </span></p>
			<p> Valid From: <strong>". date('M, Y', strtotime($atmCard[0]->issued_at))."</strong> </p>
			<p> Expires On: <strong>". date('M, Y', strtotime($atmCard[0]->expires_at))." </strong> </p>
				<form action='atm-request.php' method='POST'>
			<button type='submit' class='btn btn-outlined btn-primary'> Request New ATM Card</button>".
			 $ut->csrf_token_tag() ."
			 </form>
		
		
  	    </div>
  	    
  </div>

	
 	
   
    	</div>
			</div>";

			}
			?>




			</div>
		
  </div>






<?php require '_templates/backend/footer.php'; ?>




