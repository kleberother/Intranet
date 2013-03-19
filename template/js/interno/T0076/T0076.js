// Data de Criação: 23/01/2012 
// Descrição:      Funções T0076, que executam um request no banco e retornam resultados
// Desenvolvedor:  Jorge Nova

// Nome da Função:            Busca locais de atendimento
// Data de Criação da Função: 12/01/2012
// Desenvolvedor:             Jorge Nova
// Descrição:                 Ao selecionar a entidade prestadora, carregará uma listagem com os locais possíveis
// Versão:                    0.0.1

 $(function(){
         
    $(".entidade").live("change",function(){
        var entidade       =   $(".entidade").val();
        
        $.getJSON("?router=T0076/js.buscaLocal&entidade="+entidade, function(dados){
           $('.local').html(dados);
        });
    })
        
});