$(function(){
    //-- Preencher data Final = Data Inicial (qdo em branco)
        $( ".FilVencimentoInicial" ).live("change",function(){
          var $this                 =   $(".FilVencimentoInicial");
          var FilVencimentoFinal    =   $(".FilVencimentoFinal").val()
          if(FilVencimentoFinal == "")
          {
           $( ".FilVencimentoFinal" ).val($this.val());
          }
        });


    //js.busca Dinamica para elementos dinamicos
    var qs =    $("#id_search").quicksearch(".dados", {
                noResults: '#semresultado',
                stripeRows: ['odd', 'even'],
                loader: 'span.loading'
                });
   
    
    //executa a ação a partir do "change"
    $("#aps").bind("change", function(){        
       Filtrar ();
    })
    
    
    $("#btnFiltrar").bind("click", function(){        
        Filtrar ();
    })

    $(".CampoFiltro").bind("change", function(){        
        Filtrar ();
    })
    

function Filtrar(){
    
    var tipo                =   10; // tipo fixo para consulta de APs
    var Status              =   $("#aps").val();
    var FilRegistros        =   $("#FilRegistros").val();
    var itens               =   "";
    var FilAp               =   $("#FilAp").val();
    var FilNf               =   $("#FilNf").val(); 
    var FilCNPJ             =   $("#FilCNPJ").val();
    var FilFornecedor       =   $("#FilFornecedor").val();
    var FilVencimentoInicial=   $(".FilVencimentoInicial").val();
    var FilVencimentoFinal  =   $(".FilVencimentoFinal").val();
    var FilValorInicial     =   $("#FilValorInicial").val();
    var FilValorFinal       =   $("#FilValorFinal").val();
    
    if (Status != 1)
        $("#selecionaTodos").attr("disabled","disabled");
    else
        $("#selecionaTodos").removeAttr("disabled","disabled");
    
    // Verifica se nao foi selecionando nenhum status
    if (Status == 0)
        {
            $(".dados").remove();
            $("#carregando").html("Escolha algum status para Consulta");
            $("#aps").focus();
        }
        else
            {
                
            $("#carregando").html("Aguarde Carregando...");
            $.getJSON("?router=T0016/js.busca&tipo="+tipo+"&FilRegistros="+FilRegistros+"&status="+Status+"&FilAp="+FilAp+"&FilNf="+FilNf+"&FilCNPJ="+FilCNPJ+"&FilFornecedor="+FilFornecedor+"&FilVencimentoInicial="+FilVencimentoInicial+"&FilVencimentoFinal="+FilVencimentoFinal+"&FilValorInicial="+FilValorInicial+"&FilValorFinal="+FilValorFinal, function(dados){
                if (dados == null)
                    {
                        $(".dados").remove();
                        $("#carregando").html("Não existem dados para esta seleção...");
                    }
                else
                    {
                        $.each(dados, function(i, item){
                            itens = itens + item;
                        })
                        $(".campos").html(itens);
                        //Utiliza o que tem no cache para efetuar o filtro em elemento dinamico
                        qs.cache();
                        $("#carregando").html("");
                    }

            })
            }
          //$("#aps").focus();

    }
})

// FUNÇÃO PARA MARCAR/DESMARCAR TODOS OS ITENS DE UMA TABELA NO CHECKBOX
$("#selecionaTodos").live("click",function(){
    var $this = $(".campos").find("#selecionaItem");
    if ($("#selecionaTodos").attr("checked")) {
       $this.attr("checked", "checked");  
    }
    else {
        $this.removeAttr("checked");
    }
}); 


$(function(){
    
    var selecionaItem = new Array();
    $("#btnAprovarTodos").live("click",function(){        
         var $this = $(".dados").find("#selecionaItem");
         var AP     = new Array();
         var Etapa  = new Array();         
         var TpNota = new Array();
                if($this.is(':checked'))
                {
                    $("input[@name='selecionaItem[]']:checked").each(function()
                                                                        {
                                                                            var AP_e_Etapa = ($(this).val().split("&"));
                                                                            AP.push(AP_e_Etapa[0]);
                                                                            Etapa.push(AP_e_Etapa[1]);
                                                                            TpNota.push(AP_e_Etapa[2]);
                                                                        });
                    $.get("?router=T0016/js.vencimento",{codigoAp:AP, evento:1}, function(dados){
                        if ( dados == 1)
                            {
                                 show_stack_bottomleft(true, 'Erro!', 'Existem uma ou mais APs sem data de vencimento!'); 
                            }else
                                {
                                    aprovar('T0016','T0016/home','T008_T060','1','T008_codigo',AP,Etapa,TpNota);
                                }
                    })
                                                                        
                    
                    
                }else
                    {
                        alert('Você deve selecionar ao menos uma AP para aprovar');
                    }                
    })
})

