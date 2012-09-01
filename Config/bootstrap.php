<?php

define('Auth_OpenID_RAND_SOURCE', null);

Configure::write('SocialConnect.GoogleConnect.OpenidCallback', array('plugin' => 'SocialConnect', 'controller' => 'SocialConnect', 'action' => 'googleConnect'));
?>