<?php
namespace Xicrow\Crawler\Analyzer\Html;

/**
 * Class Anchor
 * @package Xicrow\Crawler\Analyzer\Html
 */
class Anchor {
	/**
	 * @var \DOMElement
	 */
	private $__domElement;

	/**
	 * @var string
	 */
	private $__source = '';
	
	/**
	 * @var string
	 */
	private $href = '';

	/**
	 * @param $source
	 */
	public function __construct($source) {
		if (!$source instanceof \DOMElement) {
			$domDocument = new \DOMDocument('1.0');
			$domDocument->loadHTML($source);
			
			$domElements = $domDocument->getElementsByTagName('a');
			if ($domElements->length == 1) {
				$this->__domElement = $domElements->item(0);
			}
		} else {
			$this->__domElement = $source;
		}
		
		if ($this->__domElement instanceof \DOMElement) {
			$this->__source = $this->__domElement->nodeValue;

			$this->href = $this->__domElement->getAttribute('href');
		}
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->__source;
	}

	/**
	 * @return bool
	 */
	public function isMailto() {
		return (strpos($this->href, 'mailto:') !== false);
	}

	/**
	 * @return bool
	 */
	public function isJavascript() {
		return (strpos($this->href, 'javascript:') !== false);
	}

	/**
	 * @param $url
	 * @return bool
	 */
	public function isInternal($url) {
		return (strpos($this->href, $url) !== false);
	}

	/**
	 * @param $url
	 * @return bool
	 */
	public function isExternal($url) {
		return !$this->isInternal($url);
	}
}
