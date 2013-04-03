// Data de Criação: 12/01/2012
// Descrição:      Funções do programa T0026 - Reembolso de Despesas
// Desenvolvedor:  Rodrigo Alfieri

$(function(){
    
    //Tablesorter
    $("#tPrincipal").tablesorter({widget:['zebra']                //Tabela Zebrada
                                  , sortList: [[1,0]]               //Ordena Coluna 2 Crescente
                                  , headers: {0:{sorter: false}    //Retira o "Sorter" da Coluna 1
                                             , 7:{sorter: false}    //Retira o "Sorter" da Coluna 8
                                             }
                                  });
                                  
    $("#tDespesa").tablesorter({widget:['zebra']                //Tabela Zebrada
                                    , sortList: [[0,0]]               //Ordena Coluna 2 Crescente
                                    , headers: {3:{sorter: false}    //Retira o "Sorter" da Coluna 4
                                               , 5:{sorter: false}    //Retira o "Sorter" da Coluna 6
                                               , 6:{sorter: false}    //Retira o "Sorter" da Coluna 7
                                               }
                                    });
                                  
    $("#tDespesaDiv").tablesorter({widget:['zebra']                //Tabela Zebrada
                                    , sortList: [[0,0]]               //Ordena Coluna 2 Crescente
                                    });
        
    //Caixa com Formulário
    $(".botaoAddDespesa").click(function(){
        function validaForm(form)
        {
            var err = 0;
            form.children().children('.required').each(function(){
                if($(this).val() == '' || $(this).val() == null){
                    $(this).addClass('error');
                    form.children('.error_form').show();
                    err++;
                }
            });
            if(err == 0)
                return true;
            else
            {
                show_stack_bottomleft(true, 'Erro!', 'Preencha todos os campos!');  
                return false;
            }
        }
                
        function limpaCampos()
        {
            $("#dialogData").val("");
            $("#dialogKm").val("");
            $("#dialogHistorico").val("");
            $("#dialogLojaOrigem option[value='']").attr('selected', 'selected');
            $("#dialogHoraOrigem option[value='']").attr('selected', 'selected');
            $("#dialogLojaDestino option[value='']").attr('selected', 'selected');
            $("#dialogHoraDestino option[value='']").attr('selected', 'selected');
            
        }
        
        $(".dialog-despesa").dialog
        ({
                resizable: false,
                height:400,
                draggable: false,
                width:420,
                modal: true,
                buttons:
                {
                        Ok: function() 
                        {
                            var html        =   ""                              ;
                            var data        =   $("#dialogData").val()          ;
                            var historico   =   $("#dialogHistorico").val()     ;
                            var lojaOrigem  =   $("#dialogLojaOrigem").val()    ;
                            var lojaDestino =   $("#dialogLojaDestino").val()   ;
                            var horaOrigem  =   $("#dialogHoraOrigem").val()    ;
                            var horaDestino =   $("#dialogHoraDestino").val()   ;
                            var km          =   $("#dialogKm").val()            ;
                            
                            if (lojaOrigem=="999")
                                lojaOrigem  =   "999-"+$("#txtExternoOrigem").val();
                            else
                                lojaOrigem  =   $("#dialogLojaOrigem option[value='"+lojaOrigem+"']").attr('selected', 'selected').html();
                            
                            
                            if (lojaDestino=="999")
                                lojaDestino =   "999-"+$("#txtExternoDestino").val();
                            else
                                lojaDestino =   $("#dialogLojaDestino option[value='"+lojaDestino+"']").attr('selected', 'selected').html();
                            
                            $("#linhaInfo").remove();
                             
                            html    +=  "<tr>";
                            html    +=  "<td>"+data+"</td>";
                            html    +=  "<td>"+historico+"</td>";
                            html    +=  "<td>"+lojaOrigem+"</td>";
                            html    +=  "<td>"+$("#dialogHoraOrigem option[value='"+horaOrigem+"']").attr('selected', 'selected').html()+"</td>";
                            html    +=  "<td>"+lojaDestino+"</td>";
                            html    +=  "<td>"+$("#dialogHoraDestino option[value='"+horaDestino+"']").attr('selected', 'selected').html()+"</td>";
                            html    +=  "<td>"+km+"</td>";
                            html    +=  "</tr>";
                            
                            if(validaForm($("#dialogForm")))
                            {    
                                $("#dDados").append(html);
                                limpaCampos();   
                                $(this).dialog("close");
                            }
                            
                        }
                        ,
                        Fechar: function()
                        {
                            $(this).dialog("close");
                        }
                }
        }); 
    });    
    
    //Busca CPF
    $(".cpf").blur(function(){
        var $this   =   $(this);
        var cpf     =   $this.val();
        $.getJSON("?router=T0026/js.verificaCpf",{cpf:cpf},function(dados){
            if (dados==0)
                {
                    show_stack_bottomleft(true, 'Erro!', 'Você não tem cadastro no RMS favor entrar em contato com...');  
                    $this.val("");
                    $this.focus();
                    $("#nomeColaborador").val();
                    $("#abasDespesa").css("display", "none");
                }else
                    {
                        $.each(dados, function(i,itm){
                            $("#nomeColaborador").val(itm);
                        });
                        
                        $("#abasDespesa").css("display", "block");
                        
                    };
        });
    });
    
    $("#dialogLojaOrigem").focus(function(){
        var $this   =   $(this);
        $.get("?router=T0026/js.lojas",function(dados){
            $this.html(dados)            
        }); 
    });
    
    $("#dialogLojaOrigem").change(function(){
        var $this   =   $(this);
        var loja    =   $this.val();
        $.get("?router=T0026/js.lojas",{loja:loja},function(dados){
            $("#dialogLojaDestino").html(dados)            
        });
        
        if(loja=="999")
        {
            $(".dialog-despesa").dialog({ height:430});
            $("#externoOrigem").css("display","block");
            $("#externoOrigem").addClass("required");
            $("#dialogKm").removeAttr("disabled");
        }else
        {
            $("#externoOrigem").css("display","none");
            $("#externoOrigem").removeClass("required");
            $("#dialogKm").attr("disabled","disabled");
        }
    });
    
    $("#dialogLojaDestino").change(function(){
        var $this           =   $(this);
        var lojaOrigem      =   $("#dialogLojaOrigem").val();
        var lojaDestino     =   $this.val();
        
        if(lojaDestino=="999")
        {
            $(".dialog-despesa").dialog({ height:430});
            $("#externoDestino").css("display","block");
            $("#externoOrigem").addClass("required");
            $("#dialogKm").removeAttr("disabled");
        }else
        {
            $("#externoDestino").css("display","none");
            $("#externoOrigem").removeClass("required");
            $("#dialogKm").attr("disabled","disabled");
        }
        
        $.get("?router=T0026/js.km",{lojaOrigem:lojaOrigem,lojaDestino:lojaDestino}, function(dados){
            $("#dialogKm").val(dados);
        });
        
    });  
    
    $("#dialogKm").bind("keyup blur focus", function(e) {
        e.preventDefault();
        var expre = /[^0-9]/g;
        // REMOVE OS CARACTERES DA EXPRESSAO ACIMA
        if ($(this).val().match(expre))
            $(this).val($(this).val().replace(expre,''));
    });       
                                    
});
/* ============== Função para Upload Fim  =================== */ 

/* ============== T0026/novo FIM ============================ */

/* -------- Controle de versões - T0026.js --------------
 * 1.0.0 - 99/99/9999 - Rodrigo --> 1. Liberada versao inicial
 */