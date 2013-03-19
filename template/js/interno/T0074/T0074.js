// Data de Criação: 12/01/2012 
// Descrição:      Funções T0074, que executam um request no banco e retornam resultados
// Desenvolvedor:  Jorge Nova

// Nome da Função:            Usuários Extra x Intra 
// Data de Criação da Função: 12/01/2012
// Desenvolvedor:             Jorge Nova
// Descrição:                 O grantor poderá aplicar permissões para demais usuários D´avó, visualizar arquivos da extranet
//                            upados por determinados usuários
// Versão:                    0.0.1

 $(function(){
     
    $(".associarUsuario").live("click",function(){   
           
        var $this     = $('ul.lista-arquivos').find("li").find(".marcarArquivo:checked"),  
            $valores  = [];   
            
        // Preenchendo o array com valores dos itens checados
        $('ul.lista-arquivos').find("li").find(".marcarArquivo:checked").each(function(n){
            $valores[n] = $(this).val();
        });        
        
        // Checa se existe algum item checado
        if ($this.attr("checked")) 
        {                
           
        //$.get("?router=extranet/js.busca&tipo="+tipo, function(dados){
            
            // Formata HTML a ser inserido no Modal
            var $html = "<div id='modal-permissaoArquivo' title='Permissionar Arquivos' style='display:none;'>"+
                        "   <form action='?router=T0067/js.permissao' method='post' id='form-permissao'>"+
                                              
                        "       <div class='div-input'>"+
                        "       <label>Escolha o Usuário*</label>"+
                        "       <input type='text' name='usuarioPermissao' id='usuarioPermissao' maxlength='40' size='50' class='buscaUsuario usuarioPermissao' />"+       
                        "       </div>"+                                                                                                                   

                        "       <div class='div-input'>"+
                        "       <p><a href='#' class='addUsuario'>Adicionar usuário</a></p>"+
                        "       </div>"+                                                                                                                   

                        "       <div class='div-input'>"+
                        "       <label>Usuários Selecionados*</label>"+
                        "       <select name='T004_login[]' id='T004_login' multiple='multiple' class='multiploSelectBoxModal'>"+       
                        "       <option value=''>Adicione os usuários para esse campo!</option>"+       
                        "       </select>"+       
                        "       </div>"+                                                         
                        
                        "<input type='hidden' value='"+$valores+"' name='T055_codigo' />"+
                      
                        "   </form>"+
                        "</div>";
            
            
            // Insere a estrutura HTML dentro da DIV #dialog-modal, localizada no header.php do sistema
            $("#modal").html($html);
                
            
            // Abre a modal com formulário para cadastro           
            $( "#modal-permissaoArquivo" ).dialog({
                resizable: false,
                height:    440,
                width:     400,
                modal:     true,
                buttons:
                {
                    "Salvar": function() {
                        
                            $("#form-permissao").submit();
                    },
                    "Fechar": function()
                    {
                            // Remove a estrutura HTML dentro da DIV #dialog-modal, localizada no header.php do sistema                       
                            $("#modal-permissaoArquivo").remove();   
                            
                            $(this).dialog("close");                          
                    }
                }                
            //});
            
            //$( "#dialog-mostraUsuario" ).dialog("open");                             
            })
        }
        else 
        {
            alert("Selecione algum item para aplicar permissão");
        }   
        
        })
        
    });