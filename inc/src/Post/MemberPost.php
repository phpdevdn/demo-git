<?php 
namespace OlTheme\Post;
use OlTheme\Helpers\Text;
use OlTheme\Helpers\OlForm;
class MemberPost
{	
    const NAME = 'member';
    const SLUG = 'member';
    private $meta_name = 'custom_meta';
    private $input_identify = 'member_edit';
    private $_actions = [
            'member_hot_active' => [
                'name' => 'Active hot',
                'meta' => 'member_hot',
                'value' => 1,
            ],
            'member_hot_disable' => [
                'name' => 'Disable hot',
                'meta' => 'member_hot',
                'value' => 0,
            ],
        ];
    //
	public function __construct()
	{
		$this->loadAction();
	}
	public function loadAction()
	{
        $post_name = static::NAME;
        add_action( 'init', [$this,'register']);
        add_action('add_meta_boxes',[$this,'addMetas']);
        add_action('save_post_'.$post_name,[$this,'handleSave']);
        //add-action
        add_filter('bulk_actions-edit-'.$post_name,[$this,'addRowActions']);
        add_filter('handle_bulk_actions-edit-'.$post_name,[$this,'handleAction'],10,3);
        //add-filter-manager
        add_action( 'restrict_manage_posts',[$this,'addFilterList']);
        add_filter('parse_query',[$this,'handleQuery'],99);
        //add-column-manager
        add_filter("manage_{$post_name}_posts_columns",[$this,'addColumns']);
        add_action(
            "manage_{$post_name}_posts_custom_column",
            [$this,'addColumnValue'],
            10,2
        );
	}
    public function addColumns($cols)
    {
        $cols['member_hot'] = 'Member hot';
        return $cols;
    }
    public function addColumnValue($column, $post_id)
    {
        $col_hot = 'member_hot';
        $col_meta = 'member_hot';
        if($column == $col_hot){
            echo get_post_meta($post_id,$col_meta,true);
        }
        return;
    }
    public function handleAction($redirect_to, $doaction, $post_ids)
    {
        $actions = $this->_actions;
        if(!array_key_exists($doaction, $actions)){
            return $redirect_to;
        }
        $act_item = $actions[$doaction];
        $value = $act_item['value'];
        $meta = $act_item['meta'];
        foreach ($post_ids as $post_id) {
            update_post_meta( $post_id, $meta, $value);
        }
        return $redirect_to;  
    }
    public function addRowActions($acts)
    {
        $values = array_map(function($act){
            return $act['name'];
        }, $this->_actions);
        $actions = array_combine(array_keys($this->_actions), $values);
        return array_merge($acts,$actions);
    }
    public function handleQuery($query)
    {
        if( !(is_admin() && $query->is_main_query()) ){ 
          return $query;
        }
        $param_qr = 'member_hot';
        if($query->query['post_type'] !== static::NAME 
            || !isset($_GET[$param_qr])
            || !Text::isBoolean($_GET[$param_qr])
        ){
            return $query;
        }
        $param_val = $_GET[$param_qr] ? 1 : 0;
        $query->query_vars['meta_key'] = $param_qr;    
        $query->query_vars['meta_value'] = $param_val;    
        return $query;
    }
    public function addFilterList( $post_type)
    {
        if($post_type !== static::NAME){
            return;
        }
        $param_qr = 'member_hot';
        $param_val = empty($_GET[$param_qr]) ? null : $_GET[$param_qr];
        echo '<div class="bl_inl pl10 pr10">';
        OlForm::checkbox(
            $param_qr,$param_val,
            ['label'=>'Member hot']
        );
        echo '</div>';
        return;
    }
    public function addMetas()
    {
        add_meta_box( 
            $this->meta_name ,
            'Meta',
            [$this,'metaCallback'],
            [static::NAME], 
            'normal','high' 
        );
    }
    public function metaCallback($post)
    {
        include(OLTHEME_TEMPLATE . '/metas/member-meta.php');
    }
    public function handleSave($post_id)
    {
        if(!empty($_POST[$this->input_identify])){
            $ip_hot = 'member_hot';
            $is_hot = empty($_POST[$ip_hot]) ? 0 : 1;
            update_post_meta( $post_id,$ip_hot, $is_hot);
        }
        return true;
    }
	public function register()
	{
        register_post_type(
            static::NAME,
            [
                'labels' => [
                    'name' => 'Web Member',
                    'singular_name' => 'Web Member'
                ],
                'capability_type' => 'post',
                'supports'=>[
                    'title','editor','author', 
                    'thumbnail', 'excerpt', 'comments'
                ],
                'show_in_rest'=>true,
                'show_ui'=>true,
                'public' => true,
                'has_archive' => true,
                'menu_position'=>21,
                'rewrite' => ['slug' => static::SLUG]
            ]
        ); 
	}
}