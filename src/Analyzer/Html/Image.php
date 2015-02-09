<?php
namespace Xicrow\Crawler\Analyzer\Html;

/**
 * Class Image
 * @package Xicrow\Crawler\Analyzer\Html
 */
class Image extends AbstractElement {
	/**
	 * @var string
	 */
	protected $__tagName = 'img';

	/**
	 * @var string
	 */
	private $src = '';

	/**
	 * @param $source
	 */
	public function __construct($source) {
		parent::__construct($source);
		
		$this->src = $this->__domElement->getAttribute('src');
	}
}
