(function($){
    var OlTheme = (function(){
        var mod = {};
        mod.navBar = function($nav_opt){
            var $ct_opt = $('.content-opt');
            if($nav_opt.length > 0 && $ct_opt.length > 0){
                $nav_opt.on('click',function(evt){
                  evt.preventDefault();
                  var ele = evt.target;
                  var $ele = $(ele);
                  var id_opt = $ele.attr('href');
                  var $act_ct = $(id_opt);
                  if(id_opt == undefined || $act_ct.length == 0){ return;}
                  $nav_opt.find('a').removeClass('active');
                  $ele.addClass('active');
                  $ct_opt.removeClass('active');
                  $act_ct.addClass('active');
                })
            }
        }
        return mod;
    })();
    $(function(){
        OlTheme.navBar($('.nav_opt'));
    })
})(jQuery);