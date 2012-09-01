<?php

class SocialConnectHelper extends AppHelper {

	public $helpers = array('Html', 'Form');

	public function googleConnect() {
		$callbackURL = $this->url(Configure::read('SocialConnect.Google.OpenidCallback'), true);
		return $this->Html->image(
			'SocialConnect.google/mini_btn_google.png',
			array(
				'alt' => 'Connect with google account',
				'url' => $callbackURL
			)
		);
	}

}

?>