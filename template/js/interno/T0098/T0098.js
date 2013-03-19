/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 07/08/2012 por Rodrigo Alfieri
 * Descrição: jQuery para deixar inserir no multibox dinamicamente
           
***************************************************************************/
$(function(){    
    
    //Tablesorter
    $(".tDados").tablesorter({widget:['zebra']                //Tabela Zebrada
                                  , sortList: [[1,0]]               //Ordena Coluna 2 Crescente
                                  , headers: {10:{sorter: false}}
                                  });    

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


})
/* -------- Controle de versões - js.classificacao.php --------------
 * 1.0.0 - 07/08/2012   --> Liberada a versão
*/