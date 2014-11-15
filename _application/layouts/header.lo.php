<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $config['title'];?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="<?php echo $config['path_css'];?>style.css" media="screen"/>
        <script type="text/javascript" src="<?php echo $config['path_js'];?>jquery.min.js"></script>
        <script type="text/javascript">
            var app_http = '<?php echo $app_http;?>';
        </script>
        <script type="text/javascript" src="<?php echo $config['path_js'];?>default.js"></script>
        <link rel="shortcut icon" href="ico/favicon.ico">
    </head>
    <body>
        <div id="theOverlay"></div>
        <div id="theModal">
            <div class="header">
                <a class="do-close" href="#">Close</a>
            </div>
            <div class="content">
            </div>
        </div>
        <header>
            <h1>The Production Music Manager</h1>
        </header>
        <div class="navigation">
<?php
foreach ($pages as $nav) {
    if ($controller == $nav['path']) {
       echo "<a class=\"capitalize current\" href=\"{$config['path_http']}{$nav['path']}/\">{$nav['name']}</a>";
    } else {
        echo "<a class=\"capitalize\" href=\"{$config['path_http']}{$nav['path']}/\">{$nav['name']}</a>";
    }
}
?>
        </div>
<?php
//present any system messages
if (isset($system)) {
	echo '<div class="sysMsg">';
	foreach ($system as $msg) {
		echo "<h4>{$msg}</h4>";
	}
	echo '</div>';
}
?>
        <div class="container">
<?php
if (isset($page['title'])) {
	echo " <h1>{$page['title']}</h1>";
}
echo '     <div>';
if (isset($page['navigation'])) {
    $size = sizeof($page['navigation']);
    $navWidth = 15*$size;
    $btnWidth = $navWidth;
    echo "      <div style=\"width:{$navWidth}%\" class=\"inline-block navigation subNav\">";
	foreach ($page['navigation'] as $subnav) {
        $isCurrent = (isset($data['action']) && isset($subnav['action']) && $subnav['action'] == $data['action']) || (!isset($data['action']) && !isset($subnav['action']));
		echo "    <a style=\"width:{$btnWidth}%\" class=\"capitalize".($isCurrent ? ' current':'').(isset($subnav['modal']) ? ' do-loadmodal':'')."\" href=\"{$app_http}".((isset($subnav['action'])) ? "?action={$subnav['action']}":'')."\">{$subnav['name']}</a>";
	}
}
echo '          </div>';
if (isset($page['search'])) {
    echo '  <form class="do-submit inline" name="search" method="POST" action="'.$app_http.'">
                <input type="hidden" name="action" value="search" />
                <input class="inline" type="text" name="term" />';
/*
    foreach ($page['search'] as $field) {
        if ($field['type'] == 'text') {
            echo '  <input class="inline" type="text" name="search['.$field['name'].']" />';
        }
    }
*/
     echo '     <input class="inline" type="submit" name="submit" value="Search" />
            </form>';
}
echo '    </div>';
if (isset($page['subtitle'])) {
	echo " <h4 class=\"capitalize\">{$page['subtitle']}</h4>";
}

?>
