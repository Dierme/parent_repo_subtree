<?php
require_once 'vendor/autoload.php';

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

# Getting config
$config = require('config.php');
$log_conf = $config['log'];

# Check if log file exists. If not - create one
$full_file_name = $log_conf['path'] . '/' . 'week-' . date('W', time()) . '.log';
if (!file_exists($full_file_name)) {
	fopen($full_file_name, 'w');
}

# Initializing the logger
$Logger = new Logger('db-dumper');
$Logger->pushHandler(new StreamHandler($full_file_name, Logger::INFO));

# Dumping the DB
$Logger->info('Begin dump');