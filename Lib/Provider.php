<?php

interface Provider {

	public function getProvider();

	public function getId();

	public function getAttribute($name);

	public function isAuth();

	public function auth();

	public function isAuthCanceled();

	public function isValidate();

	public function setRequiredAttributes($attributes);

	public function setOptionalAttributes($attributes);

	public function getAllowedAttributes();

	public function getRequiredAttributes();

	public function getOptionalAttributes();

	public function getRetrievedAttributes();
}

?>