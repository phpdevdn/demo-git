<?php 
namespace OlTheme\Table\Traits;
trait ParserTrait
{
	protected function __parseFieldNames(array $data)
	{
		$fields = array_keys($data);
		return implode(',', $fields);
	}
	protected function __parseFieldPlaceholders(array $data)
	{
		$fields = array_keys($data);
		$columns = $this->__getFieldData();
		$placeholder = array_map(function($field) use($columns){
			$place = '%s';
			foreach($columns as $column){
				if($column->Field == $field){
					$place = $this->__getPlaceType($column->Type);
					break;
				}
			}
			return $place;
		}, $fields);
		return implode(',',$placeholder);
	}
	protected function __parseFieldValues(array $data)
	{
		return array_values($data);
	}
	protected function __getFieldData()
	{
		$sql = $this->_wpdb->prepare(
			"SHOW COLUMNS FROM {$this->table_name}"
		);
		$res = $this->_wpdb->get_results($sql);
		return $res;
	}
	protected function __getPlaceType($type)
	{
		if(preg_match('/int/', $type)){
			return '%d';
		}
		if(preg_match('/float|double/', $type)){
			return '%f';
		}		
		return '%s';
	}	
}