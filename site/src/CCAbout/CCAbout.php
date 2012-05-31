<?php
class CCAbout extends CObject implements IController{
	public function __construct(){
		parent::__construct();
	}
	public function Index(){
		$this->views->SetTitle('About');
		$this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
		), 'primary');
		$this->views->AddInclude(__DIR__ . '/sidebar.tpl.php', array(
		), 'sidebar');
	}
}