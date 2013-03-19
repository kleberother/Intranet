$(function(){
    

});

    function excluirLinha(cod){
    $.get("?router=T0116/js.excluir", {codAN:cod},
    function(){
       $(".linha_"+cod).remove(); 
    });
}