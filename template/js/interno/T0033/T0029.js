//-- AUTOCOMPLETE DE NOMES PARA FILTRO -----------------------------------------//
//$(function() {
//        var cache = {},
//                lastXhr;
//        $( "#proprietario" ).autocomplete({
//                minLength: 2,
//                source: function( request, response ) {
//                        var term = request.term;
//                        if ( term in cache ) {
//                                response( cache[ term ] );
//                                return;
//                        }
//
//                        lastXhr = $.getJSON( "?router=T0029/js.busca", request, function( data, status, xhr ) {
//                                cache[ term ] = data;
//                                if ( xhr === lastXhr ) {
//                                        response( data );
//                                }
//                        });
//                }
//        });
//});

//-- AO ESCOLHER DATA INICIAL, COMPLETAR A MESMA COISA NA FINAL -----------------------------------------//
$(function() {
        $( "#dt_inicial" ).live("change",function(){
          var $this       =   $("#dt_inicial");
          var dt_final    =   $("#dt_final").val()
          if(dt_final == "")
          {
           $( "#dt_final" ).val($this.val());
          }
        });
});

// -- FUNÇÃO PARA BUSCAR OS USUÁRIOS POR NOME -----------------------------------------------------------//
$(function(){
  $(document).ready(function() 	{
    $('.nome_usuario').autocomplete(
    {
      source: "?router=T0029/js.busca",
      minLength: 2
    });
  });    
});

