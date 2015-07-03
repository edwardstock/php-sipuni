<?php
namespace EdwardStock\SIP\Callback\CallTypes;

use EdwardStock\SIP\Callback\SIPUniCallback;

/**
 * club. 2015
 * @author Eduard Maximovich <edward.vstock@gmail.com>
 */
final class CallThroughSchema extends SIPUniCallback
{

	private $tree;
	private $phoneTo;

	public function __construct($schemeId, $phoneTo, $sipNumber = 101) {
		$this->tree = $schemeId;
		$this->phoneTo = $phoneTo;
		$this->sipNumber = $sipNumber;
		parent::__construct();
	}

	/**
	 * Генерирует hash
	 * @return string[]
	 */
	protected function hashData() {
		return [
			$this->phoneTo,
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
			'phone'=>$this->phoneTo,
			'sipnumber'=>$this->sipNumber,
			'tree'=>$this->tree,
			'user'=>$this->user,
		];
	}


	/**
	 * Должен вернуть метод sipuni к которому относится тип звонка
	 * @return string
	 */
	protected function callbackMethod() {
		return 'call_tree';
	}

	/**
	 * @inheritdoc
	 */
	protected function requestHttpMethod() {
		return self::METHOD_POST;
	}
}