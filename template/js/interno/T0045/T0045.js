//Remove Enter da página
$(function(e){
    var code = (e.keyCode ? e.keyCode : e.which);
    if(code==13)
        return false;
})

//Cria próxima linha com elementos dinâmicos após pressionar o Enter no campo Qtde.
$('.Emb').live('focus', function(){
    var $this= $(this).parent().parent();
    //Valores dos Campos para inserir tabela Detalhe do Mata burro
    var Item        =   $this.find(".Item").val();
    var Descricao   =   $this.find(".Descricao").val();
    var Qtde        =   $this.find(".Qtde").val();
    var QtdeEmb     =   $this.find(".QtdeEmb").val();
    var Emb         =   $this.find(".Emb").val();
    var DataValidade=   $this.find(".DataValidade").val();
    var Login       =   $("#login").val();
    var Data        =   $("#T067_data_hora_inicio").val();
    var IdColeta    =   $("#idcoleta").val();
    var tipo        =   2;
    var CodItem     =   $this.find(".CodItem").val();
    var SaidaMedia  =   $this.find(".SaidaMedia").val();

    $.get("?router=T0045/js.insere&tipo="+tipo+"&Item="+Item+"&Descricao="+Descricao+"&Qtde="+Qtde+"&QtdeEmb="+QtdeEmb+"&Emb="+Emb+"&DataValidade="+DataValidade+"&Login="+Login+"&Data="+Data+"&IdColeta="+IdColeta+"&CodItem="+CodItem+"&SaidaMedia="+SaidaMedia, function(dados){
        $this.find(".IdItem").val(dados);
    });

    if (Qtde == "")
    {
        $this.find(".Qtde").focus();
    }
    else
    {
        //Preenche o campo quantidade
        QtdeTotal   =   parseFloat($this.find(".Qtde").val())*parseFloat($this.find(".QtdeEmb").val());
        $this.find(".QtdeTotal").val(QtdeTotal);

        //Bloqueia os campos
        var input   =   "<td><span class='lista_acoes'><ul><li class='ui-state-default ui-corner-all' title='Deletar'   ><a class='ui-icon ui-icon-minus ExcluiItem'></a></li></ul></td>";

            $(".dados").find("tbody").find("tr:last").append(input);

            $(".Item").attr("disabled","disabled");
            $(".Descricao").attr("disabled","disabled");
            $(".Qtde").attr("disabled","disabled");
            $(".QtdeEmb").attr("disabled","disabled");
            $(".DataValidade").attr("disabled","disabled");
            $(".Emb").attr("disabled","disabled");
            $(".SaidaMedia").attr("disabled","disabled");
            $(".QtdeTotal").attr("disabled","disabled");
            
            input  = "<tr>";
            input += "<td><input type='text' name='itm[]'           class='form-input-text-table Item'          style='width:100px;'                        /></td>";
            input += "<td><input type='text' name='desc[]'          class='form-input-text-table Descricao'     style='width:300px;' readonly               /></td>";
            input += "<td><input type='text' name='qtd[]'           class='form-input-text-table Qtde'          style='width:50px;'                         /></td>";
            input += "<td><input type='text' name='qtd_emb[]'       class='form-input-text-table QtdeEmb'       style='width:50px;'                         /></td>";
            input += "<td><input type='text' name='data_validade[]' class='form-input-text-table DataValidade'  style='width:100px'                         /></td>";
            input += "<td><input type='text' name='emb[]'           class='form-input-text-table Emb'           style='width:50px;'  readonly               /></td>";
            input += "<td><input type='text' name='saida_media[]'   class='form-input-text-table SaidaMedia'    style='width:50px;'                         /></td>";
            input += "<td><input type='text' name='qtd_total[]'     class='form-input-text-table QtdeTotal'     style='width:50px;'  readonly               /></td>";
            input += "<td><input type='text' name='itm_rms[]'       class='form-input-text-table CodItem'       style='width:50px;display:none;'            /></td>";
            input += "<td><input type='text' name='id_item[]'       class='form-input-text-table IdItem'        style='width:50px;display:none;'            /></td>";
            input += "</tr>";

        $(".dados").find("tbody").append(input);
        $(".Item").focus();
    }
    return false;
});

