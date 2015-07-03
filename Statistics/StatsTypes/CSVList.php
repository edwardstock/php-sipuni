<?php

namespace EdwardStock\SIP\Statistics\StatsTypes;
use EdwardStock\SIP\Statistics\SIPUniStatistics;


/**
 * club. 2015
 * @author Eduard Maximovich <edward.vstock@gmail.com>
 */
class CSVList extends SIPUniStatistics
{

	private $from;
	private $to;
	private $type;
	private $state;
	private $tree;
	private $fromNumber;
	private $toNumber;
	private $toAnswer;
	private $anonymous;
	private $firstTime;

	/**
	 * Генерирует hash из данных
	 * Возвращать строго в порядке указанном в API
	 * @see https://sipuni.com/settings/integration/callback_api
	 *
	 * @return string[]
	 */
	protected function hashData() {
		return [
			$this->anonymous,
			$this->firstTime,
			$this->from,
			$this->fromNumber,
			$this->state,
			$this->to,
			$this->toAnswer,
			$this->toNumber,
			$this->tree,
			$this->type,
			$this->user,
			$this->secretKey,

		];
	}

	/**
	 * @return string Урл для запроса
	 */
	protected function getRequestURI() {
		// TODO: Implement getRequestURI() method.
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
		// TODO: Implement requestHttpMethod() method.
	}

	/**
	 * Данные для отправки
	 * @return string[]
	 */
	protected function requestData() {
		// TODO: Implement requestData() method.
	}
}