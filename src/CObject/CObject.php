<?php
/**
* Holding a instance of CLydia to enable use of $this in subclasses.
*
* @package LydiaCore
*/
class CObject{
	/**
	* Members
	*/
	protected $ly;
	protected $config;
	protected $request;
	protected $data;
	protected $views;
	protected $db;
	protected $session;
	protected $user;
	
	/**
	* Constructor
	*/
	protected function __construct($ly=null){
		if(!$ly){
			$ly = CLydia::Instance();
		}
		$this->ly = &$ly;
		$this->config = &$ly->config;
		$this->request = &$ly->request;
		$this->data = &$ly->data;
		$this->views = &$ly->views;
		$this->db = &$ly->db;
		$this->session = &$ly->session;
		$this->user = &$ly->user;
	}
	
	/**
	* Wrapper for same method in CLydia. See there for documentation.
	*/
	protected function RedirectTo($urlOrController=null, $method=null, $arguments=null) {
		$this->ly->RedirectTo($urlOrController, $method, $arguments);
	}
	
	/**
	* Wrapper for same method in CLydia. See there for documentation.
	*/
	protected function RedirectToController($method=null, $arguments=null){
		$this->ly->RedirectToController($method, $arguments);
	}
	
	/**
	* Wrapper for same method in CLydia. See there for documentation.
	*/
	protected function RedirectToControllerMethod($controller=null, $method=null, $arguments){
		$this->ly->RedirectToControllerMethod($controller, $method, $arguments);
	}
	
	/**
	* Wrapper for same method in CLydia. See there for documentation.
	*/
	protected function AddMessage($type, $message, $alternative=null){
		return $this->ly->AddMessage($type, $message, $alternative);
	}
	
	/**
	* Wrapper for same method in CLydia. See there for documentation.
	*/
	protected function CreateUrl($urlOrController=null, $method=null, $arguments=null){
		return $this->ly->CreateUrl($urlOrController, $method, $arguments);
	}
}