//Busca no RMS as informações de QtdeEmbalagem e Embalagem após teclar o Enter
$('.Item').live('blur', function(){
    var $this       =   $(this).parent().parent();
    var QtdeCampo   =   $(this).val();
    var Qtde        =   QtdeCampo.length;
    var tipo;
    var Codigo      =   $(this).val();
    var Loja        =   $("#T006_codigo").val();
    //Para DUN14

    if (QtdeCampo=="")
    {
        $(this).focus();
    }
    else
    {
        //Verifica se é EAN
        if (Qtde <= 13)
                {
                    tipo    =   1;
                    $.getJSON("?router=T0045/js.coleta&tipo="+tipo+"&cod="+Codigo+"&loja="+Loja, function(dados){
                        if (dados == 0)
                        {
                            //Não achando EAN procura código curto
                            tipo    =   3;
                            $.getJSON("?router=T0045/js.coleta&tipo="+tipo+"&cod="+Codigo+"&loja="+Loja, function(dados){
                                if (dados == 0)
                                    {
                                        $this.find(".Item").focus();
                                        $this.find(".Item").val("");
                                    }
                                    else
                                    {
                                        $.each(dados, function(i, item){
                                            if (i    ==  "DESCRICAO"){
                                                $this.find(".Descricao").val(item);
                                            }else if (i    ==  "EMBALAGEM"){
                                                $this.find(".QtdeEmb").val(item);
                                            }else if (i    ==  "TPEMB"){
                                                $this.find(".Emb").val(item);
                                            }else if (i == "CODIGO"){
                                                $this.find(".CodItem").val(item);
                                            }else if (i == "SAIDA_MEDIA"){
                                                $this.find(".SaidaMedia").val(item);
                                            }
                                        })

                                        $(".Qtde").focus();                                        
                                    }
                            });
                        }
                        else
                        {
                            $.each(dados, function(i, item){
                                if ( i    ==  "DESCRICAO"){
                                    $this.find(".Descricao").val(item);
                                }else if (i    ==  "EMBALAGEM"){
                                    $this.find(".QtdeEmb").val(item);
                                }else if (i    ==  "TPEMB"){
                                    $this.find(".Emb").val(item);
                                }else if (i == "CODIGO"){
                                        $this.find(".CodItem").val(item);
                                    }else if (i == "SAIDA_MEDIA"){
                                        $this.find(".SaidaMedia").val(item);
                                    }
                            })

                            $(".Qtde").focus();
                        }
                    });
                }
                else if(Qtde==14) 
                {
                    //Procura DUN
                    tipo    =   2;
                    $.getJSON("?router=T0045/js.coleta&tipo="+tipo+"&cod="+Codigo+"&loja="+Loja, function(dados){
                        if (dados == 0)
                            {
                                $this.find(".Item").focus();
                                $this.find(".Item").val("");
                            }
                            else
                            {
                                $.each(dados, function(i, item){
                                    if (i    ==  "DESCRICAO"){
                                        $this.find(".Descricao").val(item);
                                    }else if (i    ==  "EMBALAGEM"){
                                        $this.find(".QtdeEmb").val(item);
                                    }else if (i    ==  "TPEMB"){
                                        $this.find(".Emb").val(item);
                                    }else if (i == "CODIGO"){
                                        $this.find(".CodItem").val(item);
                                    }else if (i == "SAIDA_MEDIA"){
                                        $this.find(".SaidaMedia").val(item);
                                    }
                                })

                                $(".Qtde").focus();
                            }
                    });
                }
                
            return false;
    }
})

//Abre os campos com o detalhe da coleta

$("#inicia_coleta").live("click",function(){
    var tipo                =   1;
    var DataInicio          =   $("#T067_data_hora_inicio").val();
    var Sentido             =   $("#T067_sentido").val();
    var Login               =   $("#login").val();
    var LoginAbastecimento  =   $("#T004_login_abastecimento").val();
    var Loja                =   $("#T006_codigo").val();
    var Motivo              =   $("#T069_codigo").val();

    if (Motivo != "" && LoginAbastecimento != "")
    {
        $.getJSON("?router=T0045/js.insere&tipo="+tipo+"&T067_data_hora_inicio="+DataInicio+"&T067_sentido="+Sentido+"&T004_login="+Login+"&T004_login_abastecimento="+LoginAbastecimento+"&T006_codigo="+Loja+"&T069_codigo="+Motivo, function(dados){
            //Id da Coleta
            $("#idcoleta").val(dados);
        });

//Atribui o Atributo Disable nos campos (deixa desabilitado)
        $("#inicia_coleta").attr({style:"display:none"});
        $("#detalhes_coleta").attr({style:"display:block"});


        var input  = "<tr>";
            input += "<td><input type='text' name='itm[]'           class='form-input-text-table Item'          style='width:100px;'                        /></td>";
            input += "<td><input type='text' name='desc[]'          class='form-input-text-table Descricao'     style='width:300px;' readonly               /></td>";
            input += "<td><input type='text' name='qtd[]'           class='form-input-text-table Qtde'          style='width:50px;'                         /></td>";
            input += "<td><input type='text' name='qtd_emb[]'       class='form-input-text-table QtdeEmb'       style='width:50px;'                         /></td>";
            input += "<td><input type='text' name='data_validade[]' class='form-input-text-table DataValidade'  style='width:100px'                         /></td>";
            input += "<td><input type='text' name='emb[]'           class='form-input-text-table Emb'           style='width:50px;'  readonly               /></td>";
            input += "<td><input type='text' name='saida_media[]'   class='form-input-text-table SaidaMedia'    style='width:50px;'                         /></td>";
            input += "<td><input type='text' name='qtd_total[]'     class='form-input-text-table QtdeTotal'     style='width:50px;'  readonly               /></td>";
            input += "<td><input type='text' name='itm_rms[]'       class='form-input-text-table CodItem'       style='width:50px;display:none;'            /></td>";
            input += "<td><input type='text' name='id_item[]'       class='form-input-text-table IdItem'        style='width:50px;display:none;'            /></td>";
            input += "</tr>";
            
        $(".dados").find("tbody").append(input);
        $('.Item').focus();
    }
})

