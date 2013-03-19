$(function(){
    //js.busca Dinamica para elementos dinamicos
    var qs =    $("#id_search").quicksearch(".dados", {
                noResults: '#semresultado',
                stripeRows: ['odd', 'even'],
                loader: 'span.loading'
                });

    //executa a ação a partir do "change"
    
    $("#list-forn").bind("change", function(){
        var tipo    =   10;
        var filtro  =   $(this).val();
        var itens   =   "";
        if (filtro == 0)
            {
                $(".dados").remove();
                $("#carregando").html("");
            }
        else
            {
                $("#carregando").html("Carregando...");
                $.getJSON("?router=T0016/js.busca&tipo="+tipo+"&filtro="+filtro, function(dados){
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

    })
})