<?php
/**
* A page controller to display a page, for example an about-page, displays content labelled as "page".
*
* @package LydiaCore
*/
class CCPage extends CObject implements IController{
	/**
	* Constructor
	*/
	public function __construct(){
		parent::__construct();
	}
	
	/**
	* Display an empty page.
	*/
	public function Index(){
		$content = new CMContent();
		$this->views->SetTitle('Page');
		$this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
			'content' => null,
		));
	}
	
	/**
	* Display a page.
	*
	* @param $id integer the id of the page.
	*/
	public function View($id=null){
		$content = new CMContent();
		$form = new CFormContentComment($this, $id);
		if($form->Check() === false){
			$this->AddMessage('notice', 'You must fill in all values.');
			$this->RedirectToController('view', $id);
		}
		$this->views->SetTitle('News');
		$this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
			'content' => $content->LoadByIdWithComments($id),
			'form' => $form->GetHTML(),
		), 'primary');
	}
	
	public function DoComment($form){
		if(!$this->user->IsAuthenticated()){
			$this->RedirectTo('user', 'login');
			exit;
		}
		$content = new CMContent();
		if($content->Comment($form['data']['value'], $form['id']['value'])){
			$this->AddMessage('success', "Your comment was successfully created.");			
			$this->RedirectTo('page', 'view', $form['id']['value']);
		}
		else{
			$this->AddMessage('notice', 'Failed to create a comment.');
			$this->RedirectTo('page', 'view', $form['id']['value']);
		}
	}
}