<?php
namespace Xicrow\Crawler\Analyzer\Html;

/**
 * Class AnchorCollection
 * @package Xicrow\Crawler\Analyzer\Html
 */
class AnchorCollection extends AbstractCollection {
	/**
	 * @param array $items
	 */
	public function __construct($items = []) {
		if (is_array($items) && count($items)) {
			foreach ($items as $item) {
				$this->add(new Anchor($item));
			}
		}
	}

	/**
	 * @param Anchor $item
	 */
	public function add(Anchor $item) {
		$this->items[] = $item;
	}
}
