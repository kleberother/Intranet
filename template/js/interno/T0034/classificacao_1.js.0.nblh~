/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 14/09/2011 por Rodrigo Alfieri
 * Descrição: jQuery preenche os combos de Seção, Grupo e Subgrupo Dinamicamente
           
***************************************************************************/

$(function(){
    //Preenche Combo Seção
    $("#depto").bind("change", function(){
        var depto   =   $(this).val();
        $.getJSON("?router=T0034/js.classificacao", {Depto:depto}, function(dados){
            $("#secao").html(dados);
        })
        
        $("#grupo").empty();
        $("#subgrupo").empty();
        
    })                
    
    //Preenche Combo Grupo
    $("#secao").bind("change", function(){
        var depto   =   $("#depto").val();
        var secao   =   $(this).val();
        $.getJSON("?router=T0034/js.classificacao", {Depto:depto,Secao:secao}, function(dados){
            $("#grupo").html(dados);
        })
        
        $("#subgrupo").empty();
        
    }) 

    //Preenche Combo SubGrupo
    $("#grupo").bind("change", function(){
        var depto   =   $("#depto").val();
        var secao   =   $("#secao").val();
        var grupo   =   $(this).val();

        $.getJSON("?router=T0034/js.classificacao", {Depto:depto,Secao:secao,Grupo:grupo}, function(dados){
            $("#subgrupo").html(dados);
        })
        
    }) 
    
})

/* -------- Controle de versões - js.classificacao.php --------------
 * 1.0.0 - 14/09/2011   --> Liberada a versão
*/