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
	 * @var mixed
	 */
	private $responseInfo;
	
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
		
		if (trim($url) != '') {
			$this->setUrl($url);
			$this->__getUrlBase();
			$this->__getSource();
		}
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
		$urlParts = parse_url($this->url);
		if (isset($urlParts['scheme']) && isset($urlParts['host'])) {
			$this->urlBase = $urlParts['scheme'] . '://' . $urlParts['host'];
		}
		
		unset($urlParts);
	}

	/**
	 * @return bool
	 */
	private function __getSource() {
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
			$this->source = curl_exec($ch);
			$this->responseInfo = curl_getinfo($ch);
			curl_close($ch);
			
			unset($ch);
		} else {
			$this->source = file_get_contents($this->url);
		}
		
		if (is_string($this->source)) {
			mb_detect_order('ASCII,UTF-8,ISO-8859-1,windows-1252,iso-8859-15');
			$encoding = mb_detect_encoding($this->source);
			$this->source = mb_convert_encoding($this->source, $this->options['encoding'], $encoding);

			unset($encoding);
		}
	}
}
