/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 28/09/2011 por Rodrigo Alfieri
 * Descrição: jQuery para deixar produto visivel ao painel e uma determinada area
           
***************************************************************************/

$(function(){    
    var $this = $(".dados").find("#selecionaItem");
    $this.click(function(){        
        var Dados  =   $(this).val();
        var Evento       =   "";
        //Verifica se foi 'selecionado' para o item ficar visivel no painel e area
        if($(this).is(':checked'))
            {
//                alert(Dados); /* TESTE */
                Evento       =   1;                
                $.getJSON("?router=T0034/js.visivel", {Dados:Dados,Evento:Evento});                
            }
        else
            {
//                alert(Dados); /* TESTE */
                Evento       =   0;
                $.getJSON("?router=T0034/js.visivel", {Dados:Dados,Evento:Evento});                                
            }
    })
})

/* -------- Controle de versões - js.classificacao.php --------------
 * 1.0.0 - 28/09/2011   --> Liberada a versão
*/