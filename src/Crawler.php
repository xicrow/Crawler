<?php
namespace Xicrow\Crawler;

use Xicrow\Crawler\Analyzer\Html;

/**
 * Class Crawler
 * @package Xicrow\Crawler
 */
class Crawler {
	/**
	 * @var array
	 */
	private $options = [
		'encoding'        => 'HTML-ENTITIES',
		'userAgent'       => 'Xicrow\Crawler',
		'timeout'         => 30,
		'followRedirects' => true,
		'maxRedirects'    => 3
	];

	/**
	 * @var string
	 */
	private $url = '';

	/**
	 * @var string
	 */
	private $urlBase = '';

	/**
	 * @var string
	 */
	private $source = '';

	/**
	 * @param $url
	 * @param array $options
	 */
	public function __construct($url, $options = []) {
		$this->options = array_merge($this->options, $options);

		$this->setUrl($url);
		$this->__getUrlBase();
		$this->__getSource();
	}

	/**
	 * @param $url
	 */
	public function setUrl($url) {
		$this->url = trim((string)$url);
	}

	/**
	 * @return string
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * @param $urlBase
	 */
	public function setUrlBase($urlBase) {
		$this->urlBase = trim((string)$urlBase);
	}

	/**
	 * @return string
	 */
	public function getUrlBase() {
		return $this->urlBase;
	}

	/**
	 * @param $source
	 */
	public function setSource($source) {
		$this->source = trim((string)$source);
	}

	/**
	 * @return string
	 */
	public function getSource() {
		return $this->source;
	}

	/**
	 * @return Html
	 */
	public function getHtmlAnalyzer() {
		return new Html($this->source);
	}

	/**
	 * @return bool
	 */
	private function __getUrlBase() {
		if ($this->url === '') {
			return false;
		}

		$urlParts = parse_url($this->url);
		if (!isset($urlParts['scheme']) || !isset($urlParts['host'])) {
			return false;
		}

		$this->urlBase = $urlParts['scheme'] . '://' . $urlParts['host'];

		unset($urlParts);

		return true;
	}

	/**
	 * @return bool
	 */
	private function __getSource() {
		if ($this->url === '') {
			return false;
		}

		if (function_exists('curl_init')) {
			$ch = curl_init();
			curl_setopt_array($ch, [
				CURLOPT_URL            => $this->url,
				CURLOPT_FOLLOWLOCATION => $this->options['followRedirects'],
				CURLOPT_MAXREDIRS      => $this->options['maxRedirects'],
				CURLOPT_HEADER         => false,
				CURLOPT_TIMEOUT        => $this->options['timeout'],
				CURLOPT_USERAGENT      => $this->options['userAgent'],
				CURLOPT_RETURNTRANSFER => true
			]);
			$source = curl_exec($ch);
			$info = curl_getinfo($ch);
			curl_close($ch);

			if ($info['http_code'] != 200) {
				return false;
			}

			unset($ch, $info);
		} else {
			if (!$source = file_get_contents($this->url)) {
				return false;
			}
		}

		mb_detect_order('ASCII,UTF-8,ISO-8859-1,windows-1252,iso-8859-15');
		$encoding = mb_detect_encoding($source);
		$source = mb_convert_encoding($source, $this->options['encoding'], $encoding);

		$this->source = $source;

		unset($encoding, $source);

		return true;
	}
}
