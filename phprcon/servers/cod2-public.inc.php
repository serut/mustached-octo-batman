<?php
// here is a place to enter specific settings for this server

//$server_ip = '192.168.1.240';
include('ipservers.inc.php');
$server_port = 28950;
$server_rconpass = 'unreal09';

$server_timeout = 2;			// enter a number of seconds before connection to server times out; default=2 (try lower for increased performance, higher for troubleshooting)
$server_buffer = 32768;			// enter a number of bytes; decrease if you receive only a part of playerlist, increase to speed up
// $server_extra_footer = true;	// true | false; if problems with receiving playerlist occur, enable

// $list_of_gtypes[] = 'utd UT Domination';
// $list_of_maps[] = 'mp_silotown Silotown';     // extra maps for this server

$screenshots_path = '/opt/callofduty2/pb/svss';		// path must contain the file pbsvss.htm, it may be local or remote (beginning with http:// or ftp://user:pass@hostname/ , it may be limited to webserver's IP)

?>
