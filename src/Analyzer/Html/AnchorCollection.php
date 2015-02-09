<?php
namespace Xicrow\Crawler\Analyzer\Html;

/**
 * Class AnchorCollection
 * @package Xicrow\Crawler\Analyzer\Html
 */
class AnchorCollection extends AbstractElementCollection {
	/**
	 * @param $item
	 */
	public function add($item) {
		if ($item instanceof Anchor) {
			$this->items[] = $item;
		}
	}

	/**
	 * @param $question
	 * @param string $arg1
	 * @return array
	 */
	public function getCollectionIs($question, $arg1 = '') {
		$collection = [];
		
		foreach ($this->items as $item) {
			if ($item instanceof Anchor && $item->is($question, $arg1)) {
				$collection[] = $item;
			}
		}
		
		return $collection;
	}
}
