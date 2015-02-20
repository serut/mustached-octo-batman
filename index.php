<?php
require_once('common.php');

//Lecture de la page courante et conversion markdown/html
$pageContent = file_exists($pagePath )?file_get_contents($pagePath):'La page **'.$page.'** n\'existe pas !';
//Mode lecture/mode edition
$pageContent = Parsedown::instance()->parse($pageContent);


?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Wiki - Unreal Gaming</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/skin.css">
		<link rel="icon" type="image/png" href="favicon.png" />
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
    </head>
    <body onbeforeunload ="checkPendingTask();">
        <!--[if lt IE 7]>
            <p>Vous utilisez un navigateur <strong>obsolète</strong>. Si il vous plais, <a href="http://browsehappy.com/">mettez à jour votre naviguateur</a> afin d'améliorer votre naviguation.</p>
        <![endif]-->
		
        <!-- Add your site or application content here -->
        <div id='main-container'>
		
				<div id='menu-container'>
						<div id="logo" onclick="window.location='index.php';"><img src="./images/logo.jpg"></div>
						<ul id='menu'></ul>
						<div id='option-edit-menu' onclick="edit('<?php echo MD_MENU; ?>',this,'menu');">Editer</div>
					<div id='media-container'>
						<div id='search-zone'>
							<img src="img/icon-search.png" align="absmiddle"> <input type="text" placeholder="keyword" id="search-input">
						</div>

						<div id="drop-container" title="Faites glisser des fichiers sur la zone ou cliquez sur celle ci pour envoyer des fichiers">
							<div id="drop-zone">
								<input id="uploadButton" type="file" size="1" name="files[]" data-url="./action.php?action=upload" multiple>
							</div>
						</div>
						
						<ul id='file-list'></ul>
					</div>
					<div class="rss-button" onclick="window.location.href='action.php?action=rss'">Flux Rss</div>

					<!--
					<div id='share-container'>
						<ul id='tags-list'>
							<li>Tag 1</li>
							<li>Tag 2</li>
						</ul>
						<ul id='related-list'>
							<li>ilot 1</li>
							<li>ilot 2</li>
						</ul>
					</div>
				-->
				
				</div>
				<div id='content-container'>
					
					<div id='content'>
						<?php echo $pageContent; ?>
					</div>
					<ul id='content-options'>
						<li id="option-edit" onclick="edit('<?php echo $page ?>',this);">Editer</li>
						<li id="option-login">Login</li>
						<li id="global-preloader"><img src="" align="absmiddle"> Loading...</li>
						<!--<li onclick="share();">Partager</li>
						<li onclick="delete();">Supprimer</li>-->
					</ul>
					
					
				</div>
			</div>
			<div class='clear'></div>
			<div id='footer-container'></div>
			<div id="UPDATE_URL" class="hidden"><?php echo UPDATE_URL; ?></div>
			<div id="APPLICATION_VERSION" class="hidden"><?php echo APPLICATION_VERSION; ?></div>
        <!--<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
		<script type="text/javascript" src="js/vendor/jquery.ui.widget.js"></script>
        <script type="text/javascript" src="js/vendor/jquery.fileupload.js"></script>
		<script type="text/javascript" src="js/vendor/jquery.iframe-transport.js"></script>
		<script type="text/javascript" src="js/vendor/jquery-litelighter.js"></script>
		<script type="text/javascript" src="js/vendor/jquery.markitup.js"></script>
		<script type="text/javascript" src="js/plugins.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
    </body>
</html>
<?php
if ($page == MD_ACCUEIL) {
?>
<script type="text/javascript">
$(function() {
	$.ajax({
		type: "POST",
		url: "server.php?type=cod4&ip=91.121.55.41&port=28930",
		// contentType: "application/json; charset=utf-8",
		error: function (x, e) { console.log(e.responseText); },
		success: function (data) {
			html = $.parseHTML(data)
			$('#server-cod4').append(html);
		}
	});
	$.ajax({
		type: "POST",
		url: "server.php?type=dods&ip=162.252.82.28&port=27015",
		// contentType: "application/json; charset=utf-8",
		error: function (x, e) { console.log(e.responseText); },
		success: function (data) {
			html = $.parseHTML(data)
			$('#server-dods').append(html);
		}
	});
	$.ajax({
		type: "POST",
		url: "server.php?type=tf2&ip=66.150.155.159&port=27016",
		// contentType: "application/json; charset=utf-8",
		error: function (x, e) { console.log(e.responseText); },
		success: function (data) {
			html = $.parseHTML(data)
			$('#server-tf2').append(html);
		}
	});
});
</script>
<?php
}
?>
