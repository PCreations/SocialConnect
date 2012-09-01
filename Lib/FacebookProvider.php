<?php

App::uses('Provider', 'SocialConnect.Lib');
App::uses('LightOpenID', 'SocialConnect.Lib');
App::uses('Facebook', 'SocialConnect.Lib');

class FacebookProvider extends Facebook implements Provider {

	//protected $id;
	
	protected $userInfos = null;

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
		return 'facebook';
	}

	public function getId() {
		return $this->getUser();
	}

	public function getEmail() {
		return $this->getAttribute('email');
	}

	public function getNickname() {
		return $this->getAttribute('name');
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
		return ($this->getId() !== null) ? 'https://graph.facebook.com/'.$this->getId().'/picture' : null;
	}

	public function isAuth() {
		return $this->getUser() !== 0;
	}

	public function auth() {
		$params = array(
			'scope' => 'email'
		);
		header('Location: ' . $this->getLoginUrl($params));
		exit();
	}

	public function isAuthCanceled() {
		return $this->mode == 'cancel';
	}

	public function isValidate() {
		return $this->validate();
	}

	public function logout() {
		header('Location: ' . $this->getLogoutUrl($params));
		exit();
	}

	private function getAttribute($name) {
		if($this->userInfos == null) {
			try {
				$this->userInfos = $this->api('/me');
			}catch(FacebookApiException $e) {
				debug($e);
			}
		}
		return isset($this->userInfos[$name]) ? $this->userInfos[$name] : '';
	}
}

?>