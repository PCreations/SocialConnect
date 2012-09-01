<?php

App::uses('GoogleProvider', 'SocialConnect.Lib');

class SocialConnectComponent extends Component {
	
	private $provider;

	public $controller;

	public function initialize(Controller $controller) {
		$this->controller = $controller;
	}

	public function setProvider($provider) {
		switch($provider) {
			case 'google':
				$this->provider = new GoogleProvider(FULL_BASE_URL);
				break;
		}
	}

	public function isAuth() {
		return $this->provider->isAuth();
	}

	public function isAuthCanceled() {
		return $this->provider->isAuthCanceled();
	}

	public function auth() {
		$this->provider->auth();
	}

	public function isValidate() {
		return $this->provider->isValidate();
	}

	public function getProvider() {
		return $this->provider->getProvider();
	}

	public function getUserId() {
		return $this->provider->getId();
	}

	public function getUserEmail() {
		return $this->provider->getEmail();
	}

	public function registerCallbackUrl() {
		//Ajouter chaque paramètre spécifié
		$params = array(
			'?' => array(
				'provider' => $this->getProvider(),
				'email' => $this->getUserEmail()
			)
		);
		return Hash::merge(Configure::read('SocialConnect.Google.RegisterCallback'), $params);
	}

	public function prefillRegisterForm() {
		//Ajouter chaque paramètre spécifié
		debug($this->controller->request->query);
		if(isset($this->controller->request->query['provider'])) {
			$params = array('email');
			$fields = Configure::read('SocialConnect.Fields');
			$userModel = Configure::read('SocialConnect.UserModel');
			foreach($params as $param) {
				$this->controller->request->data[$userModel][$fields[$param]] = $this->controller->request->query[$param];
			}
		}
	}

}

?>