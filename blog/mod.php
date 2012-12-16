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
	$menu[$prestr . " $key"] = 'index.php?m=blog&filter='.$tmp;
	forge_menu($file, $filter, $tmp, $menu, $nb + 1);
      }
      else
	{	  
	  $menu[$prestr . " $key"] = 'index.php?m=blog&filter='.$tmp;
	}
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
	$infos = stat($dirname . '/' . $file);
	$ar_file[$infos['ctime'] . '|' . $file] = $file;
      }
    }
  }
  @closedir($dir);
  return $ar_file;
}

function getAllNames($files, $filter, &$ar, $root)
{
  foreach ($files as $key => $file) {
    if (is_array($file)) {
      $tmp = (strlen($root) > 0 ? $root . '/' : '') . $key; 
      $len = (strlen($filter) > strlen($tmp) ? strlen($tmp) : strlen($filter));
      if (strncmp($filter, $tmp, $len) === 0) {
	getAllNames($file, $filter, $ar, $tmp);
      }
    }
    else {
      if (strncmp($filter, $root, strlen($filter)) === 0) {
	$ar[$key] = 'blog/files/' . $root . '/' . $file;
      }
    }
  }
}


$additional_styles[] = 'blog/blog.css';
$filter = '';
$menu['Index'] = 'index.php?m=blog';
$nb_art = 5;
$offset = 0;
$title = 'Arya - Blog';

if (isset($_GET['filter'])) {
  $filter = $_GET['filter'];
  $filter = str_replace('..', '', $filter);
}

/* Offsset of articles*/
if (isset($_GET['off']))
  $offset = intval($_GET['off']);

if (($files = parse_directory(__DIR__.'/files')) !== false) {
  forge_menu($files, $filter, '', $menu);

  $ar = array();
  getAllNames($files, $filter, $ar, '');
  krsort($ar);

  if (count($ar) > $offset + $nb_art)
    $next_offset = '?m=blog&off=' . ($offset + $nb_art) . (strlen($filter) > 0 ? '&filter='.$filter : '');
  if ($offset > 0) {
    $prec = $offset - $nb_art;
    if ($prec < 0)
      $prec = 0;
    $prec = '?m=blog&off='. $prec . (strlen($filter) > 0 ? '&filter='.$filter : '');
  }
  $cur_files = array();
  $i = 0;
  foreach ($ar as $key => $file) {
    if ($i >= $offset && $i < $offset + $nb_art)
      $cur_files[] = array(
	'title' => $file,
	'created_at' => date('d-m-Y', $key),
	'content' => Markdown(file_get_contents($file)));
    $i++;
  }
  require_once('template.php');
}

?>