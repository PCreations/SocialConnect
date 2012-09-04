<?php

App::uses('SocialConnectAppController', 'SocialConnect.Controller');
App::uses('Router', 'Cake/Routing');

class SocialConnectController extends SocialConnectAppController {

	const GOOGLE_CONNECT_URL = 'https://www.google.com/accounts/o8/id';

	public $components = array(
		'SocialConnect.SocialConnect',
		'Session'
	);

	public function google_connect() {
		$this->SocialConnect->setProvider('google');

		debug($this->SocialConnect->isAuth());
		if(!$this->SocialConnect->isAuth()) {
			if(isset($_GET['login'])) {
				//set required params to retrieve
				$this->SocialConnect->setRequiredAttributes(array(
					'email',
					'country',
					'gender',
				));
				$this->SocialConnect->setOptionalAttributes(array(
					'firstname',
					'lastname'
				));
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

	public function facebook_connect() {
		$this->SocialConnect->setProvider('facebook');
		debug($this->SocialConnect->isAuth());
		if(!$this->SocialConnect->isAuth()) {
			if(isset($_GET['login'])) {
				$this->SocialConnect->setRequiredAttributes(array(
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
					'email',
					'user_about_me',
				));
				$this->SocialConnect->auth();
			}
		}
		elseif($this->SocialConnect->isValidate()) {
			$this->redirect($this->SocialConnect->registerCallbackUrl());
		}
		else {
			echo 'User has not logged in.';
		}
		//$this->SocialConnect->logout();
	}
	
}

?>