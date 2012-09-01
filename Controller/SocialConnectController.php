<?php

App::uses('SocialConnectAppController', 'SocialConnect.Controller');

class SocialConnectController extends SocialConnectAppController {

	const GOOGLE_CONNECT_URL = 'https://www.google.com/accounts/o8/id';

	public $components = array(
		'SocialConnect.Openid' => array(
			'accept_google_apps' => true
		)
	);

	public function googleConnect() {
		$realm = 'http://' . $_SERVER['HTTP_HOST'];
        $returnTo = $realm . '/users/login';
		try {
            $this->Openid->authenticate(self::GOOGLE_CONNECT_URL, $returnTo, $realm);
        } catch (InvalidArgumentException $e) {
            $this->set('error', 'Invalid OpenID');
        } catch (Exception $e) {
            $this->set('error', $e->getMessage());
        }
	}
	
}

?>