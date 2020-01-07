$.fn.happy_multiple_input = function(args){
	var $setts = $.extend({},$.fn.happy_multiple_input.defaults,args);		
	return this.each(function(){
		var $element = $(this);
		var mod = (function(){
			var $inp_save,$block,$form;
			var init = function(){
				$inp_save = $element.find('.inp-add');
				$block = $element.find('.inp-wrap');
				$form = $element.closest('form');
				listend();
			}
			var listend =function(){
				$form.on('submit',function(evt){
					//evt.preventDefault();
					var inp_val = save_input();
					$inp_save.val(inp_val);
					//console.log(inp_val);
					return true;
				});
			}
			var save_input = function(){
			      var output = '';
			      if($block.length == 0 ){ return output ;}
			      var out_ar = {};
			      var $inp_list = $block.find('input');
			      if($inp_list.length > 0){
			        $inp_list.each(function(){
			          var $ele = $(this);
			          var name = $ele.attr('name');
			          var val = $ele.val();
			          out_ar[name]=val;          
			        });
			      }
			      var $area_list = $block.find('textarea');
			       $area_list.each(function(){
			          var $ele = $(this);
			          var name = $ele.attr('name');
			          var val = $ele.val();
			          out_ar[name]=val;
			      });    
			      output = JSON.stringify(out_ar);
			      return output; 
			}
			return {
				init: init
			}
		})();
		return mod.init();
	});
}
$.fn.happy_multiple_input.defaults={
}	
$.fn.only_save_inputs = function(opts){
	var setts = $.extend({},$.fn.only_save_inputs.defaults,opts);
	return this.each(function(){
		var $element = $(this);
		var mod = (function(){
			var $inp_save,$block,$form;
			var init = function(){
				$inp_save = $element.find('.inp-add');
				$block = $element.find('.inp-wrap');
				$form = $element.closest('form');
				listend();
			}
			var listend =function(){
				$form.on('submit',function(evt){
					//evt.preventDefault();
					var inp_val = save_input();
					$inp_save.val(inp_val);
					//console.log(inp_val);
					return true;
				});
			}
			var save_input = function(){
			      var output = '';
			      if($block.length == 0 ){ return output ;}
			      var out_ar = [];
			      var $inp_ele = $block.find('.inp-element');
			      if($inp_ele.length == 0){ return '';}
			      $inp_ele.each(function(ite){
			      	var $ele = $(this);
			      	var val_ele = save_element($ele);
			      	out_ar.push(val_ele);
			      });   
			      output = JSON.stringify(out_ar);
			      return output; 
			}
			var save_element = function($ele){
				var out_ar = {}	;
				var $inp_list = $ele.find('input');
				if($inp_list.length > 0){
				$inp_list.each(function(){
				  var $ele = $(this);
				  var name = $ele.attr('name');
				  var val = $ele.val();
				  out_ar[name]=val;          
				});
				}
				var $area_list = $ele.find('textarea');
				$area_list.each(function(){
				  var $ele = $(this);
				  var name = $ele.attr('name');
				  var val = $ele.val();
				  out_ar[name]=val;
				});    
				return out_ar;					
			}
			return {
				init : init
			}
		})();
		return mod.init();
	});
}	
$.fn.only_save_inputs.defaults = {
}