<?php

App::uses('Provider', 'SocialConnect.Lib');
App::uses('LightOpenID', 'SocialConnect.Lib');
App::uses('Facebook', 'SocialConnect.Lib');

class FacebookProvider extends Facebook implements Provider {

	//protected $id;
	
	protected $userInfos = null;

	protected $required = array();

	protected $permissions = array(
		'user_about_me'
		'user_activities',
		'user_birthday',
		'user_checkins',
		'user_education_history',
		'user_events',
		'user_groups',
		'user_hometown',
		'user_interests',
		'user_likes',
		'user_location',
		'user_notes',
		'user_photos',
		'user_questions',
		'user_relationships',
		'user_relationship_details',
		'user_religion_politics',
		'user_status',
		'user_subscriptions',
		'user_videos',
		'user_website',
		'user_work_history',
		'email'
	);

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
	
	public function getPicture() {
		return ($this->getId() !== null) ? 'https://graph.facebook.com/'.$this->getId().'/picture' : null;
	}

	public function isAuth() {
		return $this->getUser() !== 0;
	}

	public function auth() {
		header('Location: ' . $this->getLoginUrl($this->getScope()));
		exit();
	}

	public function isAuthCanceled() {
		return $this->mode == 'cancel';
	}

	public function isValidate() {
		try {
			$this->userInfos = $this->api('/me', 'GET');
			return true;
		}
		catch(FacebookApiException $e) {
			return false;
		}
	}

	public function logout() {
		header('Location: ' . $this->getLogoutUrl($params));
		exit();
	}

	public function getAttribute($name) {
		if($name == 'picture') {
			return $this->getPicture();
		}
		if($this->userInfos == null) {
			try {
				$this->userInfos = $this->api('/me');
			}catch(FacebookApiException $e) {
				debug($e);
			}
		}
		debug($this->userInfos);
		return isset($this->userInfos[$name]) ? $this->userInfos[$name] : '';
	}

	public function getScope() {
		foreach($this->required as $key => $attribute) {
			if(in_array($attribute, $this->permissions)) continue;
			unset($this->required[$key]);
		}
		return array('scope' => $this->required);
	}

	public function setRequiredAttributes($attributes) {
		$this->required = $attributes;
	}

	public function setOptionalAttributes($attributes) {
		$this->required = array_merge($this->required, $attributes);
	}

	public function getAllowedAttributes() {

	}

	public function getRequiredAttributes() {
		return $this->required;
	}

	public function getOptionalAttributes() {
		return $this->required;
	}

	public function getRetrievedAttributes() {
		return $this->getUserInfos();
	}

	public function getUserInfos() {
		if($this->userInfos == null) {
			$this->userInfos = $this->api('/me', 'GET');
		}
		return $this->userInfos;
	}
}

?>