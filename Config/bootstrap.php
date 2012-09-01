<?php

define('Auth_OpenID_RAND_SOURCE', null);

Configure::write('SocialConnect.Google.OpenidCallback', array(
	'plugin' => 'social_connect',
	'controller' => 'social_connect',
	'action' => 'google_connect',
));
Configure::write('SocialConnect.Google.RegisterCallback', array(
	'plugin' => null,
	'controller' => '/',
	'action' => 'register',
));
?>