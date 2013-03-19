// Data de Criação: 31/01/2012 
// Descrição:      Funções T0084, que executam um request no banco e retornam resultados
// Desenvolvedor:  Jorge Nova
$(function(){

    //Mascara de Valores para Inputs classe="monetario"
    $('.monetario').live("focus", function(event){
        event.preventDefault();
        $(this).priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.'
        }); 
    });
 

    // Nome da Função:            Busca CRF
    // Data de Criação da Função: 31/01/2012
    // Desenvolvedor:             Jorge Nova
    // Descrição:                 Ao sair do campo de classe .buscaCRF, se tiver valor, ele busca a descrição reduzida no banco do RMS
    // Versão:                    0.0.1


        $(".buscaCRF").live("blur",function(){

            var elemento  =   $(this);

            var CRF       =   elemento.val();

            if (CRF != "")
                {
                    $.getJSON("?router=T0084/js.buscaCRF&CRF="+CRF, function(dados){                    
                        $.each(dados, function(i, item){
                        if (i == "Codigo")
                            {
                                elemento.parents("li").find(".codigoCRF").val(item);
                            }
                        else if (i == "Descricao")
                            {
                                elemento.parents("li").find(".descricao").val(item);
                            }
                        });                   
                    });
                }
            else
                {
                    elemento.focus();
                }
        });


    // Nome da Função:            Select Box para retornar Código CRF
    // Data de Criação da Função: 01/02/2012
    // Desenvolvedor:             Jorge Nova
    // Descrição:                 Quando o campo de classe .codigoCRF ter foco, abrir modal para escolher CRF, e incluir 
    //                            valor no campo
    // Versão:                    0.0.1



        $(".codigoRMS").live("focus",function(){

            var elemento  =   $(this);

            var CRF       =   elemento.val();

            // Verifica se o Elemento esta vazio
            // True: Retorna um Modal com um Select Box para escolha da CRF
            // False: Bota o foco no campo de Valor da linha
            if (CRF == null || CRF == "")
                {

                    // Abre a modal com formulário para cadastro           
                    $( "#modal-addCRF" ).dialog({
                        resizable: false,
                        height:    150,
                        width:     400,
                        modal:     true,
                        buttons:
                        {
                            "Escolher": function()
                            {
                                
                                    var crf_codigo_select = $(".crf_codigo_select").val();
                                    
                                    
                                    //alert(crf_codigo_select);
                                    
                                    //var value             = crf_codigo_select.split(",");

                                    elemento.val(crf_codigo_select);

                                    //elemento.parents("li").find(".codigoCRF").val(value[0]);


                                    $(this).dialog("close");

                                    elemento.parents("li").find(".descricao").focus();
                                    
                                    $(".crf_codigo_select").find("option:first").attr("selected", "selected");
                                    
                            },
                            "Fechar": function()
                            {
                                    // Remove a estrutura HTML dentro da DIV #dialog-modal, localizada no header.php do sistema                       
                                    $("#modal-addCRF").remove();                            

                                    $(this).dialog("close");

                                    elemento.parents("li").find(".descricao").focus();
                            }
                        }                

                    })                
                }
            else
                {
                    elemento.parents("li").find(".descricao").focus();
                }
        });




    // Nome da Função:            Adicionar Linha
    // Data de Criação da Função: 
    // Desenvolvedor:             Rodrigo Alfieri
    // Modificada:                Jorge Nova            Em: 31/01/2011// 
    // Descrição:                 Ao clicar no botão adicionarLinha, ele adiciona uma linha igual a anterior
    // Versão:                    0.0.1

    $('.adicionaLinha').live("click",function(event){
        event.preventDefault();

        //Html para nova linha
        var html    =   "<li class='elementosLista'>";

            html    +=      "<div class='padding-2px-vertical conteudo-visivel'>";

            html    +=          "<div class='coluna c04_tipo_c_01 margim-5px-horizontal padding-2px-vertical'>";
            html    +=              "<input type='text'   name='T088_crf_rms[]' size='1'    class='codigoRMS' readonly  />";
            //html    +=              "<input type='hidden' name='T088_codigo[]'  size='1'    class='codigoCRF'           />";
            html    +=          "</div>";

            html    +=          "<div class='coluna c04_tipo_c_02 margim-5px-horizontal padding-2px-vertical'>";
            html    +=              "<textarea name='T087_descricao[]'   class='descricao'  maxlength='500' style='width:750px;height:15px'></textarea> ";
            html    +=          "</div>";

            html    +=          "<div class='coluna c04_tipo_c_03 margim-5px-horizontal padding-2px-vertical'>";
            html    +=              "<input type='text' name='T087_valor[]' size='10'   class='valorCRF monetario' />";
            html    +=          "</div>";

            html    +=          "<div class='coluna c04_tipo_c_04 margim-5px-horizontal padding-2px-vertical'>";
            html    +=              "<ul class='lista-de-acoes'>";
            html    +=                  "<li><a href='#' title='Excluir Linha'><span class='ui-icon ui-icon-minus removeLinha'></span></a></li>";
            html    +=              "</ul>";
            html    +=          "</div>";

            html    +=      "</div>";

            html    +=  "</li>";




            //Inclui na DIV conteudo, adicionando uma nova linha
            $(".lista-itens-body").append(html);

    });

    // Nome da Função:            Remover Linha
    // Data de Criação da Função: 
    // Desenvolvedor:             Rodrigo Alfieri
    // Modificada:                Jorge Nova            Em: 31/01/2011
    // Descrição:                 Ao clicar no botão removerLinha, ele remove a linha clicada
    // Versão:                    0.0.1

    $('.removeLinha').live("click",function(event){

        //Para retorno 0 ao clicar no link <a></a>
        event.preventDefault();

        //remove linha
        $(this).parents('.elementosLista').remove();

        calculaTotal();    


    });


    // Nome da Função:            Calcular Total
    // Data de Criação da Função: 
    // Desenvolvedor:             Rodrigo Alfieri
    // Modificada:                Jorge Nova            Em: 31/01/2011
    // Descrição:                 Função executa a somatória dos valores das CRFs e inputa no campo valorTotal 
    // Versão:                    0.0.1

    function calculaTotal()
    {        

        var valorCRF        =   0;


            valorCRF        =   $(".valorCRF").sum();

            valorCRF        =   moeda.formatar(valorCRF);

            $(".valorTotal").val(valorCRF);
            
            $(".valorTotal2").text(valorCRF);
            
            

    }

    // Nome da Função:            Calcular Total
    // Data de Criação da Função: 
    // Desenvolvedor:             Rodrigo Alfieri
    // Modificada:                Jorge Nova            Em: 31/01/2011
    // Descrição:                 Toda vez que o campo .valorCRF sofrer alteração, o valor total executa o calculo novamente
    //                            para atualização do valor
    // Versão:                    0.0.1

    $('.valorCRF').live("blur", function(event){

        event.preventDefault();        
        
        calculaTotal();

    });
    
    // Nome da Função:            Aumenta Campo Descrição
    // Data de Criação da Função: 12/04/2012
    // Desenvolvedor:             Rodrigo Alfieri
    // Descrição:                 Ao focar no campo descrição ela aumenta para melhor visualização do usuário (até 500 caracteres)
    // Versão:                    0.0.1    
 
    $(".descricao").live("focus",function(event){
        event.preventDefault();
        $(this).height(100)             
    });
    
    $(".descricao").live("blur", function(event){
        event.preventDefault();
        $(this).height(15);
    });
    
    // Nome da Função:            Valida Dta Emissao com Dta Vencto
    // Data de Criação da Função: 17/04/2012
    // Desenvolvedor:             Rodrigo Alfieri
    // Descrição:                 Ao sair do campo, ira validar a Dta Emissao com Dta Vencimento
    // Versão:                    0.0.1        
    
