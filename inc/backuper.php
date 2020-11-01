<?php

/**
 * This script is called by the SlithyWeb hosting provider to make a copy
 * of this WordPress site. This is a special script in the sense it is NOT
 * protected and the access is "public". The protection is ensured via a
 * randomly generated code that authorize the access. This is important to
 * test the security of the caller.
 *
 * Note the filtering on an IP address could be added but it is not very
 * conclusive because the original IP can be hidden by proxies or by some
 * security systems.
 *
 * The backup starts with the backup of the database then a backup of
 * all the files (which is better). There is no check in case a theme or
 * a plugin is updated during the backup! This could be added after.
 *
 * Note, the security is passed through the "Authentication" header to
 * give a more secure access. This has the advantage to store the user
 * in the logs but not the password.
 *
 */

$username = $_SERVER['PHP_AUTH_USER'];
$password = $_SERVER['PHP_AUTH_PW'];
if(!$username && $_POST['login']){
	$username = $_POST['login'];
	$password = $_POST['pwd'];
}
if (!$username || !$password) {
    header('WWW-Authenticate: Basic realm="Slithy Copy"');
    header('HTTP/1.0 401 Unauthorized');
    die("Any act of piracy will be reported.");
    exit;
} 

define('WP_USE_THEMES', false);
require(dirname(__FILE__).'/../../../../wp-load.php');
$user = wp_authenticate($username, $password);
if(is_wp_error($user) || !$user->has_cap('administrator')){
	// Hide the truth
    header('HTTP/1.0 500 Server error');
    die("Bad request.");
}

function root($v){
	return preg_replace(':^' . ABSPATH . ':', '/', $v);
}

function slithy_load($filename){
	if($filename == "wp-config-php"){
		header('HTTP/1.0 500 Server error');
                die("This file is kept secret.");
	}
	$file = ABSPATH . $filename;
	if (file_exists($file)) {
		header('Content-Type: application/octet-stream');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Content-Length: ' . filesize($file));
		readfile($file);
		exit;
	} else {
    		header('HTTP/1.0 404 Not found');
		die("Data " . $file . " not found.");
	}
}

function slithy_structure($tbl){
	global $wpdb;
	$rows = $wpdb->get_results("SHOW CREATE TABLE `$tbl`");
	foreach($rows as $row){
		echo ((array)$row)['Create Table'] . "\n";
	}

}

function slithy_select($tbl){
	global $wpdb;
	if(!$wpdb->check_connection(false)){
		header('HTTP/1.0 500 Server error');
		die("Can not connect to database.");
	}
	$query = "SELECT * FROM `${tbl}`";
	if (!empty( $wpdb->dbh )){
		if($wpdb->use_mysqli ) {
        	$results = mysqli_query( $wpdb->dbh, $query );
   		} else {
			$results = mysql_query( $query, $wpdb->dbh );
		}
	} else {
		header('HTTP/1.0 500 Server error');
		die("No database connection.");
	}
	header("Content-type: text/plain");
	foreach($results as $row){
		echo json_encode(array_values($row)) . "\n";
	}

}

function slithy_tables(){
	global $wpdb;
	$mytables = $wpdb->get_results("SHOW TABLES");
	foreach ($mytables as $mytable) {
		foreach ($mytable as $t) {       
			echo "$t\n";
		}
	}
}

function slithy_md5($dir){
	global $ROOT;
	$array = scandir($dir);
	foreach($array as $fic){
		if($fic !== '.' && $fic !== '..'){
			$fullpath = "$dir/$fic";
			if(!is_dir($fullpath)){
				echo md5_file($fullpath) . ' ' . root("$fullpath/") . "\n";
			}
		}
	}
}

function _add_dir($zip, $dir, $root, $recursive){
	$array = scandir($dir);
	foreach($array as $fic){
		if($fic !== '.' && $fic !== '..'){
			$fullpath = "$dir/$fic";
			if(!is_dir($fullpath)){
				$zip->addFile($fullpath, "$root$fic");
			} else if($recursive){
				_add_dir($zip, "$dir/$fic", "$root$fic/", true);
			}
		}
	}
}

function slithy_zipfile($dir, $recursive){
	global $ROOT;
	$zip = new ZipArchive();
	$tmpfname = tempnam(sys_get_temp_dir(), "exp") . ".zip";
	$ret = $zip->open($tmpfname, ZipArchive::OVERWRITE | ZipArchive::CREATE);
	if($ret === TRUE){
		_add_dir($zip, $dir, "", $recursive);
		$zip->close();
		readfile($tmpfname);
	}
	unlink($tmpfname);
}

function slithy_scan($dir){
	global $ROOT;
	$array = scandir($dir);
	foreach($array as $fic){
		if($fic !== '.' && $fic !== '..'){
			$fullpath = "$dir/$fic";
			if(is_dir($fullpath)){
				echo root("$fullpath/") . "\n";
				slithy_scan($fullpath);
			} else {
				echo root($fullpath) . "\n";
			}
		}
	}
}

function slithy_plugins(){
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	foreach(get_plugins() as $id => $plugin){
		echo $id . " " . $plugin['Version'] . "\n";
	}
}

/*
 * At this point, the user is identified and has
 * the administrator capabilities
 */
wp_ob_end_flush_all(); // To avoid a memory error for big files
$request = $_GET["req"];
if($request == 'dirs'){
	// List the directories
	slithy_scan(preg_replace(':/$:', '', ABSPATH));
} else if($request == 'file'){
	$filename = $_GET["file"];
	slithy_load($filename);
} else if($request == 'plugins'){
	slithy_plugins();
} else if($request == 'schema'){
	$table = $_GET["table"];
	slithy_structure($table);
} else if($request == 'md5'){
	$dir = $_GET["dir"];
	slithy_md5(ABSPATH . preg_replace(':^/:', '', $dir));
} else if($request == 'zip'){
	// Load the table list
	$dir = $_GET["dir"];
	$recursive = !!$_GET["recursive"];
	slithy_zipfile(ABSPATH . preg_replace(':^/:', '', $dir), $recursive);
} else if($request == 'data'){
	// Load the table list
	$table = $_GET["table"];
	slithy_select($table);
} else if($request == 'tables'){
	// Load the table list
	slithy_tables();
} else if($request == 'test'){
	echo "OK\n";
} else if($request == 'infos'){
	global $wpdb;
	echo "prefix:$wpdb->prefix\n";
	echo "WP_DEBUG:". (WP_DEBUG ? "true" : "false") . "\n";
	echo "DB_COLLATE:". DB_COLLATE . "\n";
	echo "DB_CHARSET:". DB_CHARSET . "\n";
	echo "WP_CONTENT_URL:". WP_CONTENT_URL . "\n";
	echo "WP_PLUGIN_URL:". WP_PLUGIN_URL . "\n";
	echo "ZipArchive:". (class_exists('ZipArchive') ? "true": "false") . "\n";
} else {
	header("HTTP/1.0 500 Server error");
	die("Bad request.");
}

