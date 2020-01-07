<?php
namespace OlTheme\Post; 
class AjaxPost{
	public function __construct(){
		$this->loadAction();
	}
	public function loadAction(){
		add_action( 'wp_ajax_getOlPost', array($this,'getNewPost') );
		add_action( 'wp_ajax_searchOlPost', array($this,'SearchNewPost') );	
		//	
		$page_name = empty($_GET['page']) ? '' : $_GET['page'];
		$page_tab = empty($_GET['tab']) ? '' : $_GET['tab'];		
		if(!in_array($page_name,['ol_setting']) || !in_array($page_tab,['home'])){
			return false;
		}
		//
		add_action('admin_enqueue_scripts',array($this,'enqueueScript'));
		add_action( 'admin_footer',[$this,'addAdminFooter'], 10, 1 );		
	}
	public function enqueueScript(){
			wp_enqueue_style( 'select_post',OLTHEME_ASSET.'/css/select-post.css',[],APP_VERSION);
			//script
			wp_enqueue_script( 'select_post',OLTHEME_ASSET.'/js/select-post.js',[], APP_VERSION, true);		
	}
	public function SearchNewPost(){
	    global $post;
	    header('Content-Type:text/html');
	    $post_type = (empty($_GET['post_type']))? 'post': $_GET['post_type'];
	    $page_num = (empty($_GET['paged']))? 1 : $_GET['paged'];
	    $per_page = (empty($_GET['posts_per_page']))? 1 : $_GET['posts_per_page'];
	    $title = (empty($_GET['key']))? '' : $_GET['key'];
	    $args = array(
	        'post_type'=>$post_type,
	        'paged'=>$page_num,
	        'posts_per_page'=>$per_page,
	        's'=>esc_attr($title)
	        );
	    $news = get_posts($args);
	    if(!empty($news)){  
	    	$out = '';  
	        foreach ( $news as $post ) : setup_postdata( $post );        
		        $title = wp_trim_words(get_the_title(),5,'...');
		        $out .= '<div class="ite-post" data-id="'.get_the_ID().'" data-title="'.$title.'">';
		        $out .= '<p>'.$title.'</p>';
		        $out .= '</div>';
	        endforeach;
	        echo $out;
	    }else{
	        echo false;        
	    }   
	    wp_reset_postdata();
	    wp_die();        
	}	
	public function getNewPost(){
	    global $post;
	    header('Content-Type:text/html');
	    $post_type = (empty($_GET['post_type']))? 'post' : $_GET['post_type'];
	    $page_num = (empty($_GET['paged']))? 1 : (int)$_GET['paged'];
	    $per_page = (empty($_GET['posts_per_page']))? 1 : (int)$_GET['posts_per_page'];
	    $args = array(
	        'post_type'=>$post_type,
	        'paged'=>$page_num,
	        'post_status'=>'publish',
	        'posts_per_page'=>$per_page
	        );
	    $news = get_posts($args);
	    $out='';
	    if(!empty($news)){    
	        foreach ( $news as $post ) : setup_postdata( $post );        
	        $title = wp_trim_words(get_the_title(),5,'...');
	        $out .= '<div class="ite-post" data-id="'.get_the_ID().'" data-title="'.$title.'">';
	        $out .= '<p>'.$title.'</p>';
	        $out .= '</div>';
	        endforeach;
	        echo $out;
	    }else{
	        echo false;        
	    }   
	    wp_reset_postdata();
	    wp_die();        
	}
	public function addAdminFooter(){
		ob_start();
		include(OLTHEME_TEMPLATE . '/posts/popup-post.php');
		$out = ob_get_clean();
		echo $out;
		return;
	}
	//store
	public function getPostCat(){
	    global $post;
	    header('Content-Type:text/html');
	    $post_type = (empty($_GET['post_type']))? 'post' : sanitize_text_field($_GET['post_type']);
	    $page_num = (empty($_GET['paged']))? 1 : $_GET['paged'];
	    $per_page = (empty($_GET['posts_per_page']))? 1 : $_GET['posts_per_page'];
	    $cat = (empty($_GET['cat']))? 0 : (int)$_GET['cat'];
	    $args = array(
	        'post_type'=>$post_type,
	        'paged'=>$page_num,
	        'post_status'=>'publish',
	        'posts_per_page'=>$per_page
	        );
	    if(!empty($cat)){
	    	$args['cat'] = $cat;
	    }
	    $news = get_posts($args);
	    if(!empty($news)){    
	        foreach ( $news as $k_post=>$post ) : setup_postdata( $post );        
				if($k_post === 0):
					get_template_part('partials/content-post-light');
				else:	
					get_template_part('partials/content-post-cate');
				endif; 
	        endforeach;
	    }else{
	        echo false;        
	    }   
	    wp_reset_postdata();
	    wp_die();        
	}	
}
