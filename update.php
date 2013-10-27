<?php 
require_once('common.php');


function triggerDirectOutput() {
		if (function_exists('apache_setenv')) {
			/* Selon l'hébergeur la fonction peut être désactivée. Alors Php
			   arrête le programme avec l'erreur :
			   "PHP Fatal error:  Call to undefined function apache_setenv()".
			*/
			@apache_setenv('no-gzip', 1);
		}
		@ini_set('zlib.output_compression', 0);
		@ini_set('implicit_flush', 1);
		for ($i = 0; $i < ob_get_level(); $i++) { ob_end_flush(); }
		ob_implicit_flush(1);
}

/**
 * Unzip the source_file in the destination dir
 *
 * @param   string      The path to the ZIP-file.
 * @param   string      The path where the zipfile should be unpacked, if false the directory of the zip-file is used
 * @param   boolean     Indicates if the files will be unpacked in a directory with the name of the zip-file (true) or not (false) (only if the destination directory is set to false!)
 * @param   boolean     Overwrite existing files (true) or not (false)
 * 
 * @return  boolean     Succesful or not
 */
function unzip($src_file, $dest_dir=false, $create_zip_name_dir=true, $overwrite=true)
{
  if ($zip = zip_open($src_file))
  {
    if ($zip)
    {
      $splitter = ($create_zip_name_dir === true) ? "." : "/";
      if ($dest_dir === false) $dest_dir = substr($src_file, 0, strrpos($src_file, $splitter))."/";
     
      // Create the directories to the destination dir if they don't already exist
      create_dirs($dest_dir);

      // For every file in the zip-packet
      while ($zip_entry = zip_read($zip))
      {
        // Now we're going to create the directories in the destination directories
       
        // If the file is not in the root dir
        $pos_last_slash = strrpos(zip_entry_name($zip_entry), "/");
        if ($pos_last_slash !== false)
        {
          // Create the directory where the zip-entry should be saved (with a "/" at the end)
          create_dirs($dest_dir.substr(zip_entry_name($zip_entry), 0, $pos_last_slash+1));
        }

        // Open the entry
        if (zip_entry_open($zip,$zip_entry,"r"))
        {
         
          // The name of the file to save on the disk
          $file_name = $dest_dir.zip_entry_name($zip_entry);
         
          // Check if the files should be overwritten or not
          if ($overwrite === true || $overwrite === false && !is_file($file_name))
          {
            // Get the content of the zip entry
            $fstream = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

            @file_put_contents($file_name, $fstream );
            // Set the rights
            chmod($file_name, 0777);
            echo "<li>Creation: ".$file_name."</li>";
          }
         
          // Close the entry
          zip_entry_close($zip_entry);
        }      
      }
      // Close the zip-file
      zip_close($zip);
    }
  }
  else
  {
    return false;
  }
 
  return true;
}

/**
 * This function creates recursive directories if it doesn't already exist
 *
 * @param String  The path that should be created
 * 
 * @return  void
 */
function create_dirs($path)
{
  if (!is_dir($path))
  {
    $directory_path = "";
    $directories = explode("/",$path);
    array_pop($directories);
   
    foreach($directories as $directory)
    {
      $directory_path .= $directory."/";
      if (!is_dir($directory_path))
      {
        mkdir($directory_path);
        chmod($directory_path, 0777);
      }
    }
  }
}
?>
<html>
<head>
<style>
	html,body{
		min-height:100%;
		background-color: #dedede;
		padding: 0px;
		margin:0px;
	}
#container{
	background-color: #ffffff;
	width:50%;
	margin:auto;
	color:#969696;
	font-family: Verdana,Arial;
	font-size:11px;
	min-height:100%;
	box-shadow: 0 0 25px 1px rgba(0, 0, 0, 0.2);
	padding:10px;
}
</style>
</head>
<body>
	<div id="container">
		<ol>
		<?php 

		echo '<li>Récuperation des informations locales...';
		echo '
		<ul>
			<li><strong>Application:</strong> '.APPLICATION_TITLE.'</li>
			<li><strong>Version:</strong> '.APPLICATION_VERSION.'</li>
			<li><strong>Updater:</strong> '.UPDATE_URL.'</li>
		</ul>
		</li>';
		echo '<li>Récuperation des informations distantes...';
		try{
			$json_content = json_decode(substr(file_get_contents(UPDATE_URL),4,-2),true);
			$dist = $json_content['maj'][0];
			$version = $dist['version'];
			$sql = $dist['sql'];
			echo '<ul>
			<li><strong>Dernière Version:</strong> '.$version.'</li>
			<li><strong>Archive:</strong> '.$dist['archive'].'</li>
			</ul></li>';
			echo '<li>Différentiel des versions...<ul><li><strong>Différentiel:</strong> ';
			$vl = explode('.',APPLICATION_VERSION);
			$vd = explode('.',$version);
			
			if(!($vl[0]==$vd[0] && $vl[1]==$vd[1] && $vl[2]==$vd[2])){

			echo '-'.abs($vd[0]-$vl[0]).'.'.abs($vd[1]-$vl[1]).'.'.abs($vd[2]-$vl[2]).'</li></ul></li>';

			echo '<li>Récuperation des fichiers de la nouvelle version (archive: '.$dist['archive'].')<ul>';
			try{
				$zipName = time().'.zip';
				file_put_contents($zipName,file_get_contents($dist['archive']));
				unzip($zipName, false, true, true);
				echo '</ul></li>';
				echo '<li>Suppression de l\'archive de mise à jour</li>';
				unlink($zipName);
			}catch(Exception $e){
				echo '</ul></li><li>Impossible de récuperer l\'archive distante, erreur :'.$e.'</li>';
			}
			
			echo '<li>Mise à jour de la base de donnée</li>';
			
			}else{
				echo 'Version locale à jour ('.$version.') aucune action à effectuer.</li>';
			}
		}catch(Exception $e){
			echo 'Impossible de parser les informations distantes, erreur :'.$e.'</li>';
		}
		
		?>
		</ol>
	</div>
</body>
</html>