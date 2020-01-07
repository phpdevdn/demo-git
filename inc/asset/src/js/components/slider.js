	$.fn.only_textarea_tiny = function(opts){
        var sets = $.extend({},$.fn.only_textarea_tiny.defaults,opts);
        return this.each(function(){
            var $element = $(this);
            var mod = (function(){
            	var $pop_tiny,id_tiny,$tiny;
            	var init = function(){
            		$pop_tiny = $('#pop-tiny');
            		if(!tinymce){ return false;}
            		init_tinymce();
            		listend();
            	}
            	var init_tinymce = function(){
            		var args = {
						  selector: '#slider-tiny',
						  height: 300,
						  theme: 'modern',
						  menubar: false,
							plugins:"charmap,colorpicker,lists,paste,tabfocus,textcolor,fullscreen,wordpress,wpautoresize,wpeditimage,wpemoji,wpgallery,wplink,wpdialogs,wptextpattern,wpview,wpembed"
							,toolbar1:"formatselect,fontsizeselect,forecolor,bold,italic,alignleft,aligncenter,alignright,undo,redo,fullscreen"						  
							,fontsize_formats:"8px 10px 12px 14px 16px 20px 24px 28px 32px 36px 48px 60px 72px 96px"
            		}
            		tinymce.init(args);
            	}
            	var listend = function(){
            		$element.on('click','.tiny-edit',open_tiny);
            		$pop_tiny.on('click','.cls-pop',close_tiny)
            		$pop_tiny.on('click','.cls-save',save_tiny)
            	}
            	var open_tiny = function(evt){
            		evt.preventDefault();
            		$ele = $(this);
            		$ele.parent().addClass('active-tiny');
            		var $content = $ele.siblings('.tiny-ct');
            		var content = $content.html();
            		tinymce.get('slider-tiny').setContent(content);
            		$pop_tiny.addClass('active');
            		return true;
            	}
            	var close_tiny = function(evt){
            		evt.preventDefault();
            		$pop_tiny.removeClass('active');
            		$element.find('.bl-tiny').removeClass('active-tiny');
            		return true;
            	}
            	var save_tiny = function(evt){
            		evt.preventDefault();            		
            		var content =tinymce.get('slider-tiny').getContent();
            		$pop_tiny.removeClass('active');
            		var $wrap = $element.find('.active-tiny');
            		$wrap.find('.tiny-ct').html(content);
            		$wrap.find('.area-tiny').val(content);
            		$element.find('.bl-tiny').removeClass('active-tiny');
            		return true;            		
            	}
            	var get_content = function(){}
            	return {
            		init : init
            	}
            })();
            return mod.init();
        });    
	}
	$.fn.only_textarea_tiny.defaults = {
		id_pop : ''
	}
	$.fn.only_slider_setting = function(opts){
        var sets = $.extend({},$.fn.only_slider_setting.defaults,opts);
        return this.each(function(){
            var $slider = $(this);
            var mod = (function(){
				var $form,
					$sl_blk,
					$sl_ites,
					$sl_opt,
					$sl_add;
				var sl_frame,img_clk,id_clk;
				var init=function(){
					$form=$slider.closest('form'),
					$sl_blk=$slider.find('.slide-block'),
					$sl_ites=$slider.find('.slide-ites'),
					$sl_opt=$sl_blk.find('.slide-opt'),
					$sl_add=$sl_blk.find('.slide-butt');					
					$sl_ites.sortable();
					listend();
				}				
				var sl_fr=function(){
					var $fr_blk=$("<div></div>").addClass('slide-fr');
					var $del=$('<span></span>').addClass('fr-del').text('x');
					var $img=$("<img>").attr({ 'src':'','width':'100px','height':'100px','alt':'','class':'fr-img'});
					if(sets.background){
					var text = 	'<p>Hình nền</p>';
					var $img_bg=$("<img>").attr({ 'src':'','width':'100px','height':'100px','alt':'','class':'fr-img fr-bg'});	
					var $input_bg=$("<input>").attr({ 'type':'hidden','class':'fr-img-bg','value':'','data-size':'happy_slider'});
					}
					var $input=$("<input>").attr({ 'type':'hidden','class':'fr-img-id','value':''});
					var $url=inp_group('post url','fr-url');
					var $title=inp_group('title','fr-title');
					var $desc=inp_group('description','fr-desc','textarea');
					var $bl_img = $('<div></div>').addClass('bl-img');
					if(sets.background){
						$bl_img.append($img,text,$img_bg,$input_bg,$input);
					}else{
						$bl_img.append($img,$input);						
					}
	 				$fr_blk.append($del,$bl_img,$url,$title,$desc);
					return $fr_blk
				}
				var sl_fr_tiny=function(){
					var $fr_blk=$("<div></div>").addClass('slide-fr');
					var tog='<span class="fr-cll dashicons dashicons-arrow-up-alt2"></span>';
					var $del=$('<span></span>').addClass('fr-del').text('x');
					var $img=$("<img>").attr({ 'src':'','width':'100px','height':'100px','alt':'','class':'fr-img'});
					var $input=$("<input>").attr({ 'type':'hidden','class':'fr-img-id','value':''});
					var $url=inp_group('post url','fr-url');
					var $title=inp_group('title','fr-title');
					var $desc=inp_group_tiny('description','fr-desc');
					var $bl_img = $('<div></div>').addClass('bl-img');
					$bl_img.append($img,$input);
	 				$fr_blk.append(tog,$del,$bl_img,$url,$title,$desc);
					return $fr_blk
				}
				var inp_group_tiny=function(text_lb,cl_inp){
					var $blk=$('<div></div>').addClass('input-gr');
					var $label=$('<label></label>').text(text_lb);
					var bl_tiny = '<div class="bl-tiny">';
						bl_tiny += '<span class="tiny-edit button">edit</span>';
						bl_tiny += '<div class="tiny-ct"></div>';
						bl_tiny += '<textarea class="fr-desc area-tiny" rows="2"></textarea>';
						bl_tiny += '</div>';
					$blk.append($label,bl_tiny);
					return $blk ;
				}
				var inp_group=function(text_lb,cl_inp,form){
					var $blk=$('<div></div>').addClass('input-gr');
					var $label=$('<label></label>').text(text_lb);
					if(form=='textarea'){
							var $input=$('<textarea></textarea>').attr({ 'class':cl_inp, 'rows':2});
					} else{
							var $input=$('<input>').attr({ 'type':'text', 'class':cl_inp, 'value':''});
					}
					$blk.append($label,$input);
					return $blk ;
				}
				var add_image=function(evt){
					$img_clk=$(evt.target);
						
					if($img_clk.hasClass('fr-bg')){
						$id_clk=$img_clk.siblings('.fr-img-bg');
					}else{
						$id_clk=$img_clk.siblings('.fr-img-id');
					}
					
	   			    if ( sl_frame ) {
				      sl_frame.open();
				      return;
				    }
				    sl_frame = wp.media({
					      title: 'Select or Upload slide image',
					      button: {
					        text: 'Use this image'
					      },
					      multiple: false  
				    });
					sl_frame.on( 'select',function(){
						var attachment = sl_frame.state().get('selection').first().toJSON();
	 					$img_clk.attr({'src':attachment.url});
	 					if(sets.url){
	 						var type = ($id_clk.attr('data-size')) ? $id_clk.attr('data-size') : sets.url ;
	 						var thumb_url = (attachment.sizes[type]) ? attachment.sizes[type].url : attachment.url ;
	 						$id_clk.attr({'value':thumb_url});
	 					}else{
	 						$id_clk.attr({'value':attachment.id});
	 					}
						
					});
					sl_frame.open();
				}
				var listend=function(){
					$sl_add.on('click',function(evt){
						evt.preventDefault();
						var bl_html;
						if(sets.tiny){
							bl_html = sl_fr_tiny();
						}else{
							bl_html = sl_fr()
						}
						$sl_ites.append(bl_html);
						return true;
					});
					$sl_blk.on('click','.fr-img',add_image);
					$sl_blk.on('click','.fr-del',function(){
						var $blk=$(this).parent();
						$blk.remove();
					});
					$sl_blk.on('click','.fr-cll',function(evt){
						evt.preventDefault();
						var $ele = $(this);
						$ele.toggleClass('active');
						$ele.siblings('.gr-cll').slideToggle();
						return true;
					});
					$form.submit(function(event) {
						//event.preventDefault();
	 					if($('.slide-fr').length > 0){
								var opt_arr=[];
								var $slide_fr=$slider.find('.slide-fr');
								$slide_fr.each(function(){
									var $ele = $(this);
									var slide_dt={
										'id':$ele.find('.fr-img-id').val(),
										'url':$ele.find('.fr-url').val(),
										'title':$ele.find('.fr-title').val(),
										'desc':$ele.find('.fr-desc').val()
									}
									if(sets.background){
										slide_dt.background = $ele.find('.fr-img-bg').val();
									}
									opt_arr.push(slide_dt);
								});
								$sl_opt.val(JSON.stringify(opt_arr));
						} else{
							$sl_opt.val('');
						}
	 					//console.log($sl_opt.val());
	 					return true;
					});

				}
            	return {
            		init : init
            	}
            })();
            return mod.init();
        });    
	}	
	$.fn.only_slider_setting.defaults={
		background : false,
		url :false,
		tiny : false
	}