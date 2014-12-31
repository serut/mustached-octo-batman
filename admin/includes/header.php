<!DOCTYPE html>
<html>
	<head>
		<title>Dashboard</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styles/style.css" type="text/css" media="screen" charset="utf-8">
		<link rel="stylesheet" href="styles/menu.css" type="text/css" media="screen" charset="utf-8">
	</head>

	<body>
		<header>
			<div class="topWrapper">
			        <div style="float: left;">
	        		        <h1><img src="images/debian_logo.png" style="float: left; margin-top: -15px;"> <?php echo gethostname(); ?>.</h1>
	                		<h2>The Dashboard Control Center</h2>
	               		</div>
				<?php
					$distroTypeRaw = exec("cat /etc/*-release | grep PRETTY_NAME=", $out);
		  		      	$distroTypeRawEnd = str_ireplace('PRETTY_NAME="', '', $distroTypeRaw);
		     			$distroTypeRawEnd = str_ireplace('"', '', $distroTypeRawEnd);
			      		$kernel = exec("uname -mrs");
                       			$firmware = exec("uname -v");
				?>
				<div style="text-align: right; padding-top: 4px; color: #FFFFFF; font-family: Arial; font-size: 13px; float: right; width:500px;">
		                	<strong>Hostname:</strong> <?php echo gethostname(); ?> &middot; 
		                	<strong>Internal IP:</strong> <?php echo $_SERVER['SERVER_ADDR']; ?><br/>
		                	<strong>Accessed From:</strong> <?php echo $_SERVER['SERVER_NAME']; ?> &middot; 
		                	<strong>Port:</strong> <?php echo $_SERVER['SERVER_PORT']; ?> &middot; 
		                	<strong>HTTP:</strong> <?php echo $_SERVER['SERVER_SOFTWARE']; ?><br/><br/>
		                	<?php echo "<strong>Distribution:</strong> ".$distroTypeRawEnd; ?><br/>
		                	<?php echo "<strong>Kernel:</strong> ".$kernel; ?><br/>
				</div>
			</div>
		</header>
