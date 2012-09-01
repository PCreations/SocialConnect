<?php

interface Provider {
	
	public function getProvider();

	public function getId();

	public function getEmail();

	public function getNickname();

	public function getFullname();

	public function getBirthdate();

	public function getGender();

	public function getPostcode();

	public function getCountry();

	public function getLanguage();

	public function getTimezone();
	
	public function getPicture();

	public function isAuth();

	public function auth();

	public function isAuthCanceled();

	public function isValidate();
}

?>