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
