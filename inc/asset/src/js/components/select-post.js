$.fn.olSelectPostMulti = function(opts){
    var sets = $.extend({},$.fn.olSelectPostMulti.defaults,opts);
    return this.each(function(){
        var $element = $(this);
        var mod = (function(){
            var m_out = {};
            var $popup,$popup_ct,$ol_result,$ol_add;
            var $body,$form;            
            m_out.init = function(){
                $body = $('body');
                $popup = $(sets.popup_id);
                $popup_ct = $(sets.popup_id+'-ct');
                $ol_add = $element.find('.ol-sel_post-add:first');
                $ol_result = $element.find('.ol-sel_post-results:first');
                if(sets.sort){
                    $ol_result.sortable({
                        tolerance  : 'pointer'
                    });                     
                }                 
                listend();
            }
            var listend = function(){
                    $ol_add.on('click',handleAdd);
                    $body.on(sets.event_popup_select,handleSelect);
                    $body.on(sets.event_popup_close,hide_popup);
                    $element.on('click','.item-del',handleDel);            
            }
            var handleDel = function(ev){
                ev.preventDefault();
                $(this).parent('.item').remove();
                return true;
            }
            var handleSelect = function(ev,res){
                ev.preventDefault();
                if(!$element.hasClass('active')){ return false;}
                var ele_html = getElementHtml(res);
                $ol_result.append(ele_html);
                return true;
            }
            var getElementHtml = function(item){
                var out='';
                out += '<div class="item">';
                out += '<input type="hidden" name="'+sets.input_name+'[]" value="'+item.id+'"/>';
                out += '<p class="item-txt">'+item['title']+'</p>';
                out += '<span class="item-del"><span class="dashicons dashicons-no"></span></span>';
                out += '</div>';
                return out;
            }
            var handleAdd = function(ev){
                ev.preventDefault();
                if($element.hasClass('active')){
                    hide_popup();
                }else{
                    show_popup();
                }
                
                return true;
            }
            var hide_popup = function(){
                $element.removeClass('active');
                $popup.fadeOut();
                $body.off('click',listener_close_popup);
            }
            var show_popup = function(){
                $element.addClass('active');
                var pos = $element.position();
                var top = pos.top + $element.height();
                var left = $element.offset().left;
                $popup_ct.css({
                    width:$element.width() + 'px',
                    top : top + 'px',
                    left : left + 'px',
                });
                $popup.fadeIn();
                //$body.on('click',listener_close_popup);
                return true;
            }
            var listener_close_popup = function(ev){
                var $ele = $(ev.target);
                    if($ele.hasClass('ol-add')){ return false;}
                    var $el_check = $ele.closest(sets.popup_id+'-ct');
                    if($el_check.length > 0){ return false;}
                    hide_popup();                       
                    return true;
            }            
            return m_out;
        })();
        return mod.init();
    });
}
$.fn.olSelectPostMulti.defaults = {
    sort : true,
    input_name : 'posts',
    popup_id : '#olpop-posts',
    event_popup_select : 'ol_select_post',
    event_popup_close : 'ol_select_post_close',    
};  
$.fn.ol_select_post = function(opts){
        var sets = $.extend({},$.fn.ol_select_post.defaults,opts);
        return this.each(function(){
            var $element = $(this);
            var mod = (function(){
                var m_out={};
                var $popup,$popup_ct,$ol_result,$ol_sv,$ol_add,$ol_del;
                var $body,$form;
                m_out.init = function(){
                    $body = $('body');
                    $popup = $(sets.popup_id);
                    $popup_ct = $(sets.popup_id+'-ct');
                    $ol_add = $element.find('.ol-add');
                    $ol_del = $element.find('.ol-del');
                    $ol_result = $element.find('.result');
                    $ol_sv = $element.find('.ol-sv');                   
                    listend();
                } 
                var listend = function(){
                    $ol_add.on('click',handleAdd);
                    $ol_del.on('click',handleDel);
                    $body.on(sets.event_popup_select,handleSelect);
                    $body.on(sets.event_popup_close,hide_popup);
                }
                var handleDel = function(ev){
                    ev.preventDefault();
                    $ol_sv.val('');
                    $ol_result.html('');
                    return true;
                }
                var handleSelect = function(ev,res){
                    ev.preventDefault();
                    if(!$element.hasClass('active')){ return false;}
                    $ol_result.html(res.title);
                    $ol_sv.val(res.id);
                    $ol_sv.trigger('change');
                    return true;
                }
                var handleAdd = function(ev){
                    ev.preventDefault();
                    if($element.hasClass('active')){
                        hide_popup();
                    }else{
                        show_popup();
                    }
                    
                    return true;
                }
                var hide_popup = function(){
                    $element.removeClass('active');
                    $popup.fadeOut();
                    $body.off('click',listener_close_popup);
                }
                var show_popup = function(){
                    $element.addClass('active');
                    var pos = $element.position();
                    var top = pos.top + $element.height() + 90;
                    $popup_ct.css({
                        width:$element.width() + 'px',
                        top : top + 'px',
                        left : '26px',
                    });
                    $popup.fadeIn();
                    $body.on('click',listener_close_popup);
                    return true;
                }
                var listener_close_popup = function(ev){
                    var $ele = $(ev.target);
                        if($ele.hasClass('ol-add')){ return false;}
                        var $el_check = $ele.closest(sets.popup_id+'-ct');
                        if($el_check.length > 0){ return false;}
                        hide_popup();                       
                        return true;
                }
                var is_null = function(dt){
                    if(typeof dt === 'undefined' || dt === null || dt.trim()== ''){
                        return true;
                    }
                    return false;
                }            
                return m_out;            
            })();
            return mod.init();
        });
    }
