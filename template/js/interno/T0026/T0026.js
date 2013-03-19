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
            form.children('.required').each(function(){
                if($(this).val() == '' || $(this).val() == null){
                    $(this).addClass('error');
                    form.children('.error_form').show();
                    err++;
                }
            })
            if(err == 0)
                return true
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
                height:370,
                draggable: false,
                width:390,
                modal: true,
                buttons:
                {
                        Ok: function() 
                        {
                            validaForm($("#dialogForm"));
                            limpaCampos();
                        }
                        ,
                        Fechar: function()
                        {
                            $(this).dialog("close");
                        }
                }
        }) 
    });
    
    $("#dialogLojaOrigem").change(function(){
        
    })
         
 
                                    
})
/* ============== Função para Upload Fim  =================== */ 

/* ============== T0026/novo FIM ============================ */

/* -------- Controle de versões - T0026.js --------------
 * 1.0.0 - 99/99/9999 - Rodrigo --> 1. Liberada versao inicial
 */