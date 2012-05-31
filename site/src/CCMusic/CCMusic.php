<?php
class CCMusic extends CObject implements IController{
	public function __construct(){
		parent::__construct();
	}
	public function Index(){
		if(!$this->user->IsAuthenticated()){
			$this->RedirectTo('user', 'login');
			exit;
		}
		$rss = new CRSSReader();
		$this->views->SetTitle('Metal News');
		$this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
			'rss' => $rss->RSS_Display("http://www.metalstorm.net/rss/reviews.xml", 4),
		), 'primary');
		$this->views->AddInclude(__DIR__ . '/sidebar.tpl.php', array(
			'rss' => $rss->RSS_Links("http://www.metalstorm.net/rss/news.xml"),
		), 'sidebar');
		$this->views->AddInclude(__DIR__ . '/triptych-first.tpl.php', array(
			'rss' => $rss->RSS_Links("http://www.metalstorm.net/rss/picks.xml", 5),
		), 'triptych-first');
		$this->views->AddInclude(__DIR__ . '/triptych-middle.tpl.php', array(
			'rss' => $rss->RSS_Links("http://www.metalstorm.net/rss/articles.xml", 5),
		), 'triptych-middle');
		$this->views->AddInclude(__DIR__ . '/triptych-last.tpl.php', array(
			'rss' => $rss->RSS_Links("http://www.metalstorm.net/rss/reviews.xml", 5),
		), 'triptych-last');
	}
}