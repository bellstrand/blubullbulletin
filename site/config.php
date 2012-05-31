<?php
/**
* Site configuration, this file is changed by the user per site.
*
*/

/**
* Set level of error reporting.
*/
error_reporting(-1);
ini_set('display_errors', 1);

/**
* Set what to show as debug or developer information in the get_debug() theme helper.
*/
$ly->config['debug']['lydia'] = false;
$ly->config['debug']['session'] = false;
$ly->config['debug']['timer'] = false;
$ly->config['debug']['db-num-queries'] = false;
$ly->config['debug']['db-queries'] = false;

/**
* Set database(s)
*/
$ly->config['database'][0]['dsn'] = 'sqlite:' . LYDIA_SITE_PATH . '/data/.ht.sqlite';

/**
* What type of urls should be used?
*
* default		= 0		=> index.php/controller/method/arg1/arg2/arg3
* clean			= 1		=> controller/method/arg1/arg2/arg3
* querystring	= 2		=> index.php?q=controller/method/arg1/arg2/arg3
*/
$ly->config['url_type'] = 1;

/**
* Set a base_url to use another then the default calculated
*/
$ly->config['base_url'] = null;

/**
* Allow or disallow creation of new user accounts.
*/
$ly->config['create_new_users'] = true;

/**
* How to hash password of new users, choose from: plain, md5salt, md5, sha1salt, sha1.
*/
$ly->config['hashing_algorithm'] = 'sha1salt';

/**
* Define session name
*/
$ly->config['session_name'] = preg_replace('/[:\.\/-_]/', '', __DIR__);
$ly->config['session_key'] = 'lydia';

/**
* Define server timezone
*/
$ly->config['timezone'] = 'Europe/Stockholm';

/**
* Define internal character encoding
*/
$ly->config['character_encoding'] = 'UTF-8';

/**
* Define language
*/
$ly->config['language'] = 'en-US';

/**
* Define the controllers, their classname and enable/disable them.
*
* The array-key is matched against the url, for example:
* the url 'developer/dump' would instantiate the controller with the key 'developer', that is
* CCDeveloper and call the method 'dump' in that class. This process is managed in:
* $ly->FrontControllerRoute();
* which is called in the frontcontroller phase from index.php.
*/
$ly->config['controllers'] = array(
	'index' 	=> array('enabled' => true, 'class' => 'CCIndex'),
	'music'		=> array('enabled' => true, 'class' => 'CCMusic'),
	'cvg'		=> array('enabled' => true, 'class' => 'CCCvg'),
	'livestream'=> array('enabled' => true, 'class' => 'CCLivestream'),
	'about'		=> array('enabled' => true, 'class' => 'CCAbout'),
//	'developer' => array('enabled' => true, 'class' => 'CCDeveloper'),
//	'theme'		=> array('enabled' => true, 'class' => 'CCTheme'),
//	'guestbook' => array('enabled' => true, 'class' => 'CCGuestbook'),
	'content'	=> array('enabled' => true, 'class' => 'CCContent'),
//	'blog'		=> array('enabled' => true, 'class' => 'CCBlog'),
	'page'		=> array('enabled' => true, 'class' => 'CCPage'),
	'user'		=> array('enabled' => true, 'class' => 'CCUser'),
	'acp'		=> array('enabled' => true, 'class' => 'CCAdminControlPanel'),
	'module'	=> array('enabled' => true, 'class' => 'CCModules'),
//	'my'		=> array('enabled' => true, 'class' => 'CCMycontroller'),
);

/**
* Define a routing table for urls.
*
* Route custom urls to a defined controller/method/arguments
*/
$ly->config['routing'] = array(
	'home'		=> array('enabled' => true, 'url' => 'index/index'),
	'news'		=> array('enabled' => true, 'url' => 'index/news'),
	'sport'		=> array('enabled' => true, 'url' => 'index/sport'),
	'music'		=> array('enabled' => true, 'url' => 'music/index'),
	'cvg'		=> array('enabled' => true, 'url' => 'cvg/index'),
	'livestream'=> array('enabled' => true, 'url' => 'livestream/index'),
	'about'		=> array('enabled' => true, 'url' => 'about/index'),
);

/**
* Define menus.
*
* Create hardcoded menus and map them to a theme region through $ly->config['theme'].
*/
$ly->config['menus'] = array(
	'navbar' => array(
		'home'			=> array('label'=>'Home', 'url'=>'home'),
		'modules'		=> array('label'=>'Modules', 'url'=>'module'),
		'content'		=> array('label'=>'Content', 'url'=>'content'),
		'guestbook'		=> array('label'=>'Guestbook', 'url'=>'guestbook'),
		'blog'			=> array('label'=>'Blog', 'url'=>'blog'),
	),
	'my-navbar' => array(
		'home'			=> array('label'=>'Latest', 'url'=>'home'),
		'news'			=> array('label'=>'News', 'url'=>'news'),
		'sport'			=> array('label'=>'Sport', 'url'=>'sport'),
		'music'			=> array('label'=>'Music', 'url'=>'music'),
		'cvg'			=> array('label'=>'CVG', 'url'=>'cvg'),
		'livestream'	=> array('label'=>'Livestreams', 'url'=>'livestream'),
		'about'			=> array('label'=>'About', 'url'=>'about'),
	),
);

/**
* Settings for the theme. The theme may have a parent theme.
*
* When a parent theme is used the parent's functions.php will be included before the current
* theme's functions.php. The parent stylesheet can be included in the current stylesheet
* by an @import clause. See site/themes/mytheme for an example of a child/parent theme.
* Template files can reside in the parent or current theme, the CLydia::ThemeEngineRender()
* looks for the template-file in the current theme first, then it looks in the parent theme.
*
* There are two useful theme helpers defined in themes/functions.php.
*  theme_url($url): Prepends the current theme url to $url to make an absolute url. 
*  theme_parent_url($url): Prepends the parent theme url to $url to make an absolute url. 
*
* path: Path to current theme, relativly LYDIA_INSTALL_PATH, for example themes/grid or site/themes/mytheme.
* parent: Path to parent theme, same structure as 'path'. Can be left out or set to null.
* stylesheet: The stylesheet to include, always part of the current theme, use @import to include the parent stylesheet.
* template_file: Set the default template file, defaults to default.tpl.php.
* regions: Array with all regions that the theme supports.
* menu_to_region: Array mapping menus to regions.
* data: Array with data that is made available to the template file as variables. 
* 
* The name of the stylesheet is also appended to the data-array, as 'stylesheet' and made 
* available to the template files.
*/
$ly->config['theme'] = array(
	'name' => 'grid',
	'path' => 'site/themes/blubullbulletin',
	//'path' => 'themes/grid',
	'parent' => 'themes/grid',
	'stylesheet' => 'style.css',
	'template_file' => 'index.tpl.php',
	'regions' => array('navbar', 'flash', 'featured-first', 'featured-middle', 'featured-last', 'primary', 'sidebar', 'triptych-first', 'triptych-middle', 'triptych-last', 'footer-column-one', 'footer-column-two', 'footer-column-three', 'footer-column-four', 'footer',
	),
	'menu_to_region' => array('my-navbar'=>'navbar'),
	'data' => array(
		'footer' => '<p>Blubull Bulletin (built on a Lydia replica) &copy; by Magnus Bellstrand (bellstrand@gmail.com)</p>',
		'logo' => 'logotyp.png',
		'logo_width' => '940',
		'logo_height' => '363',
	),
);