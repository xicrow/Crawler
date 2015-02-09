<?php
namespace Xicrow\Crawler\Analyzer\Html;

/**
 * Class AbstractCollection
 * @package Xicrow\Crawler\Analyzer\Html
 */
abstract class AbstractCollection implements \Countable, \Iterator {
	/**
	 * @var array
	 */
	protected $items = [];

	/**
	 * @param array $items
	 */
	public function __construct($items = []) {
		if (is_array($items) && count($items)) {
			foreach ($items as $item) {
				$this->add($item);
			}
		}
	}
	
	/**
	 * @param $item
	 */
	abstract public function add($item);

	/**
	 * @return mixed
	 */
	public function current() {
		return current($this->items);
	}

	/**
	 * @return integer
	 */
	public function key() {
		return key($this->items);
	}

	/**
	 *
	 */
	public function next() {
		next($this->items);
	}

	/**
	 *
	 */
	public function rewind() {
		reset($this->items);
	}

	/**
	 * @return bool
	 */
	public function valid() {
		if (is_array($this->items)) {
			$key = key($this->items);

			return ($key !== null && $key !== false);
		} else {
			return false;
		}
	}

	/**
	 * @return int
	 */
	public function count() {
		return count($this->items);
	}
}
