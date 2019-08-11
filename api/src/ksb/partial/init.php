<?php

use Dotenv\Dotenv;

// --Init settings-- //

// Default timezone
date_default_timezone_set("Asia/Ho_Chi_Minh");

// Eniroment Variables
$dotenv = Dotenv::create(__DIR__ . "/../");
$dotenv->load(true);
