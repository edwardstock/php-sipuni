<?php

namespace EdwardStock\SIP\Base;
use EdwardStock\Curl\Curl;


/**
 * club. 2015
 * @author Eduard Maximovich <edward.vstock@gmail.com>
 */
abstract class SIPUni
{

	const API_URI = 'http://sipuni.com/api';

	const HASH_GLUE_TOKEN = '+';

	const METHOD_GET   = 0;
	const METHOD_POST  = 1;
	const METHOD_PUT   = 2;
	const METHOD_PATCH = 3;

	/**
	 * @var Curl
	 */
	protected $curl;


	/**
	 * @var string
	 */
	protected $secretKey = '.yj64acz4sf6flxr';

	/**
	 * @var string
	 */
	protected $user = '020772'; //аккуратно с числом, оно восмеричное получится если убрать кавычки

	/**
	 * @var \stdClass
	 */
	protected $response;

	public function __construct() {
		$this->curl = new Curl();
		$this->curl->onComplete([$this, 'onComplete']);
		$this->curl->onSuccess([$this, 'onSuccess']);
		$this->curl->onError([$this, 'onError']);
		$this->curl->onBeforeSend([$this, 'onBeforeSend']);
	}

	/**
	 * Генерирует hash из данных
	 * Возвращать строго в порядке указанном в API
	 * @see https://sipuni.com/settings/integration/callback_api
	 *
	 * @return string[]
	 */
	abstract protected function hashData();

	/**
	 * @return string Урл для запроса
	 */
	abstract protected function getRequestURI();

	/**
	 * HTTP-Метод с помощью которого будет отправлен запрос к API.
	 * SipUNI рекомендует использовать POST
	 * @return int
	 * @see SIPUni::METHOD_GET
	 * @see SIPUni::METHOD_POST
	 * @see SIPUni::METHOD_PUT
	 * @see SIPUni::METHOD_PATCH
	 */
	abstract protected function requestHttpMethod();

	/**
	 * Данные для отправки
	 * @return string[]
	 */
	abstract protected function requestData();

	/**
	 * @param string $secret
	 */
	public function setSecretKey($secret) {
		$this->secretKey = $secret;
	}

	/**
	 * @param number $user
	 */
	public function setUser($user) {
		$this->user = "{$user}";
	}

	/**
	 * Хэш-строка для отправки в API
	 * @return string
	 */
	public function getHash() {
		return md5(implode(self::HASH_GLUE_TOKEN, array_values($this->hashData())));
	}

	public function getData() {
		$values = $this->requestData();

		if (!isset($values['hash'])) {
			$values['hash'] = $this->getHash();
		}

		return $values;
	}

	/**
	 * @param array $data
	 * @return int|mixed|null
	 * @throws \ErrorException
	 */
	protected function makeRequest(array $data = []) {
		$requestUrl = $this->getRequestURI();
		$result = null;

		switch ($this->requestHttpMethod()) {
			case self::METHOD_POST:
				$result = $this->curl->post($requestUrl, $data);
				break;

			case self::METHOD_GET:
				$result = $this->curl->get($requestUrl, $data);
				break;

			case self::METHOD_PUT:
				$result = $this->curl->put($requestUrl, $data);
				break;

			case self::METHOD_PATCH:
				$result = $this->curl->patch($requestUrl, $data);
				break;

			default:
				$this->curl->get($requestUrl, $data);
		}

		return $result;
	}


	/**
	 * @return bool Успешность запроса к SIPUNI
	 */
	public function isSuccess() {
		return $this->response instanceof \stdClass && isset($this->response->success) && $this->response->success === true;
	}

	/**
	 * @return mixed Ответ SIPUNI
	 */
	public function getResponseMessage() {
		return $this->response instanceof \stdClass && isset($this->response->message) ? $this->response->message : null;
	}

	protected function onComplete(Curl $curl, array $data, $context = null) {
	}

	protected function onSuccess(Curl $curl, array $data, $context = null) {
	}

	protected function onError(Curl $curl, array $data, $context = null) {
	}

	protected function onBeforeSend(Curl $curl) {
	}


}