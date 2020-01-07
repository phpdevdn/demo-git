<?php 
namespace OlTheme\Table\Traits;
trait QueryTrait{
	protected $select_query;
	protected $where_query=[];
	protected $where_in_query=[];
	protected $or_where_query=[];
	protected $limit_query;
	protected $page_query;
	protected $order_query;
	//
	protected $select_str;
	protected $cond_str;
	protected $where_in_str;
	protected $or_where_str;
	protected $limit_str;
	protected $order_str;
	//	
	public function select($args=[]){
		$this->select_query = $args;
		return $this;
	}
	public function where($args=[]){
		$this->where_query = array_merge($this->where_query,$args);
		return $this;
	}
	public function orWhere($args=[]){
		$this->or_where_query = array_merge($this->or_where_query,$args);
		return $this;
	}	
	public function whereIn($field,$values){
		$this->where_in_query[$field] = $values;
		return $this; 
	}
	public function limit($number){
		$this->limit_query = $number;
		return $this;	
	}
	public function page($number){
		$this->page_query = $number;
		return $this;
	}
	public function orderBy($order,$sort='desc'){
		$this->order_query = "$order $sort";
		return $this;
	}
	//
	private function resetQuery(){
		$this->select_query = null ;
		$this->where_query = [] ;
		$this->where_in_query = [] ;
		$this->or_where_query = [] ;
		$this->limit_query = null ;
		$this->page_query = null ;
		$this->order_query = null ;		
	}
	private function setQueryString(){
		//select
		$select= empty($this->select_query) ? '*' : implode(',',$this->select_query);
		$this->select_str = "SELECT $select";
		//where
		$conds = $this->getConditionString();
		$this->cond_str = "WHERE $conds";
		//order
		if(!empty($this->order_query)){
			$this->order_str = " ORDER BY $this->order_query";
		}else{
			$this->order_str = null;
		}
		//limit
		if(!empty($this->limit_query)){
			$limit = "LIMIT $this->limit_query";
			if(empty($this->page_query)){
				$offset = 0;
			}else{
				$offset = ($this->page_query - 1) * $this->limit_query;
			}
			$limit .= " OFFSET $offset";
			$this->limit_str = $limit;
		}else{
			$this->limit_str = null;
		}		
		return;
	}
	private function getQueryString(){
		$sql = $this->select_str;
		$sql .= " FROM ".$this->table_name;
		$sql .= " ".$this->cond_str;
		$sql .= " ".$this->order_str;
		$sql .= " ".$this->limit_str;
		return $sql; 
	}
	private function getConditionString(){
		$conds = [];
		if(!empty($this->where_query)){
			$conds[] = $this->array2queryString($this->where_query);
		}
		if(!empty($this->where_in_query)){
			$conds[] = $this->getWhereInString();
		}
		$cond_str = implode(' AND ', $conds);
		if(!empty($this->or_where_query)){
			$cond_or_str= $this->array2queryString($this->or_where_query,' OR ');
			$cond_str .= " {$cond_or_str}";
		}		
		return empty($cond_str) ? 1 : $cond_str;		
	}
	private function getWhereInString()
	{
		$params = $this->where_in_query;
		if(empty($params)){ return null;}
		$cond_ar = array_map(function($key,$ite){
			$values = implode(',', $ite);
			return "{$key} IN ({$values})";
		},array_keys($params),$params);
		return implode(' AND ', $cond_ar);
	}
	private function array2queryString($conds,$seperate=' AND '){
		$str = $this->generateQuery($conds,$seperate);
		return $this->_wpdb->prepare($str,array_values($conds));
	}
	private function generateQuery($conds,$seperate=' AND '){
		if(empty($conds)){ return 1;}
		$arr = array_map(function($ite,$key){
			if(is_int($ite)){
				$pattern = '%d';
			}elseif(is_float($ite)){
				$pattern = '%f';
			}else{
				$pattern = '%s';
			}
			$key_ar = explode(' ', $key);
			if(count($key_ar) < 2){
				$key_name = $key;
				$compare = '=';
			}else{
				$key_name = $key_ar[0];
				$compare = $key_ar[1];
			}
			return "{$key_name} {$compare} {$pattern}";
		},$conds,array_keys($conds));
		return implode($seperate, $arr);
	}	
}