var stack_bottomleft = {"dir1": "right", "dir2": "up"};
var tooltip;
var AD  =   "'";

function show_stack_bottomleft(err, titulo, mensagem) {
        var opts = {
                pnotify_title: titulo,
                pnotify_text: mensagem,
                pnotify_addclass: "stack-bottomleft",
                pnotify_stack: stack_bottomleft
        };
        if (err) {
                opts.pnotify_title = titulo;
                opts.pnotify_text = mensagem;
                opts.pnotify_type = "error";
        }
        $.pnotify(opts);
};

/*
Caixa de informação para elementos, para uso: 

Chamar a função:
show_tooltip_alert(title, text);
passando os parametros titulo e texto/mensagem;

Na tag HTML colocar as opções:
onmouseover ="tooltip.pnotify_display();" 
onmousemove ="tooltip.css({'top': event.clientY+12, 'left': event.clientX+12});" 
onmouseout  ="tooltip.pnotify_remove();"
 */
function show_tooltip_alert(title, text, icon){   
   
   var notice_icon;
   
   if (icon)
       notice_icon  =   "ui-icon ui-icon-comment"; //se true inclui icone na msg
   else
       notice_icon  =   "";
    
    tooltip = $.pnotify({
            pnotify_hide            : false,
            pnotify_closer          : false,
            pnotify_history         : false,
            pnotify_animate_speed   : 100,
            pnotify_opacity         : .9,
            pnotify_notice_icon     : notice_icon,
            pnotify_title           : title,
            pnotify_text            : text,
            // Setting stack to false causes Pines Notify to ignore this notice when positioning.
            pnotify_stack: false,
            pnotify_after_init: function(pnotify){
                    // Remove the notice if the user mouses over it.
                    pnotify.mouseout(function(){
                            pnotify.pnotify_remove();
                    });
            },
            pnotify_before_open: function(pnotify){
                    // This prevents the notice from displaying when it's created.
                    pnotify.pnotify({
                            pnotify_before_open: null
                    });
                    return false;
            }
    });   
}