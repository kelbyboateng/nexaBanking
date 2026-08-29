<?php

require 'vendor/autoload.php';
use App\Controllers\Utility;

$ut = new Utility;

echo $ut->validate_url("google.com");





