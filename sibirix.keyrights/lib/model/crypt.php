<?php

namespace Sibirix\Keyrights\Model;

use CKeyrights;

class Crypt
{
	protected $_iv;
	protected $_key;

	/**
	 * @param bool $iv
	 */
	protected function _init(bool $iv = false): void
	{
		if (false === $iv) {
			$iv_size   = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
			$this->_iv = mcrypt_create_iv($iv_size);
		} else {
			$this->_iv = $iv;
		}

		$this->_key = CKeyrights::getServerPassPhrase();
	}

	/**
	 * @param $string
	 *
	 * @return string
	 */
	public static function crypt($string): string
	{
		$inst = new self();

		return $inst->cryptString($string);
	}

	/**
	 * @param $string
	 *
	 * @return string
	 */
	public static function decrypt($string): string
	{
		$inst = new self();

		return $inst->decryptString($string);
	}

	/**
	 * @param $string
	 *
	 * @return string
	 */
	public function cryptString($string): string
	{
		$this->_init();

		$result = mcrypt_encrypt(MCRYPT_BLOWFISH, $this->_key, $string, MCRYPT_MODE_ECB, $this->_iv);

		return base64_encode($result) . '__' . base64_encode($this->_iv);
	}

	/**
	 * @param $string
	 *
	 * @return string
	 */
	public function decryptString($string): string
	{
		@list($string, $iv) = explode('__', $string);
		if (!isset($string) || !isset($iv)) {
			return '';
		}
		$string = base64_decode($string);
		$iv     = base64_decode($iv);
		$this->_init($iv);

		$crypttext = mcrypt_decrypt(MCRYPT_BLOWFISH, $this->_key, $string, MCRYPT_MODE_ECB, $this->_iv);

		return rtrim($crypttext);
	}
}
