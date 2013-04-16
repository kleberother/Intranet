/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 04/04/2012 por Rodrigo Alfieri
 * Descrição: jQuery para deixar inserir no multibox dinamicamente
           
***************************************************************************/

$(function(){    
    $(".tDados").tablesorter({  widget:['zebra']                //Tabela Zebrada
                              , sortList: [[0,1]]               //Ordena Coluna 2 Crescente
                              , headers: {  
                                            2:{sorter: false}    //Retira o "Sorter" da Coluna 1
                                          , 3:{sorter: false}                                    
                                          , 4:{sorter: false}
                                         }                                    
                             });  
                                    
                                    

    //Ao clicar no Combo de Departamento filtra os produtos
    $("#departamento").live("change", function(){
        var depto   =   $(this).val();
        $.getJSON("?router=T0091/js.classificacao", {Depto:depto}, function(dados){
            $("#secao").html(dados);
        })
        
        $("#grupo").empty();
        $("#subgrupo").empty();        
        
    })

    //Ao clicar no Combo de Secao filtra os produtos
    $("#secao").live("change", function(){
        var depto   =   $("#departamento").val();
        var secao   =   $(this).val();
        if(secao==0)
            {
                $("#grupo").empty();
                $("#subgrupo").empty();  
            }
        else
            {
                $.getJSON("?router=T0091/js.classificacao", {Depto:depto,Secao:secao}, function(dados){
                    $("#grupo").html(dados);
                })

                $("#subgrupo").empty();        
            }
    })

    //Ao clicar no Combo de Grupo filtra os produtos
    $("#grupo").live("change", function(){
        var depto   =   $("#departamento").val();
        var secao   =   $("#secao").val();
        var grupo   =   $(this).val();
        if(grupo==0)
            {
                $("#subgrupo").empty();
            }else{
                $.getJSON("?router=T0091/js.classificacao", {Depto:depto,Secao:secao,Grupo:grupo}, function(dados){
                    $("#subgrupo").html(dados);
                })                
            }

        
    })
    
    
    $(".rupturaItens").live("click",function(e){
        e.preventDefault();
        var codigoAuditoria =   $(this).parents(".linha").find("td.codigoAuditoria").text();
        
    });
    
    $(".rupturaItens").live("click",function(){
        var $this           =   $(this);   
        var codigoAuditoria =   $this.parents("tr.linha").find(".codigoAuditoria").text();
        
        $.post("?router=T0095/js.rupturas",{codigoAuditoria: codigoAuditoria},  function(dados){
            $("#dialog-modal").html(dados);
            
        })
        
        $("#dialog-modal").dialog
        ({
            resizable: false,
            height:600,
            width:860,
            modal: true,
            draggable: false,
            title:  "Rupturas de Loja - Auditoria: "+codigoAuditoria,
            buttons:
            {
                    "Finalizar": function(){
                        $.post("?router=T0095/js.statusConfirmacao",{codigoAuditoria:codigoAuditoria, status:1 }, function(dados){
                            
                          if (dados == 56) 
                            $.post("?router=T0095/js.enviaEmailConfirmacao",{codigoAuditoria:codigoAuditoria});
                        else
                            $.post("?router=T0095/js.enviaEmailConfirmacaoCoor",{codigoAuditoria:codigoAuditoria});
                            
                        });
                        
                     
                        alert("Confirmações Finalizadas!");    
                        $(this).dialog("close");   
                    } 
                    ,
                    Cancelar: function(){
                        $(this).dialog("close");
                    }
            }
        }); 
        
    });
    
    $(".confirma").live("click",function(){
        var $this           =   $(this);
        var codigoItem      =   $this.parents("tr").find(".codigoItem").text()
        var codigoAuditoria =   $("#CodigoAuditoria").val();
        $.post("?router=T0095/js.atualizaStatus",{codigoAuditoria:codigoAuditoria, codigoRMS:codigoItem, status:2 } );
        $this.parents("tr").remove();
//        $("#dialog-mensagem").html("<p style='padding-top:10px;'>Tem certeza que deseja confirmar ?</p>");
//        $("#dialog-mensagem").dialog
//        ({
//            resizable: false,
//            height:120,
//            width:250,
//            modal: true,
//            draggable: false,
//            title:  "Mensagem",
//            buttons:
//            {
//                    "Ok": function(){
//                        
//                        $.post("?router=T0095/js.atualizaStatus",{codigoAuditoria:codigoAuditoria, codigoRMS:codigoItem, status:2 } );
//                        $this.parents("tr").remove();
//                        $(this).dialog("close");
//                
//            } 
//                    ,
//                    Cancelar: function(){
//                        $(this).dialog("close");
//                    }
//            }
//        });         
    });
    
    $(".naoconfirma").live("click",function(){
        var $this           =   $(this);
        var codigoItem      =   $this.parents("tr").find(".codigoItem").text()
        var codigoAuditoria =   $("#CodigoAuditoria").val();
         $.post("?router=T0095/js.atualizaStatus",{codigoAuditoria:codigoAuditoria, codigoRMS:codigoItem, status:1 } );
         $this.parents("tr").remove()
//        $("#dialog-mensagem").html("<p style='padding-top:10px;'>Tem certeza que deseja NÃO confirmar ?</p>");
//        $("#dialog-mensagem").dialog
//        ({
//            resizable: false,
//            height:120,
//            width:250,
//            modal: true,
//            draggable: false,
//            title:  "Mensagem",
//            buttons:
//            {
//                    "Ok": function(){
//                        
//                       
//                        $(this).dialog("close");
//                
//            } 
//                    ,
//                    Cancelar: function(){
//                        $(this).dialog("close");
//                    }
//            }
//        });        
        
    });
                                    
})
/* -------- Controle de versões - js.classificacao.php --------------
 * 1.0.0 - 04/04/2012   --> Liberada a versão
*/