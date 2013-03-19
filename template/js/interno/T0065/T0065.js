// -- FUNÇÃO PARA BUSCAR OS USUÁRIOS POR NOME -----------------------------------------------------------//
$(function(){
  $(document).ready(function() 	{
    $('.nome_usuario').autocomplete(
    {
      source: "?router=T0065/js.busca",
      minLength: 2
    });
  });    
});

