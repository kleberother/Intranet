/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 04/04/2012 por Rodrigo Alfieri
 * Descrição: jQuery para deixar inserir no multibox dinamicamente
           
***************************************************************************/

$(function(){    


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
    
    
    $("#Gerar").click(function(){
        var depto   =   $("#departamento").val();
        if(depto==0)
            {
                alert("Selecione um Departamento");
            }
    });

})
/* -------- Controle de versões - js.classificacao.php --------------
 * 1.0.0 - 04/04/2012   --> Liberada a versão
*/