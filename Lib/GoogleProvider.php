<?php

App::uses('Provider', 'SocialConnect.Lib');
App::uses('LightOpenID', 'SocialConnect.Lib');

class GoogleProvider extends LightOpenID implements Provider {

	const GOOGLE_CONNECT_URL = 'https://www.google.com/accounts/o8/id';

	static protected $ax_to_sreg = array(
        'contact/email'           => 'email',
        'namePerson/first'        => 'firstname',
        'namePerson/last'         => 'lastname',
        'birthDate'               => 'dob',
        'person/gender'           => 'gender',
        'contact/postalCode/home' => 'postcode',
        'contact/country/home'    => 'country',
        'pref/language'           => 'language',
        'pref/timezone'           => 'timezone',
        );

	function __construct($host) {
        parent::__construct($host);
        $this->identity = self::GOOGLE_CONNECT_URL;
    }
	//protected $id;

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
		return 'google';
	}

	public function getId() {
		return $this->identity;
	}

	public function isAuth() {
		return $this->mode !== null;
	}

	public function auth() {
		header('Location: ' . $this->authUrl());
		exit();
	}

	public function isAuthCanceled() {
		return $this->mode == 'cancel';
	}

	public function isValidate() {
		return $this->validate();
	}

	public function setRequiredAttributes($attributes) {
		$sregToAx = array_flip(self::$ax_to_sreg);
		foreach($attributes as $attribute) {
			$this->required[] = $sregToAx[$attribute];
		}
	}

	public function setOptionalAttributes($attributes) {
		$sregToAx = array_flip(self::$ax_to_sreg);
		foreach($attributes as $attribute) {
			$this->optional[] = $sregToAx[$attribute];
		}
	}

	public function getAllowedAttributes() {
		return array_flip($this->$ax_to_sreg);
	}

	public function getRequiredAttributes() {
		$required = array();
		foreach($this->required as $attribute) {
			$required[] = self::$ax_to_sreg[$attribute];
		}
		return $required;
	}

	public function getOptionalAttributes() {
		$optional = array();
		foreach($this->optional as $attribute) {
			$optional[] = self::$ax_to_sreg[$attribute];
		}
		return $optional;
		return $this->optional;
	}

	protected function axParams()
    {
        $params = array();
        if ($this->required || $this->optional) {
            $params['openid.ns.ax'] = 'http://openid.net/srv/ax/1.0';
            $params['openid.ax.mode'] = 'fetch_request';
            $this->aliases  = array();
            $counts   = array();
            $required = array();
            $optional = array();
            foreach (array('required','optional') as $type) {
                foreach ($this->$type as $alias => $field) {
                    if (is_int($alias)) $alias = self::$ax_to_sreg[$field];
                    $this->aliases[$alias] = 'http://axschema.org/' . $field;
                    if (empty($counts[$alias])) $counts[$alias] = 0;
                    $counts[$alias] += 1;
                    ${$type}[] = $alias;
                }
            }
            foreach ($this->aliases as $alias => $ns) {
                $params['openid.ax.type.' . $alias] = $ns;
            }
            foreach ($counts as $alias => $count) {
                if ($count == 1) continue;
                $params['openid.ax.count.' . $alias] = $count;
            }

            # Don't send empty ax.requied and ax.if_available.
            # Google and possibly other providers refuse to support ax when one of these is empty.
            if($required) {
                $params['openid.ax.required'] = implode(',', $required);
            }
            if($optional) {
                $params['openid.ax.if_available'] = implode(',', $optional);
            }
        }
        return $params;
    }

	public function getAttribute($name) {
		$sregToAx = array_flip(self::$ax_to_sreg);
		$attributes = $this->getAttributes();
		return isset($attributes[$sregToAx[$name]]) ? $attributes[$sregToAx[$name]] : '';
	}

	public function getRetrievedAttributes() {
		$attributes = array();
		foreach($this->getAttributes() as $name => $value) {
			$attributes[self::$ax_to_sreg[$name]] = $value;
		}
		return $attributes;
	}
}

?>