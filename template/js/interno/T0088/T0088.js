// Data de Criação: 31/01/2012 
// Descrição:      Funções T0088, que executam um request no banco e retornam resultados
// Desenvolvedor:  Jorge Nova

// Nome da Função:            Busca CRF
// Data de Criação da Função: 31/01/2012
// Desenvolvedor:             Jorge Nova
// Descrição:                 Ao sair do campo de classe .buscaCRF, se tiver valor, ele busca a descrição reduzida no banco do RMS
// Versão:                    0.0.1

 $(function(){
         
    $(".buscaCRF").live("blur",function(){
        
        var CRF       =   $(".CRF").val();
              
        $.get("?router=T0088/js.buscaCRF&CRF="+CRF, function(dados){
           $('.descricaoReduzida').val(dados);
        });
    })
        
});