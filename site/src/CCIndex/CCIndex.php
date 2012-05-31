<?php
class CCIndex extends CObject implements IController{
	public function __construct(){
		parent::__construct();
	}
	public function Index(){
		$content = new CMContent();
		$this->views->SetTitle('Latest flow');
		$this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
			'contents' => $content->ListAll(array('type'=>'page', 'order-by'=>'created', 'order-order'=>'DESC', 'limit'=>'10')),
			'header' => 'Latest flow',
		), 'primary');
		$this->views->AddInclude(__DIR__ . '/sidebar.tpl.php', array(
			'contents' => $content->ListAll(array('type'=>'post', 'order-by'=>'created', 'order-order'=>'DESC', 'limit'=>'20')),
			'header' => 'Latest notices',
		), 'sidebar');
	}
	public function News(){
		$content = new CMContent();
		$this->views->SetTitle('News flow');
		$this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
			'contents' => $content->ListAll(array('key'=>'knews', 'order-by'=>'created', 'order-order'=>'DESC', 'limit'=>'10')),
			'header' => 'News flow',
		), 'primary');
		$this->views->AddInclude(__DIR__ . '/sidebar.tpl.php', array(
			'contents' => $content->ListAll(array('key'=>'knews-notice', 'order-by'=>'created', 'order-order'=>'DESC', 'limit'=>'20')),
			'header' => 'News notices',
		), 'sidebar');
	}
	public function Sport(){
		$content = new CMContent();
		$this->views->SetTitle('Sports flow');
		$this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
			'contents' => $content->ListAll(array('key'=>'sport', 'order-by'=>'created', 'order-order'=>'DESC', 'limit'=>'10')),
			'header' => 'Sports flow',
		), 'primary');
		$this->views->AddInclude(__DIR__ . '/sidebar.tpl.php', array(
			'contents' => $content->ListAll(array('key'=>'sport-notice', 'order-by'=>'created', 'order-order'=>'DESC', 'limit'=>'20')),
			'header' => 'Sport notices',
		), 'sidebar');
	}
}