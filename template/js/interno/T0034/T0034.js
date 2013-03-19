/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 28/09/2011 por Rodrigo Alfieri
 * Descrição: jQuery para checkbox 
           
***************************************************************************/

$(function(){
    
    var selecionaItem = new Array();
    $("#btnAprovarTodos").live("click",function(){    
         var $this = $(".dados").find("#selecionaItem");
         var AP = new Array();
         var Etapa = new Array();
                if($this.is(':checked'))
                {
                    $("input[@name='selecionaItem[]']:checked").each(function()
                                                                        {
                                                                            var AP_e_Etapa = ($(this).val().split("&"));
                                                                            AP.push(AP_e_Etapa[0]);
                                                                            Etapa.push(AP_e_Etapa[1]);
                                                                        });
                                                                        
                    aprovar('T0016','T0016/home','T008_T060','1','T008_codigo',AP,Etapa);
                    
                }else
                    {
                        alert('Você deve selecionar ao menos uma AP para aprovar');
                    }                
    })
})

/* -------- Controle de versões - js.classificacao.php --------------
 * 1.0.0 - 28/09/2011   --> Liberada a versão
*/