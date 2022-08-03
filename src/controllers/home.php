<?php
use Curl\Curl;

class Home extends Controller {

	private $curl;
	private $configs;
	
    public function __construct()
    {
		$this->curl = new Curl();

		$this->configs["id"] = "myId123"; // your jenkins id
		$this->configs["key"] = "12345abcde"; // your jenkins key
		$this->configs["url"] = "http://123.111.111.22"; // jenkins url
    }
	
	public function index()
	{	

		$data['title'] = 'Jenkins Log';
		$data['js'] = array("index");

		$this->view('templates/header', $data);
		$this->view('index', $data);
		$this->view('templates/footer', $data);
	}

	private function setAuthentication()
	{
		$this->curl->setBasicAuthentication($this->configs["id"], $this->configs["key"]);

	}

	private function setResponse($params)
	{
		if ($this->curl->error) {
			var_dump('Error: ' . $this->curl->errorCode . ': ' . $this->curl->errorMessage . "\n");
		} else {
			echo $params;
		}

	}

    public function get_log()
    {	
		$this->setAuthentication();
		// change jenkins_url
		$this->curl->get("http://123.111.111.22".'/job/'.$_REQUEST["params"]["webApp"].'/job/'.$_REQUEST["params"]["branch"].'/lastBuild/consoleText');
		$this->setResponse($this->curl->response);
    }

	public function build_app() 
	{
		$this->setAuthentication();
		$this->curl->post($this->configs["url"].'/job/'.$_REQUEST["params"]["webApp"].'/job/'.$_REQUEST["params"]["branch"].'/build');
		$this->setResponse("success");
	}

	public function get_apps()
    {
		echo json_encode($GLOBALS["jenkinsAPPS"]);
    }
}