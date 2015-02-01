<?php
/**
 * @author         Rahul Bhattacharya <librianrahul@gmail.com>
 * @package        git-issue
 * @created        January 21, 2014
 */

/**
 * Add an issue in specific repository based on repository url.
 *
 * @author Rahul Bhattacharya <librianrahul@gmail.com>
 */
class Handler
{
	/** @var string */
	private $userName = '';

	/** @var string */
	private $password = '';

	/** @var string */
	private $url = '';

	/** @var string */
	private $type = '';

	/** @var string */
	private $path = '';

	const TYPE_GIT       = 1;
	const TYPE_BITBUCKET = 2;

	/**
	 * @author Rahul Bhattacharya <librianrahul@gmail.com>
	 *
	 * @param string $url
	 * @param string $userName
	 * @param string $password
	 */
	public function __construct($url, $userName, $password)
	{
		$this->SetURL($url)
			 ->SetUserName($userName)
			 ->SetPassword($password)
			 ->Configure();
	}

	/**
	 * @author Rahul Bhattacharya <librianrahul@gmail.com>
	 *
	 * @param int $type
	 *
	 * @return bool
	 */
	static public function IsValidAPIType($type)
	{
		return ($type === self::TYPE_GIT || $type === self::TYPE_BITBUCKET);
	}

	/**
	 * @author Rahul Bhattacharya <librianrahul@gmail.com>
	 *
	 * @param string $url
	 *
	 * @return Handler
	 * @throws Exception
	 */
	protected function SetURL($url)
	{
		if (empty($url)) {
			throw new Exception('URL is empty');
		}

		$this->url = $url;

		return $this;
	}

	/**
	 * @author Rahul Bhattacharya <librianrahul@gmail.com>
	 * @return string
	 */
	public function GetURL()
	{
		return $this->url;
	}

	/**
	 * @author Rahul Bhattacharya <librianrahul@gmail.com>
	 *
	 * @param string $userName
	 *
	 * @return Handler
	 * @throws Exception
	 */
	protected function SetUserName($userName)
	{
		if (empty($userName)) {
			throw new Exception('Username is empty');
		}

		$this->userName = $userName;

		return $this;
	}

	/**
	 * @author Rahul Bhattacharya <librianrahul@gmail.com>
	 * @return string
	 */
	public function GetUserName()
	{
		return $this->userName;
	}

	/**
	 * @author Rahul Bhattacharya <librianrahul@gmail.com>
	 *
	 * @param string $password
	 *
	 * @return Handler
	 * @throws Exception
	 */
	protected function SetPassword($password)
	{
		if (empty($password)) {
			throw new Exception('Password is empty');
		}

		$this->password = $password;

		return $this;
	}

	/**
	 * @author Rahul Bhattacharya <librianrahul@gmail.com>
	 * @return string
	 */
	public function GetPassword()
	{
		return $this->password;
	}

	/**
	 * @author Rahul Bhattacharya <librianrahul@gmail.com>
	 *
	 * @param string $type
	 *
	 * @return Handler
	 * @throws Exception
	 */
	protected function SetType($type)
	{
		if (empty($type)) {
			throw new Exception('API type is empty');
		}

		$this->type = $type;

		return $this;
	}

	/**
	 * @author Rahul Bhattacharya <librianrahul@gmail.com>
	 * @return string
	 */
	public function GetType()
	{
		return $this->type;
	}

	/**
	 * @author Rahul Bhattacharya <librianrahul@gmail.com>
	 *
	 * @param string $path
	 *
	 * @return Handler
	 * @throws Exception
	 */
	protected function SetPath($path)
	{
		if (empty($path)) {
			throw new Exception('Invalid repository');
		}

		$this->path = $path;

		return $this;
	}

	/**
	 * @author Rahul Bhattacharya <librianrahul@gmail.com>
	 * @return string
	 */
	public function GetPath()
	{
		return $this->path;
	}

	/**
	 * @author Rahul Bhattacharya <librianrahul@gmail.com>
	 *
	 * @return Handler
	 */
	public function Configure()
	{
		$apiURL      = parse_url($this->GetURL());
		$domain      = isset($apiURL['host']) ? $apiURL['host'] : '';
		$domainChunk = explode('.', $domain);

		if ($domainChunk[0] == 'github') {
			$this->SetType(self::TYPE_GIT)
				 ->SetPath('repos/' . trim($apiURL['path']) . '/issues');
		} else if ($domainChunk[0] == 'bitbucket') {
			$this->SetType(self::TYPE_BITBUCKET)
				 ->SetPath('repositories/' . trim($apiURL['path']) . '/issues');
		}

		return $this;
	}

	/**
	 * @author Rahul Bhattacharya <librianrahul@gmail.com>
	 * @return string
	 * @throws Exception
	 */
	protected function GetApiUrl()
	{
		if ($this->GetType() == self::TYPE_GIT) {
			$apiUrl = 'https://api.github.com/:path';
		} else if ($this->GetType() == self::TYPE_BITBUCKET) {
			$apiUrl = 'https://api.bitbucket.org/1.0/:path';
		} else {
			throw new Exception('Invalid API call.');
		}

		$url = strtr($apiUrl, [':path' => trim(implode('/', array_filter(array_map('urlencode', explode('/', $this->GetPath())))))]);

		return $url;
	}

	/**
	 * @author Rahul Bhattacharya <librianrahul@gmail.com>
	 *
	 * @param array $postParameters
	 *
	 * @return string
	 * @throws Exception
	 */
	public function SendRequest(array $postParameters)
	{
		$curlResource = curl_init();
		curl_setopt($curlResource, CURLOPT_URL, $this->GetApiUrl());
		curl_setopt($curlResource, CURLOPT_USERPWD, $this->GetUserName() . ":" . $this->GetPassword());
		curl_setopt($curlResource, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curlResource, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0');

		if ($this->GetType() == self::TYPE_GIT) {
			curl_setopt($curlResource, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
			curl_setopt($curlResource, CURLOPT_CONNECTTIMEOUT, 90);

			$data = json_encode($postParameters);
		} else if ($this->GetType() == self::TYPE_BITBUCKET) {
			curl_setopt($curlResource, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($curlResource, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($curlResource, CURLOPT_HEADER, false);
			curl_setopt($curlResource, CURLOPT_POST, count($postParameters));
			$data = utf8_encode(trim(http_build_query($postParameters, '', '&')));
		} else {
			throw new Exception('Invalid API type.');
		}

		curl_setopt($curlResource, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curlResource, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curlResource, CURLOPT_POSTFIELDS, $data);

		$response = json_decode(curl_exec($curlResource));

		$errorNumber = curl_errno($curlResource);
		if ($errorNumber) {
			throw new Exception('curl Error(' . $errorNumber . '): ' . curl_strerror($errorNumber));
		}

		if (!isset($response->title) || empty($response->title)) {
			return '';
		}

		return $response;
	}
}