<?php
/**
 * @author         Rahul Bhattacharya <librianrahul@gmail.com>
 * @package        git-issue
 * @created        January 21, 2014
 */

//disable error messages
ini_set('display_errors', 0);

if (PHP_SAPI !== 'cli') {
	die('PHP cli not found!');
}

require_once('api/Handler.php');

/**
 * Post issues to specific repositories based on repository url.
 *
 * @author Rahul Bhattacharya <librianrahul@gmail.com>
 */
class CreateIssue
{
	/** @var string */
	private $userName = '';

	/** @var string */
	private $password = '';

	/** @var string */
	private $repositoryURL = '';

	/** @var string */
	private $title = '';

	/** @var string */
	private $description = '';

	/**
	 * @author Rahul Bhattacharya <librianrahul@gmail.com>
	 *
	 * @param array $argv
	 */
	public function __construct(array $argv)
	{
		$this->userName      = $argv[1];
		$this->password      = $argv[2];
		$this->repositoryURL = $argv[3];
		$this->title         = $argv[4];
		$this->description   = $argv[5];
	}

	/**
	 * Validate the required parameters
	 *
	 * @author Rahul Bhattacharya <librianrahul@gmail.com>
	 *
	 * @return bool
	 * @throws Exception
	 */
	private function IsValidInput()
	{
		if (empty($this->userName) || empty($this->password) || empty($this->repositoryURL) || empty($this->title) || empty($this->description)) {
			return false;
		}

		return true;
	}

	/**
	 * Send request to API library
	 *
	 * @author Rahul Bhattacharya <librianrahul@gmail.com>
	 */
	public function Request()
	{
		if (!$this->IsValidInput()) {
			exit('Please input valid parameter(s).');
		}

		try {
			$response = (new Handler($this->repositoryURL, $this->userName, $this->password))->SendRequest(['title' => $this->title, 'desc' => $this->description]);
		} catch (Exception $Exception) {
			echo $Exception->getMessage();

			return;
		}

		if (empty($response)) {
			echo PHP_EOL . 'Unable to create issue.' . PHP_EOL;

			return;
		}

		echo PHP_EOL . 'Issue created successfully.' . PHP_EOL . print_r($response) . PHP_EOL;
	}
}

(new CreateIssue($argv))->Request();
