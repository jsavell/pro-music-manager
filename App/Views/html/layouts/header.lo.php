<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $config['APP_NAME'];?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="<?php echo $config['PATH_CSS'];?>style.css" media="screen"/>
        <link rel="stylesheet" media="(min-width:921px) and (max-width: 1024px)" href="<?php echo $config['PATH_CSS'];?>style.large.css" type="text/css" />
        <link rel="stylesheet" media="(min-width:601px) and (max-width: 920px)" href="<?php echo $config['PATH_CSS'];?>style.med.css" type="text/css" />
        <link rel="stylesheet" media="(max-width: 600px)" href="<?php echo $config['PATH_CSS'];?>style.small.css" type="text/css" />
<?php
$controllerAssetName = strtolower($controllerName);
if (is_file("{$config['PATH_APP']}assets/css/{$controllerAssetName}.css")) {
    echo '<link rel="stylesheet" type="text/css" href="'.$config['PATH_CSS'].$controllerAssetName.'.css" media="screen"/>';
}
?>
        <script type="text/javascript" src="<?php echo $config['PATH_JS'];?>jquery.min.js"></script>
        <script type="text/javascript">
            var path_http = '<?php echo $config["PATH_HTTP"];?>';
            var app_http = '<?php echo $app_http;?>';
        </script>
        <script type="text/javascript" src="<?php echo $config['PATH_JS'];?>default.js"></script>
<?php
if (is_file("{$config['PATH_APP']}assets/js/{$controllerAssetName}.js")) {
    echo '  <script type="text/javascript" src="'.$config['PATH_JS'].$controllerAssetName.'.js"></script>';
}
?>
        <link rel="shortcut icon" href="ico/favicon.ico">
    </head>
    <body class="page-<?php echo $controllerAssetName;?>">
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
            <div class="navigation">
<?php
if ($globalUser->isLoggedIn() && $controllerName !== 'default') {

    foreach ($pages as $controllerKey => $sitePage) {
        if ($controllerName == $controllerKey) {
           echo "<a class=\"capitalize current\" href=\"{$config['PATH_HTTP']}{$sitePage->getPath()}/\">{$sitePage->getName()}</a>";
        } else {
            echo "<a class=\"capitalize\" href=\"{$config['PATH_HTTP']}{$sitePage->getPath()}/\">{$sitePage->getName()}</a>";
        }
    }
}
?>
<?php
if ($globalUser->isLoggedIn()) {
    echo '      <div id="userStatus">Hi '.$globalUser->getProfileValue('username').'! (<a href="'.$config['PATH_HTTP'].'logout.php">logout</a>)</div>';
}
echo '       </div>';
//present any system messages
if ($systemMessages) {
	echo ' <div class="sysMsg">';
	foreach ($systemMessages as $msg) {
		echo "<h4>{$msg->getMessage()}</h4>";
	}
	echo ' </div>';
}
echo '     <div class="page-header">';
if ($page->getTitle()) {
    echo "      <h1>{$page->getTitle()}</h1>";
}
/*if (isset($page['navigation'])) {
    $size = sizeof($page['navigation']);
    $navWidth = 15*.6*$size;
    $btnWidth = $navWidth/($size*.4);
    echo "      <div class=\"navigation subNav\">";
    foreach ($page['navigation'] as $subnav) {
        $isCurrent = (isset($data['action']) && isset($subnav['action']) && $subnav['action'] == $data['action']) || (!isset($data['action']) && !isset($subnav['action']));
        echo "      <a style=\"width:{$btnWidth}%\" class=\"capitalize".($isCurrent ? ' current':'').(!empty($subnav['modal']) ? ' do-loadmodal':'')."\" href=\"{$app_http}".((isset($subnav['action'])) ? "?action={$subnav['action']}":'')."\">{$subnav['name']}</a>";
    }
    echo '      </div>';
}*/

if ($page->getOptions()) {
    $size = sizeof($page->getOptions());
    $navWidth = 15*.6*$size;
    $btnWidth = $navWidth/($size*.4);
    echo "      <div class=\"navigation subNav\">";
    foreach ($page->getOptions() as $subnav) {
        $isCurrent = (isset($data['action']) && isset($subnav['action']) && $subnav['action'] == $data['action']) || (!isset($data['action']) && !isset($subnav['action']));
        echo "      <a style=\"width:{$btnWidth}%\" class=\"capitalize".($isCurrent ? ' current':'').(!empty($subnav['modal']) ? ' do-loadmodal':'')."\" href=\"{$app_http}".((isset($subnav['action'])) ? "?action={$subnav['action']}":'')."\">{$subnav['name']}</a>";
    }
    echo '      </div>';
}


if ($page->isSearchable()) {
    echo '      <form id="doSearch" class="do-submit inline" name="search" method="POST" action="'.$app_http.'">
                    <input type="hidden" name="action" value="search" />
                    <input id="searchTerm" class="date-input-db inline" type="text" name="term" />';
    echo '          <input id="searchResults" class="inline" type="submit" name="submit" value="Search" />
                    <div class="inline" id="searchStatus">
                        <a class="hidden" href="#clearSearch">clear search</a>
                    </div>
                </form>';
}
echo '    </div>';

?>
        </header>
        <div class="container">
          <div id="modalContent">
<?php
if ($page->getSubTitle()) {
	echo "     <h4 class=\"capitalize\">{$page->getSubTitle()}</h4>";
}

?>

