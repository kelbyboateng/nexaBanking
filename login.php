<?php
session_start();//Start new or resume existing session
 //session_regenerate_id();//regenerate new session id and delete the old one THIS IS TO  PREVENT SESSION HIJACK
require 'vendor/autoload.php';
use App\Controllers\Utility;
use App\Controllers\Session;

$ut = new Utility;

$session = new session;



// var_dump($session->has('user'));
 ?>


<?php require '_templates/frontend/header.php'; ?>

 <div class="container-fluid header">
    <div class="container">
      <div class="row">
        <div class="col-md-3">  <img src="cdn/img/ob_logo.png" class="logo"></div>
        <div class="col-md-3"></div>
          <div class="col-md-3"></div>
        <div class="col-md-3 account-buttons"><a href="register.php" class="btn btn-outlined btn-success"> <i class="icon-user-follow"></i>  Register</a> </div>

      </div>
    </div>
  </div>




<!-- <a href="#" data-toggle="modal" data-target="#login-modal">Login</a>

<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
        <div class="loginmodal-container">
          <h1>Login to Your Account</h1><br>
          <form>
          <input type="text" name="user" placeholder="Username">
          <input type="password" name="pass" placeholder="Password">
          <input type="submit" name="login" class="login loginmodal-submit" value="Login">
          </form>
          
          <div class="login-help">
          <a href="#">Register</a> - <a href="#">Forgot Password</a>
          </div>
        </div>
      </div>
      </div> -->


<!--       <a href="#" data-toggle="modal" data-target="#login-modal">Login</a> -->


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


          <h1>Login to Your Account</h1><br>
          <form action="login-process.php" method="POST">
          <input type="email" name="email" placeholder="Email" autocomplete="off">
          <input type="password" name="password" placeholder="Password" autocomplete="off">
               <button class="btn btn-outlined btn-block btn-primary" type="submit"><i class="icon-lock"></i> Login</button>
           <?php echo $ut->csrf_token_tag();?>
          </form>
          
          <div class="login-help">
         <!--  <a href="#">Register</a> - <a href="#">Forgot Password</a> -->
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

<?php require '_templates/frontend/footer.php'; ?>