$.fn.ol_select_post.defaults = {
    popup_id : '#olpop-posts',
    event_popup_select : 'ol_select_post',
    event_popup_close : 'ol_select_post_close',
};            
$.fn.ol_select_post_popup = function(opts){
    var sets = $.extend({},$.fn.ol_select_post_popup.defaults,opts);
    return this.each(function(){
        var $element = $(this);
        var mod = (function(){
            var m_out={};
            var $body,$oltb_lnk,$oltb_tab,$ol_key,$ol_sea;
            var $overlay;
            var doing_loading = false;
            m_out.init = function(){
                $body = $('body');
                $oltb_lnk = $element.find('.olpop-lnk');
                $oltb_tab = $element.find('.olpop-tab-ct');
                $ol_key = $element.find('.olpop-key');
                $ol_sea = $element.find('.olpop-find');
                $overlay = $element.children('.olpop-overlay');
                listend();
            } 
            var listend = function(){
                $element.on('click','.ite-post',handleAdd);
                $element.on('click','.olpop-close',handleClose);
                $overlay.on('click',handleClose);
                $element.on('click','.olpop-more',loadmore_posts);
                $ol_sea.on('click',search_posts);
                $oltb_lnk.on('click',handleTab);
            }
            var handleTab = function(ev){
                ev.preventDefault();
                var $ele = $(this);
                var $block = $($ele.attr('href'));
                $oltb_lnk.removeClass('active');
                $oltb_tab.removeClass('active');
                $ele.addClass('active');
                $block.addClass('active');
                return true;
            }
            var search_posts = function(ev){
                ev.preventDefault();
                var key = $ol_key.val();
                if(is_null(key)){
                    alert('pleased,enter keyword !');
                    return false;
                }
                if (doing_loading) {
                    return false;
                }   
                doing_loading = true;  
                var dt = search_query_string(key);
                $ol_sea.addClass('waiting');
                $.ajax({
                    url: ajaxurl,
                    type: 'GET',
                    data: dt,
                    processData: false
                }).done(function(res){
                    var $wrap = $ol_sea.closest('.olpop-tab-ct');
                    $wrap.find('.lst-posts').append(res);
                    return true;
                }).fail(function() {
                    console.log("error");
                }).always(function() {
                    $ol_sea.removeClass('waiting');
                    doing_loading = false;
                });             
                return true;
            }
            var loadmore_posts = function(ev) {
                ev.preventDefault();
                var $ele = $(this);
                if (doing_loading) {
                    return false;
                }
                doing_loading = true;
                update_current_page($ele);
                var dt = build_query_string($ele);
                $ele.addClass('waiting');
                $.ajax({
                    url: ajaxurl,
                    type: 'GET',
                    data: dt,
                    processData: false
                }).done(function(res){
                    var $wrap = $ele.closest('.olpop-tab-ct');
                    $wrap.find('.lst-posts').append(res);
                    return true;
                }).fail(function() {
                    console.log("error");
                }).always(function() {
                    $ele.removeClass('waiting');
                    check_end_paginate($ele);
                    doing_loading = false;
                });
            } 
            var check_end_paginate = function($ele) {
                var cur = $ele.attr('data-current');
                var post_tt = $ele.attr('data-total');
                if (cur >= post_tt) {
                    $ele.remove();
                    return false;
                }
                return false;
            } 
            var search_query_string = function(key) {
                var out = '';
                var next = 1;
                var ld_query = $ol_sea.data('query');
                var action = $ol_sea.data('action');
                out += ld_query + '&key=' + key + '&action=' + action + '&paged=' + next;
                return out;
            }                       
            var build_query_string = function($ele) {
                var out = '';
                var next = parseInt($ele.attr('data-current'));
                var ld_query = $ele.data('query');
                var action = $ele.data('action');
                out += ld_query + '&action=' + action + '&paged=' + next;
                return out;
            }
            var update_current_page = function($ele) {
                var next = parseInt($ele.attr('data-current')) + 1;
                $ele.attr({
                    'data-current': next
                });
                return true;
            }                       
            var handleClose = function(ev){
                ev.preventDefault();
                $body.trigger(sets.event_popup_close);
                return true;
            }
            var handleAdd = function(ev){
                ev.preventDefault();
                var $ele = $(this);
                var dt = $ele.data();
                $body.trigger(sets.event_popup_select,dt);
                return true;
            }
            var is_null = function(dt){
                if(typeof dt === 'undefined' || dt === null || dt.trim()== ''){
                    return true;
                }
                return false;
            }            
            return m_out;            
        })();
        return mod.init();
    });
}
$.fn.ol_select_post_popup.defaults = {
    event_popup_select : 'ol_select_post',
    event_popup_close : 'ol_select_post_close',    
};
$.fn.ol_slider_post = function(opts){
    var sets = $.extend({},$.fn.ol_slider_post.defaults,opts);
    return this.each(function(){
        var $element = $(this);
        var mod = (function(){
            var m_out={};
            var $ol_add,$ol_results;
            var pattern;
            m_out.init = function(){
                $ol_add = $element.find('.sl-add');
                $ol_results = $element.find('.sl-results');
                pattern = $element.find('.pattern').html();
                listend();
            } 
            var listend = function(){
                $ol_add.on('click',handleAdd);
            }
            var handleAdd = function(ev){
                ev.preventDefault();
                $ol_results.append(pattern);
                active_element();
                return true;
            }
            var active_element = function(){
                $ol_results.children(':last').ol_select_post();
            }
            var is_null = function(dt){
                if(typeof dt === 'undefined' || dt === null || dt.trim()== ''){
                    return true;
                }
                return false;
            }            
            return m_out;            
        })();
        return mod.init();
    });
}
$.fn.ol_slider_post.defaults = {
};