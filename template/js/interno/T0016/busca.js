//Busca dados do Fornecedor Banco RMS

//Busca por CNPJ ((TAB CNPJ)

$(function(){
    $("#cnpj_for").bind("change",function(){
        var cnpj    =   $("#cnpj_for").val();
        var tipo    =   1;
        $.getJSON("?router=T0016/js.busca&cnpj="+cnpj+"&tipo="+tipo, function(dados){
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
                    }
            })
            var cod_cnpj=   $("#rms_codigo").val();
            var ie      =   $("#ie").val();
            var im      =   $("#im").val();
            var raz     =   $("#raz_social").val();
            
            var tipo    =   5;
            $.get("?router=T0016/js.busca&cnpj="+cnpj+"&cod_cnpj="+cod_cnpj+"&ie="+ie+"&im="+im+"&raz="+raz+"&tipo="+tipo, function(dados){
                $("#CodForn").val(dados);
                $("#CodFornWkf").val(dados);
            });
        });
    });
});

//Busca por Código (TAB CNPJ)

$(function(){
    $("#rms_codigo").live("change",function(){
        var cod     =   $("#rms_codigo").val();
        var tipo    =   2;
        $.getJSON("?router=T0016/js.busca&cod="+cod+"&tipo="+tipo, function(dados){
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
                }
            })
            var cnpj=   $("#cnpj_for").val();
            var ie      =   $("#ie").val();
            var im      =   $("#im").val();
            var raz     =   $("#raz_social").val();
            var tipo    =   5;
            $.get("?router=T0016/js.busca&cnpj="+cnpj+"&cod_cnpj="+cod+"&ie="+ie+"&im="+im+"&raz="+raz+"&tipo="+tipo, function(dados){
                $("#CodForn").val(dados);
                $("#CodFornWkf").val(dados);
            });
        });
    });
});

//busca por CPF (TAB CPF)

$(function(){
    $("#cpf_for").bind("change",function(){
        var cpf    =   $("#cpf_for").val();
        var tipo    =   1;
        $.getJSON("?router=T0016/js.busca&cnpj="+cpf+"&tipo="+tipo, function(dados){
            $("#nf_num").focus();
            $.each(dados, function(i, item){
                if (i    ==  "RAZ"){
                    $("#cpf_raz_social").val(item);
                }else if (i    ==  "COD"){
                    $("#cpf_rms_codigo").val(item);
                }else if (i    ==  "IES"){
                        $("#cpf_rg").val(item);
                    }
            })
            var cod_cpf =   $("#cpf_rms_codigo").val();
            var rg      =   $("#cpf_rg").val();
            var raz     =   $("#cpf_raz_social").val();
            var tipo    =   6;
            $.get("?router=T0016/js.busca&cpf="+cpf+"&cod_cpf="+cod_cpf+"&rg="+rg+"&raz="+raz+"&tipo="+tipo, function(dados){
                $("#CodForn").val(dados);
                $("#CodFornWkf").val(dados);
            });
        });
    });
});

//Busca por código (TAB CPF)

$(function(){
    $("#cpf_rms_codigo").live("change",function(){
        var cod     =   $("#cpf_rms_codigo").val();
        var tipo    =   2;
        $.getJSON("?router=T0016/js.busca&cod="+cod+"&tipo="+tipo, function(dados){
            $("#nf_num").focus();
            $.each(dados, function(i, item){
                if (i    ==  "RAZ"){
                    $("#cpf_raz_social").val(item);
                }else if (i    ==  "CGC"){
                    $("#cpf_for").val(item);
                }else if (i    ==  "IES"){
                    $("#cpf_rg").val(item);
                }
            })
            var cpf     =   $("#cpf_for").val();
            var rg      =   $("#cpf_rg").val();
            var raz     =   $("#cpf_raz_social").val();
            var tipo    =   6;
            $.get("?router=T0016/js.busca&cpf="+cpf+"&cod_cpf="+cod+"&rg="+rg+"&raz="+raz+"&tipo="+tipo, function(dados){
                $("#CodForn").val(dados);
                $("#CodFornWkf").val(dados);
            });
        });
    });
});

