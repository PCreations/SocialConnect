<?php

App::uses('SocialConnectAppController', 'SocialConnect.Controller');
App::uses('Router', 'Cake/Routing');

class SocialConnectController extends SocialConnectAppController {

	const GOOGLE_CONNECT_URL = 'https://www.google.com/accounts/o8/id';

	public $components = array(
		'SocialConnect.SocialConnect'
	);

	public function google_connect() {
		$this->SocialConnect->setProvider('google');

		debug($this->SocialConnect->isAuth());
		if(!$this->SocialConnect->isAuth()) {
			if(isset($_GET['login'])) {
				//set required params to retrieve
				$this->SocialConnect->auth();
			}
		}
		elseif($this->SocialConnect->isValidate()) {
			$this->redirect($this->SocialConnect->registerCallbackUrl());
		}
		else {
			echo 'User has not logged in.';
		}
	}
	
}

?>