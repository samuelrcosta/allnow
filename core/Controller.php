<?php
class Controller {

	protected $db;
	protected $MailName;
	protected $MailUsername;

	public function __construct() {
		global $config;
		global $MailName;
		global $MailUsername;
		$this->MailName = $MailName;
		$this->MailUsername = $MailUsername;
	}
	
	public function loadView($viewName, $viewData = array()) {
		extract($viewData);
		include 'views/'.$viewName.'.php';
	}

	public function loadTemplateCMS($viewName, $viewData = array()){
	    include 'views/cms/template.php';
    }

	public function loadTemplate($viewName, $viewData = array()) {
		include 'views/template.php';
	}

	public function loadViewInTemplate($viewName, $viewData) {
		extract($viewData);
		include 'views/'.$viewName.'.php';
	}

}