function incluiGrupoWorkflow()
{
            var forn1;
            if ($("#cnpj_for").val()=="")
                forn1    =   $("#cpf_for").val();
            else
                forn1    =   $("#cnpj_for").val();

            var loja    =   $("#loja").val();
            var tipo    =   3;
            $.get("?router=T0016/js.busca&cnpj="+forn1+"&loja="+loja+"&tipo="+tipo, function(campos){
                if (campos ==0)
                {
                    $( "#dialog-grp" ).dialog( "open" );
                    $( "#dialog-grp" ).dialog({
                            autoOpen: true,
                            height: 220,
                            width: 550,
                            draggable: false,
                            resizable: false,
                            modal: true,
                            buttons: {
                                    "Associar": function() {
                                        var loja        = $("#loja").val();
                                        var processo    = $("#processo").val();
                                        var grupo       = $("#grupo").val();
                                        var forn;
                                        if ($("#cnpj_for").val()=="")
                                            forn    =   $("#cpf_for").val();
                                        else
                                            forn    =   $("#cnpj_for").val();

                                        $.get("?router=T0016/js.grupo&loja="+loja+"&processo="+processo+"&grupo="+grupo+"&forn="+forn, function(dados){
                                                    var forn2;
                                                    if ($("#cnpj_for").val()=="")
                                                        forn2    =   $("#cpf_for").val();
                                                    else
                                                        forn2    =   $("#cnpj_for").val();

                                                    var loja    =   $("#loja").val();
                                                    var tipo    =   3;
                                                    $.get("?router=T0016/js.busca&cnpj="+forn2+"&loja="+loja+"&tipo="+tipo, function(campos){
                                                        $("#workflow").html(campos);
                                                    })
                                        })
                                        $("#workflow").html(campos);
                                        $( this ).dialog( "close" );
                                    },
                                    Cancelar: function() {

                                                    $( this ).dialog( "close" );
                                    }
                            },
                            close: function() {
                                    allFields.val("").removeClass( "ui-state-error" );
                            }
                    })

                }
                else
                $("#workflow").html(campos);
            });
}


$(function(){
    $("#loja").live("change",(function(){
        if ($(this).val()!="")
            {
                incluiGrupoWorkflow();
            }
        else
            {
                $("#workflow").html();
            }
    }))
})

//busca por NOTA FISCAL, para conferir se já existem alguma nota com o mesmo número inserida no banco
// OBJETIVO: NÃO GERAR DUPLICIDADE (TAB NF)

$(function(){
    $("#nf_num").bind("change",(function(){

        var cnpj    =   $("#cnpj_for").val();
        var nf_num  =   $("#nf_num").val();
        var tipo    =   9;
        var textoCabecalho = "Atenção!\nExiste uma outra AP para essa NF/Série\n" ;

       $.getJSON("?router=T0016/js.busca&cnpj="+cnpj+"&nf_num="+nf_num+"&tipo="+tipo, function(dados){
            $.each(dados, function(index, value){
                
               alert(textoCabecalho + "\n AP: "    + value["APCodigo"]
                                    + "\n Valor: R$ " + value["ValorBruto"]
                                    + "\n Feita por: " + value["Login"]
                                    + "\n Em: " + value["DataElaboracao"]
                    );
            })
        });
    }))
})


//Botão Adicionar Novo Grupo de Workflow
$(function(){
    $("#adicionarGpWk").live("click", function(){
            var forn1;
            if ($("#cnpj_for").val()=="")
                forn1    =   $("#cpf_for").val();
            else
                forn1    =   $("#cnpj_for").val();

            var loja    =   $("#loja").val();
            var tipo    =   3;
            $.get("?router=T0016/js.busca&cnpj="+forn1+"&loja="+loja+"&tipo="+tipo, function(campos){
                    $( "#dialog-grp" ).dialog( "open" );
                    $( "#dialog-grp" ).dialog({
                            autoOpen: true,
                            height: 220,
                            width: 550,
                            draggable: false,
                            resizable: false,
                            modal: true,
                            buttons: {
                                    "Associar": function() {
                                        var loja        = $("#loja").val();
                                        var processo    = $("#processo").val();
                                        var grupo       = $("#grupo").val();
                                        var forn;
                                        if ($("#cnpj_for").val()=="")
                                            forn    =   $("#cpf_for").val();
                                        else
                                            forn    =   $("#cnpj_for").val();

                                        $.get("?router=T0016/js.grupo&loja="+loja+"&processo="+processo+"&grupo="+grupo+"&forn="+forn, function(dados){
                                                    var forn2;
                                                    if ($("#cnpj_for").val()=="")
                                                        forn2    =   $("#cpf_for").val();
                                                    else
                                                        forn2    =   $("#cnpj_for").val();

                                                    var loja    =   $("#loja").val();
                                                    var tipo    =   3;
                                                    $.get("?router=T0016/js.busca&cnpj="+forn2+"&loja="+loja+"&tipo="+tipo, function(campos){
                                                        $("#workflow").html(campos);
                                                    })
                                        })
                                        $("#workflow").html(campos);
                                        $( this ).dialog( "close" );
                                    },
                                    Cancelar: function() {

                                                    $( this ).dialog( "close" );
                                    }
                            },
                            close: function() {
                                    
                            }
                    });
        });
    });
})