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

//logout the user and clear all the sessions related to the user

$user->logout();

//after logging out, we will redirect to the login page
$ut->redirectTo('login.php');



 ?>