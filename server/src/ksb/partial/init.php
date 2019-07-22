<?php

use Bootstrap\Helper\SessionManager;
use Dotenv\Dotenv;

// Default timezone
date_default_timezone_set("Asia/Ho_Chi_Minh");

// Start session
SessionManager::start();

// Eniroment Variables
$dotenv = Dotenv::create(__DIR__ . "/../");
$dotenv->load(true);
