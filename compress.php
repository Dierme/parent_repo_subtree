<?php
require_once 'bootstrap.php';

use DbDumper\Zip\DefaultZipper;

$conf_zip = $config['archive'];
$db_config = $config['database'];
# Compress DB dumps
$Logger->info('Begin compressing dumps');
try {
	
	$full_zip_name = $conf_zip['folder'] . '/' . 'dumps-week-' . date('W', time()) . '.zip';
	
	# initializing default zipper
	$zip = new DefaultZipper($full_zip_name);
	
	# looking for dumps in the folder
	$found_files = $zip->addGlob($db_config['dump_folder'] . '/' . $db_config['db_name'] . '-*.sql');
	$Logger->info("numfiles: " . $zip->numFiles);
	$Logger->info("status:" . $zip->status);
	
	# zipping and deleting files if zip was successful
	if ($zip->zip()) {
		foreach ($found_files as $file) {
			if (!unlink($file)) {
				$Logger->warning(sprintf('Could not delete a file %s', $file));
			}
		}
	}
	
} catch (\Exception $e) {
	$Logger->error('Exception', array('exception' => $e));
	throw $e;
}