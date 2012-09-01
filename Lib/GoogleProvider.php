<?php

App::uses('Provider', 'SocialConnect.Lib');
App::uses('LightOpenID', 'SocialConnect.Lib');

class GoogleProvider extends LightOpenID implements Provider {

	const GOOGLE_CONNECT_URL = 'https://www.google.com/accounts/o8/id';

	function __construct($host) {
        parent::__construct($host);
        $this->identity = self::GOOGLE_CONNECT_URL;
    }
	//protected $id;

	/*protected function request($url, $method='GET', $params=array(), $update_claimed_id=false) {
		parent::request($url, $method, $params, $update_claimed_id);
		switch($method) {
			case 'GET':
				$this->setId($_GET['id']);
				break;
			case 'POST':
			default:
				$this->setId($_POST['id']);
		}
	}*/

	/*public function setId($id) {
		$this->id = $id;
	}*/

	public function getProvider() {
		return 'google';
	}

	public function getId() {
		return $this->identity;
	}

	public function getEmail() {
		return $this->getAttribute('email');
	}

	public function getNickname() {
		return $this->getAttribute('nickname');
	}

	public function getFullname() {
		return $this->getAttribute('fullname');
	}

	public function getBirthdate() {
		return $this->getAttribute('dob');
	}

	public function getGender() {
		return $this->getAttribute('gender');
	}

	public function getPostcode() {
		return $this->getAttribute('postcode');
	} 

	public function getCountry() {
		return $this->getAttribute('country');
	}

	public function getLanguage() {
		return $this->getAttribute('language');
	}

	public function getTimezone() {
		return $this->getAttribute('timezone');
	}
	
	public function getPicture() {

	}

	public function isAuth() {
		return $this->mode !== null;
	}

	public function auth() {
		$this->required = array('contact/email');
		$this->optional = array('namePerson', 'namePerson/friendly');
		header('Location: ' . $this->authUrl());
		exit();
	}

	public function isAuthCanceled() {
		return $this->mode == 'cancel';
	}

	public function isValidate() {
		return $this->validate();
	}

	private function getAttribute($name) {
		$sregToAx = array_flip(self::$ax_to_sreg);
		$attributes = $this->getAttributes();
		return isset($attributes[$sregToAx[$name]]) ? $attributes[$sregToAx[$name]] : '';
	}
}

?>