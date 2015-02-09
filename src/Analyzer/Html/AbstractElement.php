<?php
namespace Xicrow\Crawler\Analyzer\Html;

/**
 * Class Anchor
 * @package Xicrow\Crawler\Analyzer\Html
 */
abstract class AbstractElement {
	
	protected $__tagName = '';
	
	/**
	 * @var \DOMElement
	 */
	protected $__domElement;

	/**
	 * @var string
	 */
	protected $__source = '';

	/**
	 * @param $source
	 */
	public function __construct($source) {
		if (!$source instanceof \DOMElement) {
			$domDocument = new \DOMDocument('1.0');
			$domDocument->loadHTML($source);

			$domElements = $domDocument->getElementsByTagName($this->__tagName);
			if ($domElements->length == 1) {
				$this->__domElement = $domElements->item(0);
			}
		} else {
			$this->__domElement = $source;
		}

		if ($this->__domElement instanceof \DOMElement) {
			$this->__source = $this->__domElement->nodeValue;
		}
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->__source;
	}
}
