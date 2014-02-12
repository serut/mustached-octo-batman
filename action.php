<?php
require_once('common.php');

$jsonResponse = array();
$jsonResponse['success'] = false;

//Actions
switch($action){
	
	case 'edit':

	if($myUser!=false){
		$emptyMessage = ($page==MD_MENU?MD_MENU_DEFAUT_CONTENT:'Le contenu de  **'.$page.'** est vide :p');
		$content = file_exists($pagePath)?file_get_contents($pagePath):$emptyMessage;
		$jsonResponse['success'] = true;
		$jsonResponse['content'] = $content;
	}else{
		$jsonResponse['message'] = 'Vous ne pouvez pas editer tant que vous n\'êtes pas connecté.';
	}
		echo json_encode($jsonResponse);
	break;

	case 'save':
		if($myUser!=false){

			event('Modification '.$pagePath,$myUser->login.' a modifié le fichier '.$page.' le '. date('d/m/Y H:i:s'),$page);
			if(!is_dir(ARCHIVES_ROOT) ) mkdir(ARCHIVES_ROOT);
			$folders = explode('/',$pagePath);
			$p = array_pop($folders);
			$path = MD_ROOT;
			$archives = ARCHIVES_ROOT;
			foreach ($folders as $key => $dir) {
					if($key == 1) {
						$path = $dir;
					} elseif($key != 0) {
						$path .= '/'.$dir;
						$archives .= '/'.$dir;
					}
				if (!is_dir($path)) {
					mkdir($path);
				}
				if (!is_dir($archives)) {
					mkdir($archives);
				}
			}
			file_put_contents($pagePath, html_entity_decode($_['content'],ENT_QUOTES,'UTF-8'));
			if(!file_exists(ARCHIVES_ROOT.$page)) mkdir(ARCHIVES_ROOT.$page);
			copy($pagePath,ARCHIVES_ROOT.$page.'/'.date('d-m-Y'));
			$content = Parsedown::instance()->parse(html_entity_decode($_['content'],ENT_QUOTES,'UTF-8'));
			$jsonResponse['success'] = true;
			$jsonResponse['content'] = $content;
		}else{
			$jsonResponse['message'] = 'Vous ne pouvez pas editer tant que vous n\'êtes pas connecté.';
		}
		echo json_encode($jsonResponse);
	break;
	
	case 'login':
		if($_['login']=='admin' && $_['password']==ADMIN_PASSWORD){
			$myUser = (object) array();
			$myUser->login = 'admin';
			$_SESSION['user'] = serialize($myUser);
			$jsonResponse['success'] = true;
		}else{
			$jsonResponse['message'] = 'Mauvais login ou mot de passe.';
		}
		echo json_encode($jsonResponse);
	break;
	
	case 'logout':
			unset($_SESSION['user']);
			session_destroy();
	break;
	
	case 'loginBar':
		if(!$myUser){ ?>
			<input type="text" name="input-login" placeholder="Login" id="input-login"/> <input type="password" placeholder="Password" name="input-password" id="input-password"/> <div id="button-login" onclick="login();">Login</div>
		<?php }else{ ?>
			Identifié avec <span class="emphasis"><?php echo $myUser->login; ?></span> - <a onclick="disconnect()">Déconnexion</a>
		<?php } 
	break;
	
	case 'menu':
		$menuContent = file_exists($menuPath)?file_get_contents($menuPath):MD_MENU_DEFAUT_CONTENT;
		echo Parsedown::instance()->parse($menuContent);
	break;

	case 'deleteFile':
		if($myUser!=false){
			unlink($_['file']);
			$jsonResponse['success'] = true;
		}else{
			$jsonResponse['message'] = 'Vous ne pouvez pas editer tant que vous n\'êtes pas connecté.';
		}
		echo json_encode($jsonResponse);
	break;

	case 'rss':
		require_once('rss.php');
		header('Content-Type: text/xml; charset=utf-8');
		if(!file_exists(EVENT_FILE)) touch(EVENT_FILE);
		$events = json_decode(file_get_contents(EVENT_FILE));
		if(!file_exists(CACHE_RSS) || (time()-filemtime(CACHE_RSS))>REFRESH_RSS_TIME ){
	
			$rss = new Rss(APPLICATION_TITLE,$_SERVER['REMOTE_ADDR']);
			foreach($events as $event){
				$rss->add($event->title,$event->date,$event->link,$event->content);
			}
			file_put_contents(CACHE_RSS,$rss->publish());
		}	
		echo file_get_contents(CACHE_RSS);
	break;

	case 'files':
		$keyword = strtolower(isset($_['keyword'])?$_['keyword']:'');
		$files = glob(UPLOAD_FOLDER.'/*/*/*'.$keyword.'*');
		
		foreach($files as $file){
			if(is_file($file)){
				$onclick  = '';
				$dotpos = strrpos($file,'.');
				$extension = $dotpos!==false?strtoupper(substr($file,$dotpos+1)):'';
				switch($extension){
					case 'JPG':
                    case 'JPEG':
                    case 'PNG':
                    case 'GIF':
                    case 'BMP':
                    case 'SVG':
						$onclick = '![id]('.$file.')';
					break;
					case 'video':
					break;
					case 'sound':
					break;
					default:
						$onclick = '['.$file.']('.$file.')';
					break;
				}
			?>
				<li><div class="file-name" onclick="appendText('<?php echo $onclick ;?>');"><img src="img/icon-file.png" align="absmiddle"> <?php 
				$name = basename($file);
				echo strlen($name)>25?substr($name,0,25).'...':$name;
				?></div><div onclick="deleteFile('<?php echo $file; ?>',this)" class="icon-file-delete"></div> <!--<div class="icon-file-setting"></div>--><div class="clear"></div></li>
			<?php
			}
		}			
	break;

	case 'upload':
			if(!$myUser) exit();
				if(array_key_exists('files',$_FILES) && $_FILES['files']['error'][0] == 0 ){
					$pic = $_FILES['files'];
					$pic['name'] = utf8_decode($pic['name'][0]);
					$pic['name'] = stripslashes($pic['name']);
					$pic['tmp_name'] = $pic['tmp_name'][0];

					$dotpos = strrpos($pic['name'],'.');
					$extension = $dotpos!==false?strtoupper(substr($pic['name'],$dotpos+1)):'';

					$size = filesize($pic['tmp_name']);
					

					if($size<=(MAX_UPLOAD_SIZE*1048576)){

						$month = date('m').'/';
						$year = date('Y').'/';
						if(!file_exists('./'.UPLOAD_FOLDER)) mkdir('./'.UPLOAD_FOLDER);
						if(!file_exists('./'.UPLOAD_FOLDER.$year)) mkdir('./'.UPLOAD_FOLDER.$year);
						if(!file_exists('./'.UPLOAD_FOLDER.$year.$month)) mkdir('./'.UPLOAD_FOLDER.$year.$month);

						$destination = './'.UPLOAD_FOLDER.$year.$month.strtolower($pic['name']);

						if(move_uploaded_file($pic['tmp_name'], $destination)){
							$javascript['status'] = 'Fichier envoy&eacute; avec succ&egrave;s!';
							$javascript['extension'] = $extension;
							$javascript['succes'] = true;
							$javascript['path'] = $destination ;
							$javascript['file'] = $pic['name'];
						}
					}else{
						$javascript['status'] = 'Taille maximale : %Mo d&eacute;pass&eacute;e'.MAX_UPLOAD_SIZE;
					}
				}else{
					$javascript['status'] = 'Probl&egrave;me rencontr&eacute; lors de l\'upload';
				}
				echo json_encode($javascript);
			
	break;
	default:
		exit('Aucune action spécifiée...');
	break;
}
?>