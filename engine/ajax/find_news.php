<?php
if(!defined('DATALIFEENGINE')) {
	header( "HTTP/1.1 403 Forbidden" );
	header ( 'Location: ../../' );
	die( "Hacking attempt!" );
}

if( $_REQUEST['user_hash'] == "" OR $_REQUEST['user_hash'] != $dle_login_hash ) {
	die( "error" );
}

if( preg_match( "/[\||\<|\>|\"|\!|\?|\$|\@|\/|\\\|\&\~\*\+]/", $_GET['term'] ) ) $term = "";
else $term = $db->safesql( htmlspecialchars( strip_tags( stripslashes( trim( $_GET['term'] ) ) ), ENT_QUOTES, $config['charset'] ) );

if( $term == "" ) die("[]");

$buffer = "[]";
$news = array ();

$db->query("SELECT id, title FROM " . PREFIX . "_post WHERE approve=1 AND title LIKE '%{$term}%' ORDER by date DESC LIMIT 10");

while($row = $db->get_row()){
	
	$news[] = array("label"=>"{$row['title']}", "value"=>"{$row['id']}");

}

if (count($news)) {

	die(json_encode($news));
	
}
?>
