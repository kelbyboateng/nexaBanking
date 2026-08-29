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


$page_title = '';

?>


<?php require '_templates/backend/header.php'; ?>

 <span id="utility" class="link-activate"></span>

     <div class="col-md-9">
			
			<div class="row content-wrapper">

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

			if($auth_user[0]->balance < 1){
				echo "<h2> You don't have enough Funds to make any Payment! </h2>";
			}
			else{
				echo "";
			}
			?>


			<div class="col-lg-6 transfer-form">
       <div class="col-lg-4">     <img src="cdn/img/dstv.png" width="100">  </div>
      <div class="col-lg-4">   <img src="cdn/img/ecg.gif" width="100" style="">  </div>
       <div class="col-lg-4">       <img src="cdn/img/gwc.png" width="100">  </div>

   
 
    
  <div class="col-lg-12">
  <form action="utility-confirm.php" method="POST">

    <div class="input-group"  style="margin-top: 20px;">
    <select name="recepient_account_number">
      <option value="22">DSTV</option>
       <option value="23">ELECTRICITY COMPANY OF GHANA</option>
        <option value="24">GHANA WATER COMAPNY</option>
    </select>

     
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
  <div class="col-lg-12">
    <div class="input-group" style="margin-top: 20px;">
      <span class="input-group-addon">
       <i class="icon icon-diamond"></i>
      </span>
      <input type="number" class="form-control" aria-label="..." placeholder="Amount" name="transfer_amount" min="0" step="0.01" required="">
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->

  <div class="col-lg-12"  style="margin-top: 20px;">
  	<button class="btn btn-outlined btn-success btn-block"> <i class="icon-login"></i>  Pay Bill </button> 


  	     <?php echo $ut->csrf_token_tag();?>
  </form>
  </div>
</div><!-- /.row -->

		  </div>
		  </div>




<?php require '_templates/backend/footer.php'; ?>




