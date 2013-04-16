// Data de Criação:
// Descrição:      
// Desenvolvedor:  

$(function(){
    
    //Tablesorter
    // original
    
//    $("#tPrincipal").tablesorter({widget:['zebra']                //Tabela Zebrada
//                                  , sortList: [[1,0]]               //Ordena Coluna 2 Crescente
//                                  , headers: {0:{sorter: false}    //Retira o "Sorter" da Coluna 1
//                                             , 7:{sorter: false}    //Retira o "Sorter" da Coluna 8
//                                             }
//
//                                  });

    $("#tPrincipal").tablesorter({ widgets:['zebra']                //Tabela Zebrada
                                , locale: 'br'  // nao sei se funciona
                                , sortList: [[0,0]]               //Ordena Coluna 1 Crescente
                                , sortMultiSortKey: 'ctrlKey' // seleção de mais de uma coluna para ordenacao
                                , headers: {
                                                100:{sorter: false}    // retira sorter da coluna 99 ** exemplo **
                                              , 3: {sorter:"brazilCurrency"} // moeda
                                          }
                                });


    // backup 16.04.2013 11:15
//    $(".Detalhes").live("click",function(e){
//        e.preventDefault(); // nao aparece a "#" da tela
//        var $thisAprovar=$(this);
//        var Lote=$($thisAprovar).parents("tr").find(".txtLote").text();
//        $("#dialog-detalhes").dialog
//        ({
//                resizable: true,
//                height:600,
//                draggable: true,
//                width:800,
//                modal: true,
//                title:"Detalhes do Lote "+Lote,
//                buttons:
//                {
//                        Fechar: function()
//                        {
//                            $(this).dialog("close");
//                        },
//                        Aprovar: function() 
//                        {
//                            $.get("?router=T0119/js.Aprovar",{Lote:Lote},function(retorno){
//                                if(retorno==1){
//                                    show_stack_bottomleft(false," ","Lote Aprovado com sucesso");
//                                    //$($thisAprovar).remove();
//                                    $($thisAprovar).parents("tr").remove();
//                                }else{
//                                  show_stack_bottomleft(true,"Erro","Lote Não Aprovado");
//                                }
//                                    
//                            });
//                            $(this).dialog("close");
//
//                        }
//
//                }
//        })
//    }) ;

        $(".Detalhes").live("click",function(e){
        e.preventDefault(); // nao aparece a "#" da tela
        var $thisAprovar=$(this);
        var Lote=$($thisAprovar).parents("tr").find(".txtLote").text();
        var Loja=$($thisAprovar).parents("tr").find(".txtLoja").text();
        $.get("?router=T0119/js.ConsultaDetalhes",{Lote:Lote,Loja:Loja},function(retorno){
            $("#dialog-detalhes").html(retorno);
  
            $("#tDetalhes").tablesorter({ widgets:['zebra']                //Tabela Zebrada
                                        , locale: 'br'  // nao sei se funciona
                                        , sortList: [[0,0]]               //Ordena Coluna 1 Crescente
                                        , sortMultiSortKey: 'ctrlKey' // seleção de mais de uma coluna para ordenacao
                                        , headers: {
                                                        7:{sorter: false}   
                                                      , 3: {sorter:"brazilNumber"}   
                                                      , 4: {sorter:"brazilCurrency"} // moeda
                                                      , 5: {sorter:"brazilCurrency"}
                                                  }
                                        });
           
        });        
        $("#dialog-detalhes").dialog
        ({
                resizable: true,
                height:600,
                draggable: true,
                width:800,
                modal: true,
                title:"Detalhes do Lote "+Lote,
        })

    }) ;
    
    $(".Aprovar").live("click",function(e){
        e.preventDefault(); // nao aparece a "#" da tela
        var $thisAprovar=$(this);
        var Lote=$($thisAprovar).parents("tr").find(".txtLote").text();
        $("#dialog-aprovar").dialog
        ({
                resizable: false,
                height:200,
                draggable: false,
                width:200,
                modal: true,
                title:"Aprovar Lote "+Lote,
                buttons:
                {
                        Sim: function() 
                        {
                            $.get("?router=T0119/js.Aprovar",{Lote:Lote},function(retorno){
                                if(retorno==1){
                                    show_stack_bottomleft(false," ","Lote Aprovado com sucesso");
                                    //$($thisAprovar).remove();
                                    $($thisAprovar).parents("tr").remove();
                                }else{
                                  show_stack_bottomleft(true,"Erro","Lote Não Aprovado");
                                }
                                    
                            });
                            
                            $(this).dialog("close");
                        }
                        ,
                        Não: function()
                        {
                            $(this).dialog("close");
                        }
                }
        })
    }) ;
});
/* ============== Função para Upload Fim  =================== */ 

/* ============== T0026/novo FIM ============================ */

/* -------- Controle de versões - T0026.js --------------
 * 1.0.0 - 99/99/9999 - Rodrigo --> 1. Liberada versao inicial
 */