$(function() {
    //GASOLINA COMUM
    var gc = $(".gc_valor").average();
    $(".gc_media").html(gc.toFixed(3));

    //GASOLINA ADITIVADA
    var ga = $(".ga_valor").average();
    $(".ga_media").html(ga.toFixed(3));

    //ETANOL COMUM
    var ec = $(".ec_valor").average();
    $(".ec_media").html(ec.toFixed(3));

    //ETANOL ADITIVADO
    var ea = $(".ea_valor").average();
    $(".ea_media").html(ea.toFixed(3));

    //DIESEL
    var di = $(".di_valor").average();
    $(".di_media").html(di.toFixed(3));

    //GNV
    var gn = $(".gn_valor").average();
    $(".gn_media").html(gn.toFixed(3));
          
    });
