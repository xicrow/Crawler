<?php
namespace Xicrow\Crawler\Analyzer;

use Xicrow\Crawler\Analyzer\Html\AnchorCollection;
use Xicrow\Crawler\Analyzer\Html\ImageCollection;

/**
 * Class Html
 * @package Xicrow\Crawler\Analyzer
 */
class Html {
	/**
	 * @var string
	 */
	private $__source = '';

	/**
	 * @var array
	 */
	private $tagToVarMap = [
		'meta' => 'metas',
		'img'  => 'images',
		'a'    => 'anchors'
	];

	/**
	 * @var array
	 */
	private $metas = [];

	/**
	 * @var array
	 */
	private $images = [];

	/**
	 * @var array
	 */
	private $anchors = [];

	/**
	 * @param string $source
	 */
	public function __construct($source) {
		$this->__source = (string)$source;
		$this->__analyze();
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->__source;
	}

	/**
	 * @param $metas
	 */
	public function setMetas($metas) {
		if (is_array($metas)) {
			$this->metas = $metas;
		} else {
			$this->metas = [$metas];
		}
	}

	/**
	 * @return string
	 */
	public function getMetas() {
		return $this->metas;
	}

	/**
	 * @param $images
	 */
	public function setImages($images) {
		if (is_array($images)) {
			$this->images = $images;
		} else {
			$this->images = [$images];
		}
	}

	/**
	 * @return string
	 */
	public function getImages() {
		return $this->images;
	}

	/**
	 * @param $anchors
	 */
	public function setAnchors($anchors) {
		if (is_array($anchors)) {
			$this->anchors = $anchors;
		} else {
			$this->anchors = [$anchors];
		}
	}

	/**
	 * @return string
	 */
	public function getAnchors() {
		return $this->anchors;
	}

	/**
	 * @return AnchorCollection
	 */
	public function getAnchorCollection() {
		return new AnchorCollection($this->anchors);
	}

	/**
	 * @return ImageCollection
	 */
	public function getImageCollection() {
		return new ImageCollection($this->images);
	}

	/**
	 * @return bool
	 */
	private function __analyze() {
		$domDocument = new \DOMDocument('1.0');

		if (!$domDocument->loadHTML($this->__source)) {
			unset($domDocument);

			return false;
		}

		foreach ($this->tagToVarMap as $tag => $var) {
			$domElements = $domDocument->getElementsByTagName($tag);
			foreach ($domElements as $domElement) {
				$this->$var[] = $domElement->nodeValue;
			}
		}

		unset($domDocument, $var, $tag, $domElements, $domElement);

		return true;
	}
}
