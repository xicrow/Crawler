<?php
namespace Xicrow\Crawler\Analyzer\Html;

/**
 * Class Anchor
 * @package Xicrow\Crawler\Analyzer\Html
 */
class Anchor extends AbstractElement {
	/**
	 * @var string
	 */
	protected $__tagName = 'a';
	
	/**
	 * @var string
	 */
	private $href = '';

	/**
	 * @param $source
	 */
	public function __construct($source) {
		parent::__construct($source);
		
		$this->href = $this->__domElement->getAttribute('href');
	}

	/**
	 * @param $question
	 * @param string $arg1
	 * @return bool
	 * @see isMailto
	 * @see isJavascript
	 * @see isAbsolute
	 * @see isRelative
	 * @see isHttps
	 * @see isHttp
	 * @see isInternal
	 * @see isExternal
	 */
	public function is($question, $arg1 = ''){
		$methodName = 'is' . ucfirst(strtolower($question));
		if (method_exists($this, $methodName)) {
			return $this->$methodName($arg1);
		}
		
		return false;
	}

	/**
	 * @return bool
	 */
	private function isMailto() {
		return (strpos($this->href, 'mailto:') !== false);
	}

	/**
	 * @return bool
	 */
	private function isJavascript() {
		return (strpos($this->href, 'javascript:') !== false);
	}

	/**
	 * @return bool
	 */
	private function isAbsolute() {
		return (strpos($this->href, '://') !== false);
	}

	/**
	 * @return bool
	 */
	private function isRelative() {
		return !$this->is('absolute');
	}

	/**
	 * @return bool
	 */
	private function isHttps() {
		return (strpos($this->href, 'https://') !== false);
	}

	/**
	 * @return bool
	 */
	private function isHttp() {
		return !$this->is('https');
	}

	/**
	 * @return bool
	 */
	private function isInternal($url) {
		return (strpos($this->href, $url) !== false);
	}

	/**
	 * @return bool
	 */
	private function isExternal($url) {
		return !$this->is('internal', $url);
	}
}
