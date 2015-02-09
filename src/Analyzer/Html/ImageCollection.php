<?php
namespace Xicrow\Crawler\Analyzer\Html;

/**
 * Class ImageCollection
 * @package Xicrow\Crawler\Analyzer\Html
 */
class ImageCollection extends AbstractCollection {
	/**
	 * @param array $items
	 */
	public function __construct($items = []) {
		if (is_array($items) && count($items)) {
			foreach ($items as $item) {
				$this->add(new Image($item));
			}
		}
	}

	/**
	 * @param Image $item
	 */
	public function add(Image $item) {
		$this->items[] = $item;
	}
}
