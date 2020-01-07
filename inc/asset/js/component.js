(function($){
var $_window;	
$.fn.olImage = function(opts){
	var setts = $.extend({},$.fn.olImage.defaults,opts);
	return this.each(function(){
		var $element = $(this);
		var mod = (function(){
			var $inp_sv,$image,$img_del,$img_add;
			var frame;
			var init = function(){
				$inp_sv = $element.find('.inp-sv');
				$image = $element.find('.image');
				$img_del = $element.find('.del-img');
				$img_add = $element.find('.add-img');
				listend();
			}
			var listend = function(){
				$img_add.on('click',add_image);
				$img_del.on('click',del_image);
			}
			var add_image = function(evt){
			    evt.preventDefault();        
			    frame = wp.media({
			      title: 'Lựa chọn hoặc tải lên',
			      button: {
			        text: 'Chọn'
			      },
			      library:{
			        type:'image',
			      },
			      multiple: false  // Set to true to allow multiple files to be selected
			    });    
			    frame.on( 'select', function() {     
			      var attachment = frame.state().get('selection').first().toJSON();
			      save_image(attachment);
			    });
			    frame.open();					
			}
			var save_image = function(attach){
				if($inp_sv.attr('data-size')){
					var type = $inp_sv.attr('data-size');
					var type_img = (attach.sizes[type]) ? attach.sizes[type].url : attach.url ;
					$inp_sv.val(type_img);
				}else if($inp_sv.attr('data-type') && $inp_sv.attr('data-type')=='id'){
					$inp_sv.val(attach.id);
				}else{
					$inp_sv.val(attach.url);
				}
				var link = (attach.sizes['thumbnail']) ? attach.sizes['thumbnail'].url : attach.url;
				$image.attr({'src':link});
				$img_del.fadeIn();
				return true;
			}
			var del_image = function(evt){
				evt.preventDefault();
				$(this).fadeOut();
				$inp_sv.val('');
				$image.attr({'src':''});
				return true;
			}
			return {
				init : init
			}
		})();
		return mod.init();
	});
}	
$.fn.olImage.defaults = {
}
$.fn.olImageMulti = function(opts){
	var setts = $.extend({},$.fn.olImageMulti.defaults,opts);
	return this.each(function(){
		var $element = $(this);
		var mod = (function(){
			var $button,$block;
			var frame,types;
			var init = function(){
				$button = $element.find('.but-image:first');
				$block = $element.find('.image-bl:first');
				types=setts.size;
				if(setts.sort){
					$block.sortable({
						tolerance  : 'pointer'
					});						
				}
				listend();
			}
			var listend = function(){
				$button.on('click',button_func);
				if(setts.delete){
					$element.on('click','.del-ite',function(evt){
						evt.preventDefault();
						$(this).closest('.item').remove();
						return true;
					})
				}
				if(setts.input){
					$element.on('change','.inp-txt',function(evt){
						var $ele = $(this);
						var el_val = $ele.val();
						$ele.closest('.item').attr({'data-text':el_val});
						return true;
					});
				}
			}
			var button_func = function(evt){
			    evt.preventDefault();
			    $ele = $(this);
			    if ( frame ) {
			      frame.open();
			      return;
			    }
			    frame = wp.media({
			      title: 'Select or Upload Media',
			      button: {
			        text: 'Use this media'
			      },
			      size:"thumbnail",
			      multiple: true  // Set to true to allow multiple files to be selected
			    });
			    frame.on( 'select', function() {
			      var attachs = frame.state().get('selection').toJSON();
			      if(attachs.length == 0){ return false;}
			      attachs.forEach(function(val){
			      	var thumb_url,val_tp;
		      		thumb_url = (val.sizes[types]) ? val.sizes[types].url : val.url ;
		      		val_tp = thumb_url;
		      		var name_image = setts.input ? setts.input_name + '[image]' : setts.input_name;				      	
					var ite = '';
					ite += '<li class="item">';
					ite += '<input type="hidden" name="'+name_image+'[]" value="'+val.id+'">';
					ite += '<img class="img-ite" src="'+thumb_url+'">';
					if(setts.input){
						ite += '<input type="text" name="'+setts.input_name+'[text][]" class="inp-txt">';
					}
					ite += '<span class="del-ite"><span class="dashicons dashicons-no"></span></span>';
					ite += '</li>';
					$block.append(ite);				      	     
			      });
			    });
			      frame.open();
			}				
			return {
				init : init
			}
		})();
		return mod.init();
	});
}			
$.fn.olImageMulti.defaults = {
	size : 'thumbnail',
	sort : false,
	delete : false,
	input : false,
	input_name : 'images'
}
$(function(){
	$_window = $(window);
});
})(jQuery);