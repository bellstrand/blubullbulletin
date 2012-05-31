<?php
class CCLivestream extends CObject implements IController{
	public function __construct(){
		parent::__construct();
	}
	public function Index(){
		if(!$this->user->IsAuthenticated()){
			$this->RedirectTo('user', 'login');
			exit;
		}
		$rss = new CRSSReader();
		$livestreams = new CMLivestream();
		$this->views->SetTitle('Livestreams');
		$this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
			'rss' => $rss->RSS_Display("http://feeds.feedburner.com/dotatalk/wrxN", 5),
		), 'primary');
		$this->views->AddInclude(__DIR__ . '/sidebar.tpl.php', array(
			'content' => $livestreams->getStreamSorted(),
		), 'sidebar');
	}
}