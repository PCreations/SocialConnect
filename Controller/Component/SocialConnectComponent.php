<?php

App::uses('GoogleProvider', 'SocialConnect.Lib');
App::uses('FacebookProvider', 'SocialConnect.Lib');

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
			case 'facebook':
				$this->provider = new FacebookProvider(Configure::read('SocialConnect.Facebook.Credentials'));
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

	public function setRequiredAttributes($attributes) {
		$this->provider->setRequiredAttributes($attributes);
	}

	public function setOptionalAttributes($attributes) {
		$this->provider->setOptionalAttributes($attributes);
	}

	public function logout() {
		$this->provider->logout();
	}

	public function getUserInfo($name) {
		return $this->provider->getAttribute($name);
	}

	public function registerCallbackUrl() {
		$provider = $this->getProvider();
		$attributes = $this->provider->getRetrievedAttributes();
		$params = array(
			'?' => array_merge(
				array(
					'provider' => $provider,
				),
				$attributes
			)
		);
		return Hash::merge(Configure::read('SocialConnect.'.ucfirst($provider).'.RegisterCallback'), $params);
	}

	public function prefillRegisterForm() {
		debug($this->controller->request->query);
		if(isset($this->controller->request->query['provider'])) {
			unset($this->controller->request->query['provider']);
			$fields = Configure::read('SocialConnect.Fields');
			$userModel = Configure::read('SocialConnect.UserModel');
			foreach($this->controller->request->query as $name => $value) {
				//if(!in_array($name, $this->getAllowedAttributes) continue;
				$fieldName = isset($fields[$name]) ? $fields[$name] : $name;
				$this->controller->request->data[$userModel][$fieldName] = $value;
			}
		}
	}

	private function getAllAttributesFromProvider() {
		return array_merge($this->provider->getRequiredAttributes(), $this->provider->getOptionalAttributes());
	}

}

?>