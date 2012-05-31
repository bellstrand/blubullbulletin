<?php
/**
* A user controller to manage content.
*
* @package LydiaCore
*/
class CCContent extends CObject implements IController{
	/**
	* Construct
	*/
	public function __construct(){
		parent::__construct();
	}
	
	/**
	* Show a listing of all content.
	*/
	public function Index(){
		if(!$this->user->IsAuthenticated()){
			$this->RedirectTo('user', 'login');
			exit;
		}
		$content = new CMContent();
		$this->views->SetTitle('Content Controller');
		$this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
			'contents' => $content->ListAll(),
		));
	}
	
	/**
	* Edit a selected content, or prepare to create new content if argument is missing.
	*
	* @param id integer the id of the content.
	*/
	public function Edit($id=null){
		if(!$this->user->IsAuthenticated()){
			$this->RedirectTo('user', 'login');
			exit;
		}
		$content = new CMContent($id);
		$form = new CFormContent($content);
		$status = $form->Check();
		if($status === false){
			$this->AddMessage('notice', 'The form could not be processed.');
			$this->RedirectToController('edit', $id);
		}
		else if($status === true){
			$this->RedirectToController('edit', $content['id']);
		}
		
		$title = isset($id) ? 'Edit' : 'Create';
		$this->views->SetTitle("$title content: ".htmlEnt($content['title']));
		$this->views->AddInclude(__DIR__ . '/edit.tpl.php', array(
			'user' => $this->user,
			'content' => $content,
			'form' => $form,
		));
	}
	
	/**
	* Create new content.
	*/
	public function Create(){
		$this->Edit();
	}
}