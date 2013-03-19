function aprovar(prog,pagina,tabela,status,campo,valor,etapa,tpnota)
{
    document.prog   =   prog;
    document.pagina =   pagina;
    document.tabela =   tabela;
    document.status =   status;
    document.campo  =   campo;
    document.valor  =   valor;
    document.etapa  =   etapa;
    document.tpnota =   tpnota;
    $("#dialog-transmissao").dialog
    ({
            resizable: false,
            height:140,
            modal: true,
            buttons:
            {
                    "Aprovar": function()
                    {
                        function aprovacao()
                        {
                            $.get('?router='+document.prog+'/aprovar&pagina='+document.pagina+'&tabela='+document.tabela+'&status='+document.status+'&campo='+document.campo+'&valor='+document.valor+'&etapa='+document.etapa+'&tpnota='+document.tpnota);
                            $(this).dialog("close");
                            var qs =    $("#id_search").quicksearch(".dados", {
                                        noResults: '#semresultado',
                                        stripeRows: ['odd', 'even'],
                                        loader: 'span.loading'
                                        });
                            var tipo    =   10;
                            var filtro  =   $("#aps").val();
                            var itens   =   "";
                                $("#dialog-carregando").dialog
                                ({
                                        resizable: false,
                                        height:50,
                                        modal: true,
                                        closeOnEscape: false,
                                        draggable:false,
                                        open: function() {                                         
                                                            $(".ui-dialog-titlebar-close").hide();                                                         
                                                            } 
                                })
                            $("#carregando").html("Carregando...");
                            $.getJSON("?router=T0016/js.busca&tipo="+tipo+"&status="+filtro, function(dados){
                                if (dados == null)
                                    {
                                        $(".dados").remove();
                                        $("#carregando").html("Não existem dados para esta seleção...");
                                        $("#dialog-carregando").dialog("close");                                        
                                    }
                                else
                                    {
                                    $.each(dados, function(i, item){
                                        itens = itens + item;
                                    })
                                    $(".campos").html(itens);
                                    $("#dialog-carregando").dialog("close");
                                    //Utiliza o que tem no cache para efetuar o filtro em elemento dinamico
                                    qs.cache();
                                    $("#carregando").html("");
                                    }

                            })                            
                        }                        
                        $.get("?router=T0016/js.vencimento",{codigoAp:document.valor, evento:1}, function(dados){ //evento 1 verifica vencimento
                            if (dados == 1)
                                {
                                    $("#dialog-transmissao").dialog("close");
                                    $("#dialog-data-vencimento").dialog
                                    ({
                                            resizable: false,
                                            width:300,
                                            draggable: false,
                                            modal: true,
                                            open: $(".pVencimento").text("O Campo Data de Vencimento da Ap: "+document.valor+" está em Branco, preencha o campo com a Data e Confirme."),
                                            buttons:
                                            {
                                                "Alterar e Salvar": function()
                                                {
                                                    var dataVencimento  =   $("#DataVencto").val();
                                                    $.get("?router=T0016/js.vencimento",{codigoAp:document.valor, dataVencimento:dataVencimento, evento:2},function(dados){ //evento 2 atualiza tabela
                                                        if ( dados == 1 )
                                                            {
                                                                aprovacao();
                                                                show_stack_bottomleft(false, 'Alerta!', 'Data de Vencimento alterada da Ap: '+document.valor+' alterada.');
                                                            }else
                                                                {
                                                                    show_stack_bottomleft(true, 'Erro!', 'Não foi possível alterar a data de Vencimento da Ap: '+document.valor+' e/ou aprovar.');
                                                                }
                                                    });
                                                    
                                                    $(this).dialog("close");
                                                },
                                                Fechar: function()
                                                {
                                                    $(this).dialog("close");
                                                }
                                            }                     
                                    });                                     
                                }else
                                    {
                                        $("#dialog-transmissao").dialog("close");
                                        aprovacao();
                                    }                            
                        });
                    }
                    ,
                    Cancelar: function()
                    {
                            $(this).dialog("close");
                    }
            }                     
            
    });
    

}


            