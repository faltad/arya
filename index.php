<?php
/* Faltad - SBRK*/

require_once('config.php');
require_once('lib/markdown.php');


$additional_styles = array();
$additional_js = array();
$menu = array();

ob_start();

$m = $default_module;
if (isset($_GET['m'])) {
  $m = $_GET['m'];
}
$m = str_replace('..', '', $m);
if (is_dir($m) && is_file($m . '/mod.php')) {
  require_once($m . '/mod.php');
}
else {
  require_once('404.php');
}

$content_total_layout = ob_get_contents();
ob_end_clean();
require_once('layout.php');

?>

<!-- Piwik -->
<script type="text/javascript">
var pkBaseURL = (("https:" == document.location.protocol) ? "https://piwik.sbrk.org/" : "http://piwik.sbrk.org/");
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
try {
var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
piwikTracker.trackPageView();
piwikTracker.enableLinkTracking();
} catch( err ) {}
</script><noscript><p><img src="http://piwik.sbrk.org/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
<!-- End Piwik Tracking Code -->