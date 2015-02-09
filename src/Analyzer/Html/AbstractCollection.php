<?php
namespace Xicrow\Crawler\Analyzer\Html;

/**
 * Class AbstractCollection
 * @package Xicrow\Crawler\Analyzer\Html
 */
class AbstractCollection implements \Countable, \Iterator {
	/**
	 * @var array
	 */
	protected $items = [];

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
