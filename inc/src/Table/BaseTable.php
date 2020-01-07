<?php
namespace OlTheme\Table;
use OlTheme\Table\Traits\QueryTrait; 
use OlTheme\Table\Traits\ParserTrait; 
class BaseTable{
	use QueryTrait,ParserTrait;
	//
	protected static $instance;
	protected $table_name;
	protected $chaset_collate = 'DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci';
	protected $_wpdb;
	public function __construct(){
		global $wpdb;
		$this->_wpdb = $wpdb;
	}
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static;
        }
        return static::$instance;
    }
	public function sql()
	{
		global $wpdb;
		$this->setQueryString();
		$sql = $this->getQueryString();
		$this->resetQuery();
		return $sql;		
	}    
	public function find($id)
	{
		$res = $this->where(['id'=>$id])
						->first();
		return $res;
	}
	public function first(){
		global $wpdb;
		$this->limit_query = 1;
		$this->setQueryString();
		$sql = $this->getQueryString();
		$res = $wpdb->get_results($sql);
		if(!$res){
			return false;
		}
		$this->resetQuery();
		return $res[0];
	}
	public function get(){
		global $wpdb;
		$this->setQueryString();
		$sql = $this->getQueryString();
		$this->resetQuery();
		return $wpdb->get_results($sql);
	}	
	public function paginate()
	{
		$this->setQueryString();
		//
		$sql_count = $this->count();
		$result_total = $this->_wpdb->get_var($sql_count);
		$total_page = ceil($result_total / $this->limit_query);
		//
		$sql = $this->getQueryString();
		$results = $this->_wpdb->get_results($sql);
		//
		$res = [
			'current'=>$this->page_query,
			'size' => $result_total,
			'total'=>$total_page,
			'data'=>$results
		];
		//
		$this->resetQuery();
		return (object)$res; 		
	}
	private function count(){
		$sql = "SELECT COUNT(*) FROM $this->table_name";
		$sql .= " ".$this->cond_str;
		return $sql;
	}		
	public function create($data=[])
	{		
		if(empty($data)){ return false;}
		$field_names = $this->__parseFieldNames($data);
		$field_placeholders = $this->__parseFieldPlaceholders($data);
		$field_values = $this->__parseFieldValues($data);
		$sql = $this->_wpdb->prepare(
					"
					INSERT INTO $this->table_name
					($field_names)
					VALUES ($field_placeholders)
					",
					$field_values
			);
		try {
			return $this->_wpdb->query($sql);			
		} catch (Exception $e) {
			return false;
		}

	}
	public function update($data){
		global $wpdb;
		$this->setQueryString();
		$sets = $this->generateQuery($data,',');
		$set_str = $wpdb->prepare($sets,$data);
		$sql = "UPDATE $this->table_name";
		$sql .= " SET $set_str";
		$sql .= " ".$this->cond_str;
		$res = $wpdb->query($sql);
		//
		$this->resetQuery();
		return $res;	
	}
	public function delete(){
		global $wpdb;
		$this->setQueryString();
		$sql = "DELETE FROM $this->table_name";
		$sql .= " ".$this->cond_str;
		$res = $wpdb->query($sql);
		//
		$this->resetQuery();
		return $res;		
	}	
}