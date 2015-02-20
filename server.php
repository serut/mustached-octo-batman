<?php
// Include the main class file
require './GameQ/GameQ.php';

// Define your servers,
// see list.php for all supported games and identifiers.
$servers = array(
	array(
		'id' => 'serveur',
		'type' => $_GET['type'],
		'host' => $_GET['ip'].':'.$_GET['port'],
	)
);


// Call the class, and add your servers.
$gq = new GameQ();
$gq->addServers($servers);

// You can optionally specify some settings
$gq->setOption('timeout', 8); // Seconds

// You can optionally specify some output filters,
// these will be applied to the results obtained.
$gq->setFilter('normalise');

// Send requests, and parse the data
$results = $gq->requestData();


// Some functions to print the results

function print_serveur($data) {

    $gqs = array('gq_online', 'gq_address', 'gq_port', 'gq_prot', 'gq_type');


    if (!$data['gq_online']) {
        printf("<p>Le serveur ".$data["gq_type"]." (".$data["gq_address"].":".$data["gq_port"].") n'a pas répondu.</p>\n");
        return;
    }
    echo "<div>Server name: <strong>" . $data["gq_hostname"]."</strong> - status: <span style='color:green;'>ONLINE<span></div>";
    echo "<div>IP Adress: <strong>" . $data["gq_address"]."</strong>:<strong>" . $data["gq_port"]."</strong>";
    echo " - players: " . $data["gq_numplayers"] . "/" . $data["gq_maxplayers"]."</div>";
    if (!empty($data["players"])) {
    	echo "<table><thead><tr><td>Pseudo</td><td>Score</td><td>Ping</td></tr></thead><tbody>";
	    foreach ($data["players"] as $k => $v) {
	    	echo "<tr><td>" . $v["name"] . "</td><td>" . $v["gq_score"] . "</td><td>" . $v["ping"] . "</td></tr>";
	    }
    	echo "</tbody></table>";
    }
}
function print_results($results) {

    foreach ($results as $id => $data) {

        printf("<h2>%s</h2>\n", $id);
        print_serveur($data);
    }
}
function display_variable($data) {
    print("<table><thead><tr><td>Variable</td><td>Value</td></tr></thead><tbody>\n");
    foreach ($data as $key => $val) {

        if (is_array($val)) {
        	if ($key == "players") { 
	        	foreach ($val as $k => $v) {
	        		// var_dump ($v["name"] . " " . $v["gq_score"] . " " . $v["gq_ping"]);
	        	}
        	}
        } else {
	        $cls = empty($cls) ? ' class="uneven"' : '';

	        if (substr($key, 0, 3) == 'gq_') {
	            $kcls = (in_array($key, $gqs)) ? 'always' : 'normalise';
	            $key = sprintf("<span class=\"key-%s\">%s</span>", $kcls, $key);
	        }

	        printf("<tr%s><td>%s</td><td>%s</td></tr>\n", $cls, $key, $val);
        }
    }

    print("</tbody></table>\n");
}
	// Simple protection
	if (!empty($_GET['type']))
		print_serveur($results["serveur"]);
	else
		echo "Bad use of server.php";
?>