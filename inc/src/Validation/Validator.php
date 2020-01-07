<?php 
namespace OlTheme\Validation;
class Validator
{
	protected $_errors;
	public function check($rules,$data)
	{
		$error = false;
		foreach($rules as $rule_name => $rule){
			$rule_data = $this->_convertRule($rule);
			foreach ($rule_data as $rule_item) {
				if(empty($rule_item)){
					continue;
				}
				$rule_validator = new RuleValidator($rule_name,$rule_item,$data);
				if(!$rule_validator->isValid()){
					$error = $rule_validator->getError();
					break;
				}				
			}	
		}
		$this->_errors = $error;
		return;
	}
	public function success()
	{
		return empty($this->_errors);
	}
	public function getError()
	{
		return $this->_errors;
	}
	protected function _convertRule($rule)
	{
		$data = explode('|', $rule);
		$data = array_map(function($ite){
			return explode(':',$ite);
		}, $data);
		return $data;
	}
}