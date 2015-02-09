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
	 * @param $question
	 * @param string $arg1
	 * @return bool
	 */
	public function is($question, $arg1 = ''){
		switch ($question) {
			case 'mailto':
				return (strpos($this->href, 'mailto:') !== false);
			case 'javascript':
				return (strpos($this->href, 'javascript:') !== false);
			case 'absolute':
				return (strpos($this->href, '://') !== false);
			case 'relative':
				return !$this->is('absolute');
			case 'https':
				return (strpos($this->href, 'https://') !== false);
			case 'http':
				return !$this->is('https');
			case 'internal':
				return (strpos($this->href, $arg1) !== false);
			case 'external':
				return !$this->is('internal', $arg1);
		}
		
		return false;
	}
}