//Cancelar Coleta
$("#cancela_coleta").live("click",function(){
    $("#dialog-cancelar").dialog({
            resizable: false,
            height:140,
            modal: true,
            buttons:
            {
                    "Cancelar": function()
                    {
                        //Exclui das tabelas a coleta atual
                        var IdColeta    =   $("#idcoleta").val();

                        $.get("?router=T0045/js.cancela&IdColeta="+IdColeta);
                        //Cancela Coleta atual e zera campos
                        $("#inicia_coleta").attr({style:"display:block"});
                        $("#detalhes_coleta").attr({style:"display:none"});
                        location.reload();
                        $(this).dialog("close");
                    }
                    ,
                    Fechar: function()
                    {
                        $(this).dialog("close");
                    }
            }
    })
})

//Direcionamento do cursor
$(".Qtde").live("focus", function(){
    //Caso não tenha um código de item digitado/scaneado
    var $this= $(this).parent().parent();
    var Item = $this.find(".Item").val();    

    if (Item =="")
        $this.find(".Item").focus();

})

//Direcionamento do cursor
$(".QtdeEmb").live("focus", function(){
    //Caso não tenha um código de item digitado/scaneado
    var $this= $(this).parent().parent();
    var Item = $this.find(".Item").val();
    var Qtde = $this.find(".Qtde").val();

    if (Qtde=="")
        $this.find(".Qtde").focus();
    
    if (Item =="")
        $this.find(".Item").focus();
})

//Direcionamento do cursor
$(".Emb").live("focus", function(){
    //Caso não tenha um código de item digitado/scaneado
    var $this= $(this).parent().parent();
    var Item = $this.find(".Item").val();

    if (Item =="")
        $this.find(".Item").focus();
})

//Direcionamento do cursor
$(".QtdeTotal").live("focus", function(){
    //Caso não tenha um código de item digitado/scaneado
    var $this= $(this).parent().parent();
    var Item = $this.find(".Item").val();

    if (Item =="")
        $this.find(".Item").focus();
})

$("#finaliza_coleta").live("click",function(){
    var IdColeta    =   $("#idcoleta").val();
    $("#dialog-finalizar").dialog({
            resizable: false,
            height:140,
            modal: true,
            buttons:
            {
                    "Finalizar": function()
                    {
                        //Exclui das tabelas a coleta atual
                        $.get("?router=T0045/js.atualiza&IdColeta="+IdColeta);
                        $(this).dialog("close");
                        location.reload();
                    }
                    ,
                    Fechar: function()
                    {
                        $(this).dialog("close");
                    }
            }
    })
})

$(".ExcluiItem").live("click", function(){
    var $this   =   $(this).parent().parent().parent().parent().parent()

    var IdItem  =   $this.find(".IdItem").val();
    var IdColeta=   $("#idcoleta").val();

    $.get("?router=T0045/js.exclui&IdColeta="+IdColeta+"&IdItem="+IdItem);

    $this.remove();

    $(".Item").focus();

})

$(".ui-datepicker").live("click",function(){
    $(".itens").find("tr:last").find(".DataValidade").focus();
})

$(".DataValidade").live("focus",function(){
    $(".DataValidade").datepicker();
    $(".DataValidade").mask("99/99/9999");

});


// ------------------- CADASTRO DE MOTIVOS --------------------------

$("#Criar").live("click",function(){
    var Nome        =   $("#MotivoNome").val();
    var Descricao   =   $("#MotivoDescricao").val();
    var tipo        =   3;

    $.get("?router=T0045/js.insere&tipo="+tipo+"&Nome="+Nome+"&Descricao="+Descricao);

    location.reload();

})