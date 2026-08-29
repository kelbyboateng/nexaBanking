<?php
session_start();//Start new or resume existing session
 //session_regenerate_id();//regenerate new session id and delete the old one THIS IS TO  PREVENT SESSION HIJACK
require 'vendor/autoload.php';
use App\Controllers\Utility;

$ut = new Utility;


 ?>

<?php require '_templates/frontend/header.php'; ?>

 <div class="container-fluid header">
    <div class="container">
      <div class="row">
        <div class="col-md-3">  <img src="cdn/img/ob_logo.png" class="logo"></div>
        <div class="col-md-3"></div>
          <div class="col-md-3"></div>
        <div class="col-md-3 account-buttons"><a href="login.php" class="btn btn-outlined btn-primary"><i class="icon-lock"></i> Login</a> </div>

      </div>
    </div>
  </div>



<!-- <div class="container">
  <div class="row">
        <div class="col-lg-3">
            <p><a href="#" class="btn btn-outlined btn-primary">Demo Primary Button</a></p>
            <p><a href="#" class="btn btn-outlined btn-success">Demo Success Button</a></p>
            <p><a href="#" class="btn btn-outlined btn-info">Demo Info Button</a></p>
            <p><a href="#" class="btn btn-outlined btn-warning">Demo Warning Button</a></p>
            <p><a href="#" class="btn btn-outlined btn-danger">Demo Danger Button</a></p>
        </div>
        <div class="col-lg-4">
            <p><a href="#" class="btn btn-outlined btn-block btn-primary">Demo Block Primary Button</a></p>
            <p><a href="#" class="btn btn-outlined btn-block btn-success">Demo Block Success Button</a></p>
            <p><a href="#" class="btn btn-outlined btn-block btn-info">Demo Block Info Button</a></p>
            <p><a href="#" class="btn btn-outlined btn-block btn-warning">Demo Block Warning Button</a></p>
            <p><a href="#" class="btn btn-outlined btn-block btn-danger">Demo Block Danger Button</a></p>
        </div>
  </div>
</div> -->



        <div class="loginmodal-container">

   <?php

if(isset($_SESSION['page_errors'])){
   
    if(count($_SESSION['page_errors']) > 0 ){
       echo "   <div class='alertbox alert-danger'> <ul> ";
   foreach ($_SESSION['page_errors'] as $error) {
         echo "<li> <i class='icon-close'> </i>$error</li>";
   }
    echo "</ul> </div>";
   session_destroy();
 }
 }


 if(isset($_SESSION['success'])){
  echo " <div class='alertbox alert-success'> <ul> <li> <i class='icon-close'> </i> ". $_SESSION['success'] . "</li> </ul> </div>";
   session_destroy();
 }

 


   ?>

          <h1>Create Your Account</h1><br>
          <form action="register-process.php" method="POST">
          <input type="text" name="first_name" placeholder="First Name" required pattern="[a-zA-Z]{1,}"  oninvalid="this.setCustomValidity('Enter First Name Here')"
    oninput="setCustomValidity('')"  autocomplete="off">
           <input type="text" name="last_name" placeholder="Last Name" required pattern="[a-zA-Z]{1,}"  oninvalid="this.setCustomValidity('Enter Last Name Here')"
    oninput="setCustomValidity('')"  autocomplete="off">
            <input type="email" name="email" placeholder="Email" required autocomplete="off">
             <input type="password" name="password" placeholder="Password" required minlength="8" autocomplete="off">

      
        <button class="btn btn-outlined btn-block btn-success" type="submit"><i class="icon-user-follow"></i> Register</button>
       <!--    <input type="submit" name="login" class="login loginmodal-submit" value="Login"> -->
       <?php echo $ut->csrf_token_tag();?>
          </form>
          
          <div class="login-help">
         <!--  <a href="#">Register</a> - <a href="#">Forgot Password</a> -->
          </div>
        </div>


<?php require '_templates/frontend/footer.php'; ?>




