<?php 
namespace OlTheme\Validation;
class RuleValidator
{
	protected $_name;
	protected $_rule;
	protected $_rule_name;
	protected $_rule_data;
	protected $_data;
	protected $_error;
	public function __construct($name, array $rule, array $data)
	{
		$this->_name = $name;
		$this->_rule = $rule;
		$this->_data = $data;
	}
	public function isValid()
	{
		$rule = $this->_rule;
		$rule_name = $rule[0];
		$rule_list = $this->_getRuleList();
		if(!array_key_exists($rule_name, $rule_list)){
			return true;
		}
		$is_valid = call_user_func([$this,$rule_list[$rule_name]]);
		if(!$is_valid){
			$this->_setError($rule_name);
		}	
		return $is_valid;
	}
	public function getError()
	{
		return $this->_error;
	}
	private function _getDataRule()
	{
		$data = $this->_data;
		$name = $this->_name;
		return empty($data[$name]) ? false : $data[$name];
	}
	protected function _checkRequired()
	{
		$value = $this->_getDataRule();
		return !empty($value);
	}
	protected function _checkEmail()
	{
		$value = $this->_getDataRule();
		return is_email($value);
	}
	protected function _checkNumber()
	{
		$value = $this->_getDataRule();
		return is_numeric($value);
	}	
	protected function _checkInclude()
	{
		$value = $this->_getDataRule();
		$rule = $this->_rule;
		if(empty($rule) || count($rule) < 2){
			return true;
		}
		$in_data = explode(',',$rule[1]);
		return in_array($value, $in_data);
	}	
	protected function _setError($rule_name)
	{
		$msgs = [
			'required' => 'is required.',
			'email' => 'is not email',
			'in' => 'incorrect value',
		];
		if(!array_key_exists($rule_name, $msgs)){
			return false;
		}
		$this->_error = "{$this->_name} {$msgs[$rule_name]}";
		return;
	}
	protected function _getRuleList()
	{
		return [
			'required' => '_checkRequired',
			'email' => '_checkEmail',
			'in' => '_checkInclude',
			'number' => '_checkNumber',
		];
	}
}