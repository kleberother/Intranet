//js.busca dados do Fornecedor Banco RMS

// Busca por CNPJ
$(function(){
    $("#cnpj_for").bind("change",function(){
        var cnpj    =   $("#cnpj_for").val();
        var tipo    =   1;
        var cont    =   0;
        $.getJSON("?router=T0025/js.busca&cnpj="+cnpj+"&tipo="+tipo, function(dados){
            $("#nf_num").focus();
            $.each(dados, function(i, item){
                if (i    ==  "RAZ"){
                    $("#raz_social").val(item);
                }else if (i    ==  "COD"){
                    $("#rms_codigo").val(item);
                }else if (i    ==  "IES"){
                    $("#ie").val(item);
                }else if (i    ==  "IMN"){
                        $("#im").val(item);
                    }cont++;
            })
        });
    });
});


// Busca por Código RMS
$(function(){
    $("#rms_codigo").live("change",function(){
        var cod     =   $("#rms_codigo").val();
        var tipo    =   2;
        var cont    =   0;
        $.getJSON("?router=T0025/js.busca&cod="+cod+"&tipo="+tipo, function(dados){
            $("#nf_num").focus();
            $.each(dados, function(i, item){
                if (i    ==  "RAZ"){
                    $("#raz_social").val(item);
                }else if (i    ==  "CGC"){
                    $("#cnpj_for").val(item);
                }else if (i    ==  "IES"){
                    $("#ie").val(item);
                }else if (i    ==  "IMN"){
                    $("#im").val(item);
                }cont++;
            })
        });
    });
});


// Busca da lista de GFW
$(function(){
    $(".loja").live("change",function(){
        var loja       =   $(".loja").val();
        var tipo       =   3;
        var fornecedor =   $(".fornecedor").val();
        $.getJSON("?router=T0025/js.busca&loja="+loja+"&fornecedor="+fornecedor+"&tipo="+tipo, function(dados){
          $('#GrpWfl').html(dados);
        });
    });
});
