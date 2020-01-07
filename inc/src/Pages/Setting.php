<?php 
namespace OlTheme\Pages;
class Setting extends BasePage{
	protected $_page_name = 'ol_setting';
	protected $_option_theme = 'oltheme_information';
	function __construct(){
		parent::__construct();
		add_action('admin_menu',[$this,'addMenuPage']);
		add_action('admin_enqueue_scripts',[$this,'enqueueScript']);
		add_action( 'wp_loaded',[$this,'handleAction']);
	}
	public function enqueueScript(){
			wp_enqueue_media();
			wp_enqueue_style(
				'oladmin-component',
				OLTHEME_ASSET.'/css/component.css',
				[],APP_VERSION
			);
			wp_enqueue_style(
				'oladmin',
				OLTHEME_ASSET.'/css/ol_theme.css',
				[],APP_VERSION
			);
			
			//script
			wp_enqueue_script(
				'oladmin-component',
				OLTHEME_ASSET.'/js/component.js',
				[], APP_VERSION, true
			);
			wp_enqueue_script(
				'oladmin',
				OLTHEME_ASSET.'/js/ol_theme.js',
				[], APP_VERSION, true
			);
			
	}		
	public function addMenuPage(){
		add_menu_page( 
			'Cài đặt theme',
			'Cài đặt theme',
			$this->_capacity, 
			$this->_page_name,
			[$this,'viewPage']
			,'',26
		);		
	}
	public function handleAction()
	{
		$action = $this->request->query('action');
		$actions = [
			'update_general' => [$this,'updateGeneral']
		];
		if(!array_key_exists($action, $actions)){
			return false;
		}
		$callback = $actions[$action];
		return call_user_func($callback);
	}
	public function viewPage(){
		return $this->view('setting/index');
	}
	public function updateGeneral()
	{
		if($this->request->method !== 'post'){
			return $this->back();
		}
		$info = $this->request->input('info',[]);
		$value = serialize($info);
		update_option($this->_option_theme,$value);
		ol_clear_super_cache();
	}
}
