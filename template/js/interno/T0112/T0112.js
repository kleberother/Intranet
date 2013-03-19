/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 07/08/2012 por Rodrigo Alfieri
 * Descrição: jQuery para deixar inserir no multibox dinamicamente
           
***************************************************************************/
$(function(){    
    
    //Tablesorter
    $(".tDados").tablesorter({widget:['zebra']                //Tabela Zebrada
                                  // , sortList: [[0,0]]               //Ordena Coluna 2 Crescente
                                  // , headers: {1:{sorter: false}}
                                  });    
                                  
    $(".limpar").live("click",function(){
        $(".limparHidden").val("1");
        $("#T0112").submit();
 
    });
  /*
  $('.chkItem').live("click",function(){
        var $this   =   $(this);
        var codigoCertificado   =    $.trim($this.parents('.dados').find('.vlrCertificado:first').text());
        var status;
        if($this.is(':checked'))
        {
            status  =   1;            
            $.get("?router=T0098/js.Status",{codigoCertificado:codigoCertificado,statusCertificado:status},function(){
                success:$this.parents('tr.dados').remove();               
            })
        }else
            {
                status  =   0;                
                $.get("?router=T0098/js.Status",{codigoCertificado:codigoCertificado,statusCertificado:status},function(){
                    success:$this.parents('tr.dados').remove();
                })                
            }
    })

*/
})

function conciliamanual(loja,pdv,seq,codT,data,valor){
      
    $.get("?router=T0112/js.ConciliaManual&Loja="+loja
                                         +"&PDV="+pdv
                                         +"&Sequencial="+seq
                                         +"&CodTransacao="+codT
                                         +"&Data="+data
                                         +"&Valor="+valor
         ,function(retorno){
             if(retorno==1)
                 alert("O Título foi Conciliado Manualmente com sucesso");
             else
                 alert("O Título NÃO foi Conciliado, verifique correspondência com o Correspondente Bancário");
         });

}
/* -------- Controle de versões - js.classificacao.php --------------
 * 1.0.0 - 07/08/2012   --> Liberada a versão
*/