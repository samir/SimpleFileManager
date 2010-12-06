<?php

include('functions.php');

header("Content-Type: text/html; charset=UTF-8");
date_default_timezone_set('America/Sao_Paulo');

# Parameters
# ------------------------------------------------------------------------------

$_base   = $_SERVER['DOCUMENT_ROOT'] . '/assets/';




# Configuration 
# ------------------------------------------------------------------------------

$_config = parse_ini_file('config.ini',true);

$action = (isset($_GET['action'])) ? $_GET['action'] : false;
$user   = (isset($_GET['user']))   ? $_GET['user']   : false;
$hash   = (isset($_GET['hash']))   ? $_GET['hash']   : false;

$page_title = strtoupper($user) . " &laquo; SimpleFileManager";

# Validations
# ------------------------------------------------------------------------------

$error = false;

// No user defined in URL
if(!$user) $error = 1;

// No user defined in config
if(!isset($_config[$user])) $error = 2;

// No correspondent folder in `assets/`
if(!is_dir($_base.$user)) $error = 3;

// Redirect if error
if($error) header('Location: /?e='.$error);


# Get Files list
# ------------------------------------------------------------------------------

$user_folder = $_base.$user.'/';


# Check directory permissions and set write if necessary
# ------------------------------------------------------------------------------

directory_permission($_base,0777);
directory_permission($user_folder,0777);


$total = array('qtd'=>0,'size'=>0);

try
{
  $hdl = new DirectoryIterator($user_folder);
  $files_list = array();
  foreach($hdl as $item )
  {
    $hash_key = md5($user.$item);
    $files_list[$hash_key] = array(
                      'mtime'    => date('d/m/Y H:i:s',$item->getMTime()),
                      'path'     => $item->getPath(),
                      'pathname' => $item->getPathname(),
                      'filename' => $item->getFilename(),
                      'size'     => byte_format($item->getSize()),
                      'del_path' => "/u/{$user}/del/{$hash_key}",
                      'get_path' => "/u/{$user}/get/{$hash_key}",
                   );

    if(!in_array($item->getFilename(),array('.','..')))
    {
      $total['qtd']++;
      $total['size'] += $item->getSize(); 
    }
  }
}
/*** if an exception is thrown, catch it here ***/
catch(Exception $e)
{
  $list = $e;
}




# Verify actions
# ------------------------------------------------------------------------------

if($action == 'get')
{

  validate_hash($hash,$user);

  $file = $files_list[$hash]['pathname'];
  $filename = $files_list[$hash]['filename'];

  // Extract the type of file which will be sent to the browser as a header
  $type = filetype($file);
   
  // Get a date and timestamp
  $today = date("F j, Y, g:i a");
  $time = time();
   
  // Send file headers
  header("Content-type: $type");
  header("Content-Disposition: attachment;filename=$filename");
  header("Content-Transfer-Encoding: binary");
  header('Pragma: no-cache');
  header('Expires: 0');
  // Send the file contents.
  set_time_limit(0);
  readfile($file);
  die; 


}


if($action == 'del')
{
  
  validate_hash($hash,$user);

  $file = $files_list[$hash]['pathname'];
  if(is_file($file))
  {
    if(@unlink($file))
    {
      unset($files_list[$hash]);
    }
  }
}

// Show template

include('view/header.php');
include('view/main.php');
include('view/footer.php');
