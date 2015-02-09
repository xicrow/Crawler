<?php
namespace Xicrow\Crawler\Analyzer\Html;

/**
 * Class Image
 * @package Xicrow\Crawler\Analyzer\Html
 */
class Image {
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
	private $src = '';

	/**
	 * @param $source
	 */
	public function __construct($source) {
		if (!$source instanceof \DOMElement) {
			$domDocument = new \DOMDocument('1.0');
			$domDocument->loadHTML($source);

			$domElements = $domDocument->getElementsByTagName('img');
			if ($domElements->length == 1) {
				$this->__domElement = $domElements->item(0);
			}
		} else {
			$this->__domElement = $source;
		}

		if ($this->__domElement instanceof \DOMElement) {
			$this->__source = $this->__domElement->nodeValue;

			$this->src = $this->__domElement->getAttribute('src');
		}
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->__source;
	}
}
