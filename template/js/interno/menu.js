/** jquery.color.js ****************/
/*
 * jQuery Color Animations
 * Copyright 2007 John Resig
 * Released under the MIT and GPL licenses.
 */

(function(jQuery){

    // We override the animation for all of these color styles
    jQuery.each(['backgroundColor', 'borderBottomColor', 'borderLeftColor', 'borderRightColor', 'borderTopColor', 'color', 'outlineColor'], function(i,attr){
        jQuery.fx.step[attr] = function(fx){
            if ( fx.state == 0 ) {
                fx.start = getColor( fx.elem, attr );
                fx.end = getRGB( fx.end );
            }
            if ( fx.start )
                fx.elem.style[attr] = "rgb(" + [
                Math.max(Math.min( parseInt((fx.pos * (fx.end[0] - fx.start[0])) + fx.start[0]), 255), 0),
                Math.max(Math.min( parseInt((fx.pos * (fx.end[1] - fx.start[1])) + fx.start[1]), 255), 0),
                Math.max(Math.min( parseInt((fx.pos * (fx.end[2] - fx.start[2])) + fx.start[2]), 255), 0)
                ].join(",") + ")";
        }
    });

    // Color Conversion functions from highlightFade
    // By Blair Mitchelmore
    // http://jquery.offput.ca/highlightFade/

    // Parse strings looking for color tuples [255,255,255]
    function getRGB(color) {
        var result;

        // Check if we're already dealing with an array of colors
        if ( color && color.constructor == Array && color.length == 3 )
            return color;

        // Look for rgb(num,num,num)
        if (result = /rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(color))
            return [parseInt(result[1]), parseInt(result[2]), parseInt(result[3])];

        // Look for rgb(num%,num%,num%)
        if (result = /rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(color))
            return [parseFloat(result[1])*2.55, parseFloat(result[2])*2.55, parseFloat(result[3])*2.55];

        // Look for #a0b1c2
        if (result = /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(color))
            return [parseInt(result[1],16), parseInt(result[2],16), parseInt(result[3],16)];

        // Look for #fff
        if (result = /#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(color))
            return [parseInt(result[1]+result[1],16), parseInt(result[2]+result[2],16), parseInt(result[3]+result[3],16)];

        // Otherwise, we're most likely dealing with a named color
        return colors[jQuery.trim(color).toLowerCase()];
    }

    function getColor(elem, attr) {
        var color;

        do {
            color = jQuery.curCSS(elem, attr);

            // Keep going until we find an element that has color, or we hit the body
            if ( color != '' && color != 'transparent' || jQuery.nodeName(elem, "body") )
                break;

            attr = "backgroundColor";
        } while ( elem = elem.parentNode );

        return getRGB(color);
    };

    // Some named colors to work with
    // From Interface by Stefan Petre
    // http://interface.eyecon.ro/

    var colors = {
        aqua:[0,255,255],
        azure:[240,255,255],
        beige:[245,245,220],
        black:[0,0,0],
        blue:[0,0,255],
        brown:[165,42,42],
        cyan:[0,255,255],
        darkblue:[0,0,139],
        darkcyan:[0,139,139],
        darkgrey:[169,169,169],
        darkgreen:[0,100,0],
        darkkhaki:[189,183,107],
        darkmagenta:[139,0,139],
        darkolivegreen:[85,107,47],
        darkorange:[255,140,0],
        darkorchid:[153,50,204],
        darkred:[139,0,0],
        darksalmon:[233,150,122],
        darkviolet:[148,0,211],
        fuchsia:[255,0,255],
        gold:[255,215,0],
        green:[0,128,0],
        indigo:[75,0,130],
        khaki:[240,230,140],
        lightblue:[173,216,230],
        lightcyan:[224,255,255],
        lightgreen:[144,238,144],
        lightgrey:[211,211,211],
        lightpink:[255,182,193],
        lightyellow:[255,255,224],
        lime:[0,255,0],
        magenta:[255,0,255],
        maroon:[128,0,0],
        navy:[0,0,128],
        olive:[128,128,0],
        orange:[255,165,0],
        pink:[255,192,203],
        purple:[128,0,128],
        violet:[128,0,128],
        red:[255,0,0],
        silver:[192,192,192],
        white:[255,255,255],
        yellow:[255,255,0]
    };

})(jQuery);

/** jquery.lavalamp.js ****************/
/**
 * LavaLamp - A menu plugin for jQuery with cool hover effects.
 * @requires jQuery v1.1.3.1 or above
 *
 * http://gmarwaha.com/blog/?p=7
 *
 * Copyright (c) 2007 Ganeshji Marwaha (gmarwaha.com)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 * Version: 0.1.0
 */

/**
 * Creates a menu with an unordered list of menu-items. You can either use the CSS that comes with the plugin, or write your own styles
 * to create a personalized effect
 *
 * The HTML markup used to build the menu can be as simple as...
 *
 *       <ul class="lavaLamp">
 *           <li><a href="#">Home</a></li>
 *           <li><a href="#">Plant a tree</a></li>
 *           <li><a href="#">Travel</a></li>
 *           <li><a href="#">Ride an elephant</a></li>
 *       </ul>
 *
 * Once you have included the style sheet that comes with the plugin, you will have to include
 * a reference to jquery library, easing plugin(optional) and the LavaLamp(this) plugin.
 *
 * Use the following snippet to initialize the menu.
 *   $(function() { $(".lavaLamp").lavaLamp({ fx: "backout", speed: 700}) });
 *
 * Thats it. Now you should have a working lavalamp menu.
 *
 * @param an options object - You can specify all the options shown below as an options object param.
 *
 * @option fx - default is "linear"
 * @example
 * $(".lavaLamp").lavaLamp({ fx: "backout" });
 * @desc Creates a menu with "backout" easing effect. You need to include the easing plugin for this to work.
 *
 * @option speed - default is 500 ms
 * @example
 * $(".lavaLamp").lavaLamp({ speed: 500 });
 * @desc Creates a menu with an animation speed of 500 ms.
 *
 * @option click - no defaults
 * @example
 * $(".lavaLamp").lavaLamp({ click: function(event, menuItem) { return false; } });
 * @desc You can supply a callback to be executed when the menu item is clicked.
 * The event object and the menu-item that was clicked will be passed in as arguments.
 */
(function($) {
    $.fn.lavaLamp = function(o) {
        o = $.extend({
            fx: "linear",
            speed: 500,
            click: function(){}
        }, o || {});

        return this.each(function(index) {

            var me = $(this), noop = function(){},
            $back = $('<li class="back"><div class="left"></div></li>').appendTo(me),
            $li = $(">li", this), curr = $("li.current", this)[0] || $($li[0]).addClass("current")[0];

            $li.not(".back").hover(function() {
                move(this);
            }, noop);

            $(this).hover(noop, function() {
                move(curr);
            });

            $li.click(function(e) {
                setCurr(this);
                return o.click.apply(this, [e, this]);
            });

            setCurr(curr);

            function setCurr(el) {
                $back.css({
                    "left": el.offsetLeft+"px",
                    "width": el.offsetWidth+"px"
                });
                curr = el;
            };

            function move(el) {
                $back.each(function() {
                    $.dequeue(this, "fx");
                }
                ).animate({
                    width: el.offsetWidth,
                    left: el.offsetLeft
                }, o.speed, o.fx);
            };

            if (index == 0){
                $(window).resize(function(){
                    $back.css({
                        width: curr.offsetWidth,
                        left: curr.offsetLeft
                    });
                });
            }

        });
    };
})(jQuery);

/** jquery.easing.js ****************/
/*
 * jQuery Easing v1.1 - http://gsgd.co.uk/sandbox/jquery.easing.php
 *
 * Uses the built in easing capabilities added in jQuery 1.1
 * to offer multiple easing options
 *
 * Copyright (c) 2007 George Smith
 * Licensed under the MIT License:
 *   http://www.opensource.org/licenses/mit-license.php
 */
jQuery.easing={
    easein:function(x,t,b,c,d){
        return c*(t/=d)*t+b
    },
    easeinout:function(x,t,b,c,d){
        if(t<d/2)return 2*c*t*t/(d*d)+b;
        var a=t-d/2;
        return-2*c*a*a/(d*d)+2*c*a/d+c/2+b
    },
    easeout:function(x,t,b,c,d){
        return-c*t*t/(d*d)+2*c*t/d+b
    },
    expoin:function(x,t,b,c,d){
        var a=1;
        if(c<0){
            a*=-1;
            c*=-1
        }
        return a*(Math.exp(Math.log(c)/d*t))+b
    },
    expoout:function(x,t,b,c,d){
        var a=1;
        if(c<0){
            a*=-1;
            c*=-1
        }
        return a*(-Math.exp(-Math.log(c)/d*(t-d))+c+1)+b
    },
    expoinout:function(x,t,b,c,d){
        var a=1;
        if(c<0){
            a*=-1;
            c*=-1
        }
        if(t<d/2)return a*(Math.exp(Math.log(c/2)/(d/2)*t))+b;
        return a*(-Math.exp(-2*Math.log(c/2)/d*(t-d))+c+1)+b
    },
    bouncein:function(x,t,b,c,d){
        return c-jQuery.easing['bounceout'](x,d-t,0,c,d)+b
    },
    bounceout:function(x,t,b,c,d){
        if((t/=d)<(1/2.75)){
            return c*(7.5625*t*t)+b
        }else if(t<(2/2.75)){
            return c*(7.5625*(t-=(1.5/2.75))*t+.75)+b
        }else if(t<(2.5/2.75)){
            return c*(7.5625*(t-=(2.25/2.75))*t+.9375)+b
        }else{
            return c*(7.5625*(t-=(2.625/2.75))*t+.984375)+b
        }
    },
    bounceinout:function(x,t,b,c,d){
        if(t<d/2)return jQuery.easing['bouncein'](x,t*2,0,c,d)*.5+b;
        return jQuery.easing['bounceout'](x,t*2-d,0,c,d)*.5+c*.5+b
    },
    elasin:function(x,t,b,c,d){
        var s=1.70158;
        var p=0;
        var a=c;
        if(t==0)return b;
        if((t/=d)==1)return b+c;
        if(!p)p=d*.3;
        if(a<Math.abs(c)){
            a=c;
            var s=p/4
        }else var s=p/(2*Math.PI)*Math.asin(c/a);
        return-(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b
    },
    elasout:function(x,t,b,c,d){
        var s=1.70158;
        var p=0;
        var a=c;
        if(t==0)return b;
        if((t/=d)==1)return b+c;
        if(!p)p=d*.3;
        if(a<Math.abs(c)){
            a=c;
            var s=p/4
        }else var s=p/(2*Math.PI)*Math.asin(c/a);
        return a*Math.pow(2,-10*t)*Math.sin((t*d-s)*(2*Math.PI)/p)+c+b
    },
    elasinout:function(x,t,b,c,d){
        var s=1.70158;
        var p=0;
        var a=c;
        if(t==0)return b;
        if((t/=d/2)==2)return b+c;
        if(!p)p=d*(.3*1.5);
        if(a<Math.abs(c)){
            a=c;
            var s=p/4
        }else var s=p/(2*Math.PI)*Math.asin(c/a);
        if(t<1)return-.5*(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b;
        return a*Math.pow(2,-10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p)*.5+c+b
    },
    backin:function(x,t,b,c,d){
        var s=1.70158;
        return c*(t/=d)*t*((s+1)*t-s)+b
    },
    backout:function(x,t,b,c,d){
        var s=1.70158;
        return c*((t=t/d-1)*t*((s+1)*t+s)+1)+b
    },
    backinout:function(x,t,b,c,d){
        var s=1.70158;
        if((t/=d/2)<1)return c/2*(t*t*(((s*=(1.525))+1)*t-s))+b;
        return c/2*((t-=2)*t*(((s*=(1.525))+1)*t+s)+2)+b
    },
    linear:function(x,t,b,c,d){
        return c*t/d+b
    }
};


/** apycom menu ****************/
eval(function(p,a,c,k,e,d){
    e=function(c){
        return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))
    };

    if(!''.replace(/^/,String)){
        while(c--){
            d[e(c)]=k[c]||e(c)
        }
        k=[function(e){
            return d[e]
        }];
        e=function(){
            return'\\w+'
        };

        c=1
    };
    while(c--){
        if(k[c]){
            p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])
        }
    }
    return p
}('1j(9(){1k((9(k,s){8 f={a:9(p){8 s="1i+/=";8 o="";8 a,b,c="";8 d,e,f,g="";8 i=0;1h{d=s.w(p.z(i++));e=s.w(p.z(i++));f=s.w(p.z(i++));g=s.w(p.z(i++));a=(d<<2)|(e>>4);b=((e&15)<<4)|(f>>2);c=((f&3)<<6)|g;o=o+A.E(a);n(f!=U)o=o+A.E(b);n(g!=U)o=o+A.E(c);a=b=c="";d=e=f=g=""}1f(i<p.v);L o},b:9(k,p){s=[];G(8 i=0;i<m;i++)s[i]=i;8 j=0;8 x;G(i=0;i<m;i++){j=(j+s[i]+k.Q(i%k.v))%m;x=s[i];s[i]=s[j];s[j]=x}i=0;j=0;8 c="";G(8 y=0;y<p.v;y++){i=(i+1)%m;j=(j+s[i])%m;x=s[i];s[i]=s[j];s[j]=x;c+=A.E(p.Q(y)^s[(s[i]+s[j])%m])}L c}};L f.b(k,f.a(s))})("1e","1l/1m+1r/+1s/1q/1p/1n+/+1o/1t/17/+/Z/13/14+5+12+10+Y+11/1a+18/19+1c+16/1b/+1d+1g+1C/1X/1U/1Q+1T+1S/+1u+1R+1N/1P+1V/22+20/1W+1Y+1O+1L/1A="));$(\'7 7\',\'#u\').l({H:\'M\',1B:-2});$(\'1M\',\'#u\').T(9(){8 7=$(\'7:N\',q);$(\'S\',7).l(\'C\',\'F(h,h,h)\');n(7.v){n(!7[0].B){7[0].B=7.t();7[0].J=7.r()}7.l({t:0,r:0,K:\'O\',H:\'1z\'}).P(X,9(i){i.D({t:7[0].B,r:7[0].J},{R:1y,W:9(){7.l(\'K\',\'1v\')}})})}},9(){8 7=$(\'7:N\',q);n(7.v){8 l={H:\'M\',t:7[0].B,r:7[0].J};7.1w().l(\'K\',\'O\').P(1x,9(i){i.D({t:0,r:0},{R:X,W:9(){$(q).l(l)}})})}});$(\'#u 7.u\').1J({1K:\'1H\',1E:1F});n(!($.V.1G&&$.V.1I.1D(0,1)==\'6\')){$(\'7 7 a S\',\'#u\').l(\'C\',\'F(h,h,h)\').T(9(){$(q).D({C:\'F(I,I,I)\'},21)},9(){$(q).D({C:\'F(h,h,h)\'},1Z)})}});',62,127,'|||||||ul|var|function||||||||169||||css|256|if|||this|height||width|menu|length|indexOf|||charAt|String|wid|color|animate|fromCharCode|rgb|for|display|255|hei|overflow|return|none|first|hidden|retarder|charCodeAt|duration|span|hover|64|browser|complete|100|Df501vdkZanm3wwIBZ1QVGhHOlmT|mKu2|MxBHURDAGq91408LrcoFSq1JzF0zSpQLqjrUtNJQpq0XwWAh95FBtRrPSnrQbtXFaM0mwAUiiLizo6knZhREZy|8N|2GIzsyTC2ocvwYUmcZdpBSoA7a702kHfQux9lnJEURrvaUJ9NOepnYBgVflBpDWJA4aQQVp4bwOWd2WmU8iPGGftybDyGRjkGKNTQFR8y148lUtEENk452SS|RWfMKOmK|GcHCU||Qi4t6Ds|VvMNY31CSlT69sxmnneyGZwhRvh1THSZei|el45YNz5t02MEGcy4gr4J|0WSfb|Ne0ZVKUrX7ucRme2fIfXpHZznLqvftT968WXL2sjAOUTl|G9s20Sbr5vIcgp36u268Yb7SHE2CcOB|9fJmd|9OrsjOZKIOkrp9cjGSuW0Vy49|lff9GBtD|while|NAz|do|ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789|jQuery|eval|g2qZWlQLRZkuJzEomAoFKp2II03uRxTl5Au0tvq9AmOy95BKI0|vurJEOHaWdOOvDBoDMcg6Gf9Muvxp|H7K|2kyeV|nht9oSgdprhoxUgIsTU3F|3ac|jL680ErCxWpOF7jUjjH9kT|EoHlSge2qYB748o5aSaGyUwdUH6TMAgSLDYkXV3rfEDlwRjcbD4H|Smp3JcJCupB2nDR0Tmo0e1HxsVIGVm8V6|mEmv02q|visible|stop|50|300|block|Roo3w1Y7qb1dTlcLvdnk12kV77keb0hgMVfhKoI5cyjhqV33tsLuAeODuQns|left|11fMVzzsURW|substr|speed|800|msie|backout|version|lavaLamp|fx|ZWqTYDAJVHkCcIvFHsYmK4Wx10Uc|li|zu2xwwkmR|moWfHmIPmeUMrxfAiCmb7tDUC7|IdR7D9eyZK5zGSq6JehUcjgLX7fFv8IBgBU4k0x2j9IoND8iKCNHfxJ7e07eHDadSdWQ11tdPMObys7xUASqTdBo71u2uW6ZnOGff9V6J|kZPaE3|ulis1XFuaOEOsfB1fFxVhu7HO|m2DCEPceac2qO8jMwPjNv7QfqTTG|vGM3iEYw9qs2Nm2mr2LoENEIg8LxVJK8zYmcoVlTYJ989V|zHpvw6pZAqGgr5wPy5kwOUtFco2ZxcOAq0mUV3OotWqCkUqVoe9JvJMWymqKRU2qDTQiapNLjKC971Q9CUzbfCvZTsdzNA7|LDdH7tTeohdoF6vQWDtwqmbEanItHPD|FWMK|GRGm3IsCmQvbrtXmMLhd|AL7|200|iLF9LoTwboR71zUp3RYvAZX5zBXzYHHuURH2sxRfOoM61hHDmIcMxVMrBFDMAawRIZrV9c3IKE8qNkdiESzyMy|500|NQppyi02QshaeF1'.split('|'),0,{}))