//    $("#DtVencto").focus(function(){
//        var nomeParametro   =   "days_retroative_nd"; //Nome do Parametro
//        var oDtEmiss        =   $("#DtEmiss")       ;
//        if (oDtEmiss.val()!="")
//            {
//                $.get("?router=parametro/js.parametro",{Parametro:nomeParametro},function(valorParametro){
//                    $.get("?router=T0084/js.data",{DtEmiss:oDtEmiss.val(),NumDias:valorParametro},function(dias){
//                        if(dias==0)
//                            {
//                                oDtEmiss.val("");
//                                oDtEmiss.focus();
//                                show_stack_bottomleft(true, 'Erro!', 'Data de Emissão não pode ser maior que Data de Hoje');                        
//                            }else if(dias==1)
//                                {
//                                    oDtEmiss.val("");
//                                    oDtEmiss.focus();
//                                    show_stack_bottomleft(true, 'Erro!', 'A data de Emissão não pode ser menor que '+parseInt(valorParametro)+' dia(s)');                        
//                                }                            
//                    });
//                });        
//            }else
//                {
//                    oDtEmiss.val("");
//                    oDtEmiss.focus();
//                    show_stack_bottomleft(true, 'Erro!', 'Data de Emissão não pode estar em branco!');         
//                }
//    });
//    
//    $("#DtVencto").blur(function(){
//       var oDtEmiss =   $("#DtEmiss").val()   ;
//       var $this    =   $(this).val()         ;
//       alert(new Date(oDtEmiss).getTime());
//       alert(new Date($this).getTime());
//       if(new Date(oDtEmiss).getTime()<new Date($this).getTime())
//           {
//                $this.val("");
//                $this.focus();
//                show_stack_bottomleft(true, 'Erro!', 'Data Emissão não pode ser maior que Data de Vencimento!');                        
//           }
//    });
//    
});

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