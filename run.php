<?php
require_once 'bootstrap.php';

use Spatie\DbDumper\Databases\PostgreSql;


# Getting config
$database_conf = $config['database'];
$log_conf = $config['log'];

# Dumping the DB
$Logger->info('Begin dump');
try {
	$Dumper = PostgreSql::create();
	$dump_name = $database_conf['db_name'] . '-' . strval(time()) . '.sql';
	
	$Dumper->setDbName($database_conf['db_name'])
		->setUserName($database_conf['username'])
		->setPassword($database_conf['password'])
		->dumpToFile($database_conf['dump_folder'] . '/' . $dump_name);
	
	$Logger->info('Dump finished successfully!');
} catch (\Exception $e) {
	$Logger->error('Exception', array('exception' => $e));
	throw $e;
}