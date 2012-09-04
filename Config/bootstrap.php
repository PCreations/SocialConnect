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

Configure::write('SocialConnect.Facebook.RegisterCallback', array(
	'plugin' => null,
	'controller' => '/',
	'action' => 'register',
));

Configure::write('SocialConnect.Facebook.Credentials', array(
	'appId' => '317368205014155',
	'secret' => '617a666e8842cecacddf7083e923ddb6',
	'cookie' => false
));

Configure::write('SocialConnect.Fields', array(
	'email' => 'email',
	'country' => 'country'
));

Configure::write('SocialConnect.UserModel', 'AppUser');

?>