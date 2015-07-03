<?php
/**
 * club. 2015
 * @author Eduard Maximovich <edward.vstock@gmail.com>
 */

namespace EdwardStock\SIP\Callback;

use EdwardStock\SIP\Base\SIPUni;

abstract class SIPUniCallback extends SIPUni
{
	const CALLBACK_URI    = 'callback';

	/**
	 * @var number
	 */
	protected $sipNumber = 101;

	/**
	 * @param number $number
	 */
	public function setSipNumber($number) {
		$this->sipNumber = $number;
	}

	public function call() {
		$this->makeRequest($this->getData());
		return $this->curl->response;
	}

	/**
	 * @return string
	 */
	public function getRequestURI() {
		return self::API_URI . '/' . self::CALLBACK_URI . '/' . $this->callbackMethod();
	}

	/**
	 * Должен вернуть метод sipuni к которому относится тип звонка
	 * @see https://sipuni.com/settings/integration/callback_api
	 * @return string
	 */
	abstract protected function callbackMethod();

}
