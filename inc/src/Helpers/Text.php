<?php 
namespace OlTheme\Helpers;
class Text
{
	public static function isBoolean($value)
	{
		$value = trim($value);
		if($value === NULL || $value === '' || $value === ' '){
			return false;
		}
		return true;
	}
}