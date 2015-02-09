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
	 */
	public function is($question, $arg1 = ''){
		$answer = false;
		
		switch ($question) {
			case 'mailto':
				$answer = (strpos($this->href, 'mailto:') !== false);
				break;
			case 'javascript':
				$answer = (strpos($this->href, 'javascript:') !== false);
				break;
			case 'absolute':
				$answer = (strpos($this->href, '://') !== false);
				break;
			case 'relative':
				$answer = !$this->is('absolute');
				break;
			case 'https':
				$answer = (strpos($this->href, 'https://') !== false);
				break;
			case 'http':
				$answer = !$this->is('https');
				break;
			case 'internal':
				$answer = (strpos($this->href, $arg1) !== false);
				break;
			case 'external':
				$answer = !$this->is('internal', $arg1);
				break;
		}
		
		return $answer;
	}
}
