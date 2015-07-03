<?php
/**
 * club. 2015
 * @author Eduard Maximovich <edward.vstock@gmail.com>
 */

namespace EdwardStock\SIP\Callback\CallTypes;

use EdwardStock\SIP\Callback\SIPUniCallback;

final class CallFromExternal extends SIPUniCallback
{

	private $sipNumber2;
	private $phoneFrom;
	private $phoneTo;

	public function __construct($phoneFrom, $phoneTo, $sipNumber = 101, $sipNumber2 = 102) {
		$this->sipNumber = $sipNumber;
		$this->sipNumber2 = $sipNumber2;
		$this->phoneFrom = $phoneFrom;
		$this->phoneTo = $phoneTo;
		parent::__construct();
	}

	/**
	 * @param int $sipNumber
	 */
	public function setSipNumber($sipNumber) {
		$this->sipNumber = $sipNumber;
	}

	/**
	 * @param int $sipNumber2
	 */
	public function setSipNumber2($sipNumber2) {
		$this->sipNumber2 = $sipNumber2;
	}

	/**
	 * @param mixed $phoneFrom
	 */
	public function setPhoneFrom($phoneFrom) {
		$this->phoneFrom = $phoneFrom;
	}

	/**
	 * @param mixed $phoneTo
	 */
	public function setPhoneTo($phoneTo) {
		$this->phoneTo = $phoneTo;
	}

	/**
	 * Генерирует hash из данных
	 * Возвращать строго в порядке указанном в API
	 * @see https://sipuni.com/settings/integration/callback_api
	 *
	 * @return string[]
	 */
	protected function hashData() {
		return [
			$this->phoneFrom,
			$this->phoneTo,
			$this->sipNumber,
			$this->sipNumber2,
			$this->user,
			$this->secretKey,
		];
	}

	/**
	 * Данные для отправки
	 * @return string[]
	 */
	protected function requestData() {
		return [
			'phoneFrom'  => $this->phoneFrom,
			'phoneTo'    => $this->phoneTo,
			'sipnumber'  => $this->sipNumber,
			'sipnumber2' => $this->sipNumber2,
			'user'       => $this->user,
		];
	}

	/**
	 * Должен вернуть метод sipuni к которому относится тип звонка
	 * @return string
	 */
	protected function callbackMethod() {
		return 'call_external';
	}

	/**
	 * HTTP-Метод с помощью которого будет отправлен запрос к API.
	 * SipUNI рекомендует использовать POST
	 * @return int
	 * @see SIPUni::METHOD_GET
	 * @see SIPUni::METHOD_POST
	 * @see SIPUni::METHOD_PUT
	 * @see SIPUni::METHOD_PATCH
	 */
	protected function requestHttpMethod() {
		return self::METHOD_POST;
	}
}