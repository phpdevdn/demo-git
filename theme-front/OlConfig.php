<?php 
class OlConfigBase
{
	private static $instance;
	private $options = [];
	function __construct()
	{
		$this->loadDefault();
	}
	protected function loadDefault()
	{
		$opt = get_option('oltheme_information');
		$values = empty($opt) ? [] : unserialize($opt);
		$this->options = $values;
		return;
	}
	public function getOption($name)
	{
		$options = $this->options;
		if(!array_key_exists($name,$options)){
			return null;
		}
		return $options[$name];
	}
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static;
        }
        return static::$instance;
    }
}	

class OlConfig
{
	
	function __construct()
	{
	}
    public static function __callStatic($name, $arg)
    {
    	$config = OlConfigBase::getInstance();
    	if(method_exists($config, $name)){
    		return call_user_func_array([$config,$name],$arg);
    	}  	
    }		
}