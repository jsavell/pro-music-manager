<?php
namespace App\Config;
//use App\Classes as AppClasses;
use Core\Classes as CoreClasses;

/*
The $sitePages array represents the app's pages, which are used to generate user facing navigation and load controllers.

The keys correspond to controller names.

Each entry should have a corresponding user reachable file (with an arbitrary relative directory path) that:
	1. Includes the config file
	2. Does one of the following:
		a. Defines a controller and includes the loader 
		b. Redirects with $forceRedirectUrl

It's possible to have user (public) reachable files that aren't represented in this array by using the DefaultController and setting the
view with $controllerConfig. They simply won't have a navigation link in the HTML header.

Further configuration of the current SitePage is often done by the controllers that correspond to that SitePage.
*/

$sitePages = array(
			"Tracks" => new CoreClasses\CoreSitePage("tracks","tracks",SECURITY_USER),
			"Sales" => new CoreClasses\CoreSitePage("sales","sales",SECURITY_USER),
			"Libraries" => new CoreClasses\CoreSitePage("libraries","libraries",SECURITY_USER),
			"Genres" => new CoreClasses\CoreSitePage("genres","genres",SECURITY_USER));
?>