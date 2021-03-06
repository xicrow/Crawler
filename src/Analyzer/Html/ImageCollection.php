<?php
namespace Xicrow\Crawler\Analyzer\Html;

/**
 * Class ImageCollection
 * @package Xicrow\Crawler\Analyzer\Html
 */
class ImageCollection extends AbstractElementCollection {
	/**
	 * @param $item
	 */
	public function add($item) {
		if ($item instanceof Image) {
			$this->items[] = $item;
		}
	}
}
