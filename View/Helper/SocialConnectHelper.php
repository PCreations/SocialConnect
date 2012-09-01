<?php

class SocialConnectHelper extends AppHelper {

	public $helpers = array('Html');

	public function googleConnect() {
		$callbackURL = $this->url(Configure::read('SocialConnect.GoogleConnect.OpenidCallback'));
		return $this->Html->image(
			'SocialConnect.google.mini_btn_google.png',
			array(
				'alt' => 'Connect with google account',
				'url' => $callbackURL
			)
		);
	}

}

?>