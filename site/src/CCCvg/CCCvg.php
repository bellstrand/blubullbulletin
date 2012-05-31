<?php
class CCCvg extends CObject implements IController{
	public function __construct(){
		parent::__construct();
	}
	public function Index(){
		if(!$this->user->IsAuthenticated()){
			$this->RedirectTo('user', 'login');
			exit;
		}
		$rss = new CRSSReader();
		$this->views->SetTitle('Computer and Video Games News');
		$this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
			'rss' => $rss->RSS_Display("http://www.computerandvideogames.com/rss/feed.php?limit=5", 4),
		), 'primary');
		$this->views->AddInclude(__DIR__ . '/sidebar.tpl.php', array(
			'rss' => $rss->RSS_Links("http://www.teamliquid.net/rss/news.xml"),
		), 'sidebar');
		$this->views->AddInclude(__DIR__ . '/triptych-first.tpl.php', array(
			'rss' => $rss->RSS_Links("http://feeds.ign.com/ignfeeds/all/", 5),
		), 'triptych-first');
		$this->views->AddInclude(__DIR__ . '/triptych-middle.tpl.php', array(
			'rss' => $rss->RSS_Links("http://blog.dota2.com/feed/", 5),
		), 'triptych-middle');
		$this->views->AddInclude(__DIR__ . '/triptych-last.tpl.php', array(
			'rss' => $rss->RSS_Links("http://n4g.com/rss/news?channel=&sort=latest", 5),
		), 'triptych-last');
	}
}