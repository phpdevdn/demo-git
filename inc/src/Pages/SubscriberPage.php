<?php 
namespace OlTheme\Pages;
use OlTheme\Table\SubscriberTable;
class SubscriberPage extends BasePage
{
	protected $_page_name = 'subscriber';
	protected $_page_name_setting = 'subscriber_setting';	
	private $_subscriberTb;
	public function __construct()
	{
		parent::__construct();
		$this->_subscriberTb = SubscriberTable::getInstance();
		add_action('admin_menu',[$this,'addMenuPage']);
		add_action( 'wp_loaded',[$this,'handleAction']);
	}
	public function addMenuPage()
	{
		add_menu_page( 
			'Subscriber',
			'Subscriber',
			$this->_capacity, 
			$this->_page_name,
			[$this,'viewSubscriber'],
			'',26
		);
		add_submenu_page( 
			$this->_page_name, 
			'Setting subscribers',
			'Setting subscribers',
			$this->_capacity,
			$this->_page_name_setting,
			[$this,'viewSettingPage']  
		);
	}
	public function viewSubscriber()
	{
		$action = $this->request->query('action');
		$actions = [
			'edit' => [$this,'edit'],
			'index' => [$this,'index']
		];
		if(array_key_exists($action, $actions)){
			$callback = $actions[$action];
		}else{
			$callback = $actions['index'];
		}
		return call_user_func($callback);
	}
	public function handleAction()
	{
		$qr_page = $this->request->query('page');
		if( $qr_page !== $this->_page_name && $qr_page !== $this->_page_name_setting){
			return false;
		}
		$action = $this->request->input('action');
		if(!$action){
			$action = $this->request->query('action');
		}
		$actions = [
			'create_table' => [$this,'createTable'],
			'seed_data' => [$this,'seedData'],
			'delete' => [$this,'delete'],
			'update' => [$this,'update'],
		];
		if(array_key_exists($action, $actions)){
			return call_user_func($actions[$action]);
		}
		return false;
	}
	public function index()
	{
		$paged = $this->request->query('paged',1);
		$qr_name = $this->request->query('name');
		$results = $this->_subscriberTb
								->limit(10)
								->page($paged);
		if(!empty($qr_name)){
			$results = $results->where(['name LIKE'=>"%{$qr_name}%"]);
		}						
		$results  = $results->paginate();
		return $this->view('subscriber/index',compact('results'));
	}
	public function edit()
	{
		if(!$this->request->query('id')){
			return $this->back();
		}
		$id = $this->request->query('id');
		$subscriber = $this->_subscriberTb
								->find($id);
		if(!$subscriber){
			return $this->back();
		}						
		return $this->view(
			'subscriber/edit',
			compact('subscriber')
		);
	}
	public function update()
	{
		if($this->request->method !== 'post'){
			return $this->back();
		}
		$id = $this->request->query('id');
		if(!$id){
			return $this->back();
		}
		$subscriber = $this->_subscriberTb
								->find($id);
		if(!$subscriber){
			return $this->back();
		}
		$data = $this->request->only(['name','email']);
		$this->_subscriberTb
					->where(['id'=>$id])
					->update($data);
		return $this->back();			
	}	
	public function delete()
	{
		$id = $this->request->query('id');
		if(empty($id)){
			return $this->back();
		}
		$this->_subscriberTb
					->where(['id'=>$id])
					->delete();
		return $this->back(); 			
	}	
	public function viewSettingPage()
	{
		return $this->view('subscriber/setting');
	}
	public function seedData()
	{
		$time = date('Y-m-d H:i:s');
		foreach(range(32,35) as $ite){
			$data = [
				'name' => 'member ' .$ite,
				'email' => "member{$ite}@localhost.pc",
				'created_at' => $time,
				'updated_at' => $time,
			];
			$this->_subscriberTb->create($data);
		}
		$this->message = 'Seed data successfully';
		return true;
	}
	public function createTable()
	{
		$this->_subscriberTb->createTable();
		$this->message = 'create table successfully';
		return true;
	}
}