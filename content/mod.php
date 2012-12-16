<?php

function forge_menu($files, $filter, $root, &$menu, $nb = 1)
{
  $prestr = '';
  for ($i = 0; $i < $nb; $i++)
    $prestr .= ">";

  foreach ($files as $key => $file) {
    if (is_array($file)) {
      $tmp = (strlen($root) > 0 ? $root .'/' : '') . $key;
      if (strncmp($tmp, $filter, strlen($tmp)) == 0) {
	$menu[$prestr . " $key/"] = 'index.php?m=content&filter='.$tmp;
	forge_menu($file, $filter, $tmp, $menu, $nb + 1);
      }
      else
	$menu[$prestr . " $key/"] = 'index.php?m=content&filter='.$tmp;
    }
    else {
      $menu[$prestr . " $file"] = 'index.php?m=content&filter='.(strlen($root) > 0 ? $root.'/' : '').$file;
    }
  }
}

function parse_directory($dirname)
{
  $dir = @opendir($dirname);
  if (!$dir) {
    echo "Erreur lors de l'ouverture du répertoire des articles de blogs";
    return false;
  }
  
  $ar_file = array();
  while (($file = readdir($dir)) !== false) {
    if ($file != '.' && $file != '..') {
      if (is_dir($dirname . '/' . $file)) {
	$ar_file[$file] = parse_directory($dirname . '/' . $file);
      }
      else {
	$ar_file[$infos['ctime'] . '|' . $file] = $file;
      }
    }
  }
  @closedir($dir);
  return $ar_file;
}

function epur_filename($filename, $remove_slash = true)
{
  $file = '';
  for ($i = 0; $i < strlen($filename); $i++) {
    if ($filename[$i] != '.')
      if (!$remove_slash || $filename[$i] != '/')
	$file .= $filename[$i];
  }
  return $file;
}

$additional_styles[] = 'content/content.css';
$filter = '';
$title = 'Arya';

if (isset($_GET['filter']))
  $filter = epur_filename($_GET['filter'], false);

if (($files = parse_directory(__DIR__.'/files')) !== false) {
  forge_menu($files, $filter, '', $menu);
    
  if (is_file('content/files/' . $filter)) {
    $content = Markdown(file_get_contents('content/files/' . $filter));
  }
  else if (is_dir('content/files/'.$filter)) {
    $cur_files = array();
    $files = scandir('content/files/'.$filter);
    for ($i = 0; $i < count($files); $i++) {
      if (!is_dir('content/files/' . $filter . '/' .$files[$i]))
	$cur_files[$files[$i]] = '?m=content&filter='.$filter.'/'.$files[$i];
    }
  }
  else {
  }

  require_once('template.php');
}

?>