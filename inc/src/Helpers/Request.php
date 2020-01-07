<?php
namespace OlTheme\Helpers; 
class Request
{
	private static $instance;
	public $query;
	public $data;
	public $method;
	public function __construct()
	{
		$this->initData();
	}
	public function only($fields)
	{
		$data = $this->data;
		$keys = array_fill_keys($fields,'');
		return array_intersect_key($data, $keys);
	}
	public function input($name = null, $default = null)
	{
		if($name === null){
			return $this->data;
		}
		if(array_key_exists($name, $this->data)){
			return $this->data[$name];
		}
		return $default;
	}
	public function query($name = null, $default = null)
	{
		if($name === null){
			return $this->query;
		}
		if(array_key_exists($name, $this->query)){
			return $this->query[$name];
		}
		return $default;
	}	
	//
	private function initData()
	{
		$server = $_SERVER;
		$this->query = $_GET;
		$this->data = $_POST;
		$this->method = strtolower($server['REQUEST_METHOD']);
		return;
	}
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static;
        }
        return static::$instance;
    }	
}