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

?>


<?php require '_templates/backend/header.php'; ?>

 
<span id="account" class="link-activate"></span>

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






			<div class="col-lg-6 transfer-form">

  <div class="col-lg-12">
  <form action="account-update.php" method="POST">

    <div class="input-group" style="margin-top: 20px;">
      <span class="input-group-addon">
       <i class="icon icon-user-follow"></i>
      </span>
      <input type="email" class="form-control" placeholder="Recepient Account Number"  required="" disabled value="<?php echo $auth_user[0]->email; ?>">
    </div><!-- /input-group -->


        <div class="input-group" style="margin-top: 20px;">
      <span class="input-group-addon">
       <i class="icon icon-user-follow"></i>
      </span>
      <input type="text" class="form-control" placeholder="First Name"  required=""  value="<?php echo $auth_user[0]->first_name; ?>" pattern="[a-zA-Z]{1,}"  oninvalid="this.setCustomValidity('Enter Valid First Name Here')" name='first_name'>
    </div><!-- /input-group -->

        <div class="input-group" style="margin-top: 20px;">
      <span class="input-group-addon">
       <i class="icon icon-user-follow"></i>
      </span>
      <input type="text" class="form-control" placeholder="Last Name"  required=""  value="<?php echo $auth_user[0]->last_name; ?>" pattern="[a-zA-Z]{1,}"  oninvalid="this.setCustomValidity('Enter Valid Last Name Here')" name='last_name'>
    </div><!-- /input-group -->
     

  

  </div><!-- /.col-lg-6 -->
  <div class="col-lg-12">
    <div class="input-group" style="margin-top: 20px;">
      <span class="input-group-addon">
       <i class="icon icon-lock"></i>
      </span>
      <input type="password" class="form-control"  name="password" required=""  placeholder="Password" minlength="8" autocomplete="off">
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->

  <div class="col-lg-12">

<button class="btn btn-outlined btn-success btn-block"  style="margin-top: 20px;"> <i class="icon-login"></i>  Update </button> 


  	     <?php echo $ut->csrf_token_tag();?>
  </form>
  </div>
</div><!-- /.row -->

		  </div>
		  </div>




<?php require '_templates/backend/footer.php'; ?>




