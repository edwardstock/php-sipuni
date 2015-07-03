<?php
namespace EdwardStock\SIP\Callback\CallTypes;

use EdwardStock\SIP\Callback\SIPUniCallback;

/**
 * club. 2015
 * @author Eduard Maximovich <edward.vstock@gmail.com>
 */
final class CallFromInternal extends SIPUniCallback
{

	const REVERSE_FROM_INTERNAL = 0;
	const REVERSE_FROM_EXTERNAL = 1;

	/**
	 * @var string
	 */
	private $reverse = 0;
	private $antiAON = 0;
	private $phone;

	public function __construct($phoneTo, $sipNumber = 101) {
		$this->phone = $phoneTo;
		$this->sipNumber = $sipNumber;
		parent::__construct();
	}

	/**
	 * false - не скрывать городской номер
	 * true - скрывать городской номер
	 * @param bool $use
	 */
	public function useAntiAON($use = false) {
		if($use) {
			$this->antiAON = 1;
		} else {
			$this->antiAON = 0;
		}
	}

	/**
	 * @see https://sipuni.com/settings/integration/callback_api
	 * @see CallFromInternal::REVERSE_FROM_INTERNAL - звонок идет сначала на внутренний номер
	 * @see CallFromInternal::REVERSE_FROM_INTERNAL - звонок идет сначала на номер, указанный в параметре (@see CallFromInternal::$phoneTo)
	 * @param $reverseType
	 */
	public function setReverse($reverseType) {
		$this->reverse = $reverseType;
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
			$this->antiAON,
			$this->phone,
			$this->reverse,
			$this->sipNumber,
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
			'antiaon'   => $this->antiAON,
			'phone'     => $this->phone,
			'reverse'   => $this->reverse,
			'sipnumber' => $this->sipNumber,
			'user'      => $this->user,
		];
	}

	/**
	 * Должен вернуть метод sipuni к которому относится тип звонка
	 * @return string
	 */
	protected function callbackMethod() {
		return 'call_number';
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