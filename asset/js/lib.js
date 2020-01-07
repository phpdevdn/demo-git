var olGlobal = (function(){
    var mod = {};
    mod.isNull = function(dt){
        if(typeof dt === 'undefined' || dt===null || dt.trim()==''){
            return true;
        }
        return false;
    }
    mod.isMobile = function(){
        return navigator.userAgent.match(/Android|IEMobile|BlackBerry|iPhone|iPad|iPod|Opera Mini/i);
    }
    return mod;
})();
var ol_lazy_background = (function(){
    var mod={};
    var bg_lazyload = document.querySelectorAll('.bg-lazyload');
    var w_wind = window.outerWidth;
    mod.init = function(){
        if(bg_lazyload.length === 0){ return false;}
        set_background();
        listend();
    }
    var listend = function(){
        window.addEventListener('resize',handleResize);
    }
    var handleResize = function(){
        w_wind = window.outerWidth;
        set_background();
        return true;
    }
    var set_background = function(){
        var img_url,ite,img_pc;
        for(var i=0;i<bg_lazyload.length;i++){
            ite = bg_lazyload[i];   
            img_url = false;         
            img_pc = ite.getAttribute('data-pcimg');
            if(!img_pc){
                return false;
            }
            if(w_wind < 768){
                img_url = ite.getAttribute('data-xsimg');
            }else if(w_wind < 1025){
                img_url = ite.getAttribute('data-smimg');
            }
            img_url = (img_url) ? img_url : img_pc;   
            requestImage(ite,img_url);           
        }       
    }
    var requestImage = function(ele,link){
        var request = new XMLHttpRequest();
        request.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                    //return false;
                    ele.style.backgroundImage =  'url("'+link+'")';
                    ele.classList.add("ready");                                    
            }
        }
        request.open('Get', link);
        request.send();
    }    
    return mod;
})();
(function($){
var $_window = $(window);	
//toggle-script
$.fn.olToggle = function(opts){
    var sets = $.extend({},$.fn.olToggle.defaults,opts);
    return this.each(function(){
        var $element = $(this);
        var mod = (function(){
            var m_out = {};
            var cr_block,$cr_block;
            m_out.init = function(){
                listend();
            }
            var listend = function(){
                if(sets.input){
                    $element.on('change',tog_block_cbox);
                }else{
                    $element.on('click',tog_block);
                }
                return true;
            }
            var tog_block_cbox = function(ev){
                display_block($(this));
            }
            var tog_block = function(ev){
                ev.preventDefault();
                display_block($(this));
                return true;
            }
            var display_block = function($ele){
                cr_block = $ele.attr('data-block');
                if(!cr_block){ return false;}
                $cr_block = $(cr_block);
                if($cr_block.length == 0){ return false;}
                $ele.toggleClass('active');
                if(sets.slide){
                    $cr_block.slideToggle();
                }
                $cr_block.toggleClass('active');                     
            }
            return m_out;
        })();
        return mod.init();
    });
}
$.fn.olToggle.defaults = {
    slide : false,
    input : false,
};  
//end-toggle-script
//list-script   
$.fn.olList = function(opts){
    var sets = $.extend({},$.fn.olList.defaults,opts);
    return this.each(function(){
        var $element = $(this);
        var mod = (function(){
            var m_out = {};
            var $sub_bt,$sub_bl;
            m_out.init = function(){
                listend();
            }
            var listend = function(){
                $element.on('click','.lst-bt',buttonCallback);
            }
            var buttonCallback = function(ev){
                ev.preventDefault();
                var $ele = $(this);
                var $ele_par = $ele.closest('li');
                if(!$ele.hasClass('active')){
                    var $ele_act = $element.find('.lst-bt.active');
                    if($ele_act.length > 0){
                        var $par_act = $ele_act.closest('li');
                        toggleBlock($par_act);
                    }
                }
                toggleBlock($ele_par);
                return true;
            }
            var toggleBlock = function($ele){
                if($ele.length == 0){ return false;}
                $ele.find('.lst-bt').toggleClass('active');
                $ele.find('.lst-sub').toggleClass('active').slideToggle();
                return true;
            }
            return m_out;
        })();
        return mod.init();
    });
}
$.fn.olList.defaults = {
};       
//end-list-script
$.fn.olAnchor = function(opts){
  var sets = $.extend({},$.fn.olAnchor.defaults,opts);
  return this.each(function(){
      var $element = $(this);
      var mod = (function(){
        var m_out={};
        m_out.init = function(){
            listend();
        } 
        var listend = function(){
            $element.on('click',scroll_block);  
        }
        var scroll_block = function(ev){
            var block = $element.attr('href');
            if(block.match(/#|#top/)){ return true;}
            var $block = $(block);
            if($block.length == 0){ return false;}
            var pos = $block.offset().top;
            $('body,html').stop().animate({
                scrollTop : pos,
            });
            return true;
        }             
        return m_out;            
      })();
      return mod.init();
});
}
$.fn.olAnchor.defaults = {
}; 
//scroll-script
$.fn.olScroll = function(opts){
    var sets = $.extend({},$.fn.olScroll.defaults,opts);
    return this.each(function(){
    var $element = $(this);
    var mod = (function(){
        var exp = {};
        var $bl_start,$_window;
        var pos_start;
        exp.init = function(){
            var bl_start = $element.attr('data-start'); 
            if(olGlobal.isNull(bl_start)){ return false;}
            $bl_start = $(bl_start);
            if($bl_start.length == 0 ){ return false;}
            get_variable();
            check_position();
            listend();
        }
        var listend = function(){
            $_window.on('scroll',check_position);
            $_window.on('resize',get_variable);
        }
        var check_position = function(){
            var top_scl = $_window.scrollTop();
            if(top_scl > pos_start){
                $element.addClass('fixed');
            }else{
                $element.removeClass('fixed');
            }
            return true;
        }
        var get_variable = function(){
            pos_start = $bl_start.offset().top;                
        }
        return exp;
    })();
    return mod.init();
});
}
$.fn.olScroll.defaults = {
} 
})(jQuery);