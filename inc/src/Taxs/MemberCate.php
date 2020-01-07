<?php 
namespace OlTheme\Taxs;
use OlTheme\Post\MemberPost;
class MemberCate
{
	const NAME='member_cate';
	const SLUG='member-cate';
	private $post_name;
	public function __construct()
	{
		$this->post_name = MemberPost::NAME;
		$this->loadAction();
	}
	public function loadAction()
	{
		add_action('init',[$this,'register']);
	}
    public function register()
    {
        register_taxonomy(
        		static::NAME,
        		$this->post_name,
        		[
                'hierarchical' => true,
                'labels'=> [
                    'name'=>'Member cate',
                    'singular_name' => 'Member cate',
                ],
                'show_admin_column' => false,
                'rewrite' =>['slug' => static::SLUG]
                ] 
            );         
    }	
}