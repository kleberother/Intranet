$(function(){
    
      $('.cpf').live("keyup", function(){
            var $this   =   $(this);
            var cpf     =   $this.val();
           
            $.get("?router=T0111/js.cruzarDados",{campocpf:cpf},function(retorno){
              
            
                 $('#conta').live("blur", function(){
                
                var $thisConta = $(this);
                $thisConta.val(retorno);
                
                
                });    
               
           });
        });
                    
       $('#preco').live("blur",function(){
           
           var qtd      =   $('#quantidade').val();
           var preco    =   $('#preco').val();
           var reais    =  preco.replace(',','.');
           var calculo  =  parseFloat(qtd*reais);
           
           var total        =   calculo.toFixed(2);
           var totalReais   =   total.replace('.',',');
           $('#total').val(totalReais);
       });
          
                    
         
});



function confirmaLinha(cod, codEtapa){
        $.get("?router=T0111/js.conferir",{cod:cod, etapa:codEtapa},
        function(){
            $(".linha_"+cod).remove();
            
        });
}

function lancarLinha(cod, codEtapa){
    $.get("?router=T0111/js.lancar", {cod:cod, etapa:codEtapa},
    function(){
       $(".linha_"+cod).remove(); 
    });
}


function excluirLinha(cod){
    $.get("?router=T0111/js.deletar", {cod:cod},
    function(){
       $(".linha_"+cod).remove(); 
    });
}

function retornaMotivo(cod){
    $.get("?router=T0111/js.motivo", {cod:cod},
    function(retorno){
        alert(retorno);
    });
    
    
     
    
}



