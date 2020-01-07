<?php 
namespace OlTheme\Pages;
use OlTheme\Helpers\Request;
class BasePage
{
	protected $request;
	protected $message;
	protected $_capacity = 'edit_pages';
	public function __construct()
	{
		$this->request = Request::getInstance();
	}
	protected function back()
	{
			wp_safe_redirect(wp_get_referer());
			exit;		
	}
	protected function getLink(array $args)
	{
		$def = [
			'page' => $this->_page_name,
		];
		$args = array_merge($def,$args);
		$admin_url = admin_url('admin.php'); 
		return add_query_arg($args, $admin_url);
	}
	protected function view($template, array $data=[])
	{
		extract($data);
		$file = OLTHEME_TEMPLATE . '/' . $template . '.php';
		include($file);
	}
}