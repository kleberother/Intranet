// Data de Criação: 21/12/2011 
// Descrição:      Funções Gerais do Sistema, que executam um request no banco e retornam resultados
// Desenvolvedor:  Jorge Nova

// Nome da Função:            Atribuição de nomes para os elementos
// Data de Criação da Função: 21/12/2011
// Desenvolvedor:             Jorge Nova
// Descrição:                 Todos os elementos que deverão ser utilizados no sistema serão informados nessa área
// Versão:                    0.0.1

$(function() {   
        
        // Botões do Sistema
        $( "input:submit, button").button();
        
        // Href com estilo dos botões
        $( "a",".botao-jquery-padrao").button();
        
        $( "a",".botao-jquery-padrao" ).click(function() {return false;});
        
        // Abas do sistema
	$( "#abas" ).tabs();        
        
                
});

// Descrição:                   Funções para abrir e fechar Menu Tree
// Desenvolvedor:               Jorge Nova
// Nome da Função:              Atribuição de nomes para os elementos
// Data de Criação da Função:   21/12/2011
// Desenvolvedor:               Jorge Nova
// Descrição:                   Todos os elementos que deverão ser utilizados no sistema serão informados nessa área
// Versão:                      0.0.1

$(function(){

	$(".menu-tree li a").click(function(){

                //$(".submenu-tree").style.margin="0 0 0 10px";
		$(this).next().toggle();

	})

})	

// Nome da Função:            Adicionar Arquivo 
// Data de Criação da Função: 21/12/2011
// Desenvolvedor:             Jorge Nova
// Descrição:                 Função abrirá modal com formulário para criação de novo arquivo
// Versão:                    0.0.1
    
$(function() {   
 
    $(".addArquivo").live("click",function(){   
        //var tipo           =  1;
        
        // Variavel para carregar o usuário que esta fazendo o upload (Programa 67 Linha 15)
        var usuario          =  $("#usuario").html();
        var grantor          =  $("#grantor").html();
        
        // Variavel para preencher a lista de categorias de arquivos (Programa 67 Linha 20)
        var catArquivo       =  $("#select-categoria-de-arquivos").html();
             
             
        //$.get("?router=extranet/js.busca&tipo="+tipo, function(dados){
            
            // Formata HTML a ser inserido no Modal
            var $html = "<div id='modal-addArquivo' title='Adicionar Arquivo' style='display:none;'>"+
                        "   <form action='?router=T0067/js.upload' method='post' enctype='multipart/form-data' id='form-upload'>"+
                        
                        "       <div class='padding-padrao-vertical'>"+                        
                        "     	<p class='validateTips'>Todos os campos são obrigatórios.</p>"+
                        "     	</div>"+
                        
                        "       <div class='div-input'>"+
                        "       <label>Nome do Arquivo*</label>"+
                        "       <input type='text' name='T055_nome' id='T055_nome' maxlength='40' size='50' />"+       
                        "       </div>"+                        
                        
                        "       <div class='div-input'>"+
                        "       <label>Descrição</label>"+
                        "       <textarea name='T055_desc' id='T055_desc' cols='50' rows='5' ></textarea>"+       
                        "       </div>"+                               
                        
//                        "       <div class='div-input'>"+                         
//                        "       <label>Tipo de Arquivo*</label>"+
//                        "       <select name='T056_codigo' id='T056_codigo'>"+
//                        "           <option value=''>Selecione...</option>"+
//                                    catArquivo+
//                        "       </select>"+       
//                        "       </div>"+                        

                        "       <div class='div-input'>"+
                        "       <label>Escolha o Arquivo*</label>"+
                        "       <input type='file'   name='P0067_arquivo' id='arquivo' />"+       
                        "       </div>"+   
                        
                        "       <input type='hidden' name='T004_login'  value='"+usuario+"' />"+
                        "       <input type='hidden' name='T004_owner'  value='"+grantor+"' />"+
                        "       <input type='hidden' name='T056_codigo' value='19'          />"+
                        
                        
                        "   </form>"+
                        "</div>";
            
            
            // Insere a estrutura HTML dentro da DIV #dialog-modal, localizada no header.php do sistema
            $("#modal").html($html);
           

            // Atribui valores para variaveis a serem validadas no formulário
            var nome      = $("#T055_nome"),
                descricao = $("#T055_desc"),
                categoria = $("#T056_codigo"),
                campos    = $( [] ).add( nome ).add( descricao ).add( categoria ),
                tips      = $( ".validateTips" );


            // Funções para validar campos do formulário
            // Insere uma div de dicas do que deve ser feito para continuar o formulário
            function updateTips( t ) {
                    tips
                            .text( t )
                            .addClass( "ui-state-highlight" );
                            // Tempo de expirição da Atenção
//                    setTimeout(function() {
//                            tips.removeClass( "ui-state-highlight", 1500 );
//                    }, 500 );
            }                
            
            // Checa o tamanho mínimo e máximo de caracteres de cada campo
            function checkLength( o, n, min, max ) {
                    if ( o.val().length > max || o.val().length < min ) {
                            o.parents(".div-input").addClass( "ui-state-error" );
                            updateTips( "O tamanho de " + n + " deve estar entre " +
                                    min + " e " + max + " caracteres." );
                            return false;
                    } else {
                            return true;
                    }
            }

            // Checa se a expressão regular está válida
            function checkRegexp( o, regexp, n ) {
                    if ( !( regexp.test( o.val() ) ) ) {
                            o.parents(".div-input").addClass( "ui-state-error" );
                            updateTips( n );
                            return false;
                    } else {
                            return true;
                    }
            } 
       
            
            // Abre a modal com formulário para cadastro           
            $( "#modal-addArquivo" ).dialog({
                resizable: false,
                height:    440,
                width:     400,
                modal:     true,
                buttons:
                {
                    "Upload": function() {
                            var bValid = true;
                            campos.removeClass( "ui-state-error" );

                            bValid = bValid && checkLength( nome, "Nome", 5, 30 );

                            bValid = bValid && checkRegexp( nome, /[a-zA-Z0-9]/, "Campo deve conter apenas letras e números." );
                            //bValid = bValid && checkRegexp( categoria, /\s/, "Escolha alguma categoria." );

                            // SE O bValid for true, faz o submit no formulário
                            if ( bValid ) {
                                    $("#form-upload").submit();
                            }
                    },
                    "Fechar": function()
                    {
                            $(this).dialog("close");
                    }
                }                
            //});
            
            //$( "#dialog-mostraUsuario" ).dialog("open");                             
            })
        })
        
    });
    
    
// Nome da Função:            Logout
// Data de Criação da Função: 22/12/2011
// Desenvolvedor:             Rodrigo Alfieri
// Descrição:                 Função para sair do sistema, extranet
// Versão:                    0.0.1

$(function(){
    $("#logout").live("click",function(){
    var action  =   "logout";
    var evento  =   1;  

        $.get("?router=home/js.usuario", {action:action, evento:evento}, function(){
            location.reload();
        })
    })
});

// Nome da Função:            Marcar Arquivo Único
// Data de Criação da Função: 22/12/2011
// Desenvolvedor:             Jorge Nova
// Descrição:                 Função para marcar arquivos na lista
// Versão:                    0.0.1

$(function(){
    $(".marcarArquivo").live("click",function(){               
        
        if ($(this).attr("checked")) {
            $(this).attr("checked", "checked");  
            $(this).parents("li").addClass("selected");
        }
        else {
            $(this).removeAttr("checked");
            $(this).parents("li").removeClass("selected");
        }        
    })
});


// Nome da Função:            Marcar Arquivos Geral
// Data de Criação da Função: 23/12/2011
// Desenvolvedor:             Jorge Nova
// Descrição:                 Função para marcar todos os arquivos da lista
// Versão:                    0.0.1

 $(function(){
     
    $(".marcarArquivos").live("click",function(){

        var $this = $('ul.lista-arquivos').find("li").find(".marcarArquivo");

        if ($this.attr("checked")) 
        {           
           $this.removeAttr("checked");
           $this.parents("li").removeClass("selected");          
        }
        else 
        {
            $this.attr("checked", "checked");
            $this.parents("li").addClass("selected");            
        }

    })
});

// Nome da Função:            Excluir Arquivos
// Data de Criação da Função: 23/12/2011
// Desenvolvedor:             Jorge Nova
// Descrição:                 Função para excluir arquivos marcados
// Versão:                    0.0.1

 $(function(){
     
    $(".excluirArquivos").live("click",function(){

        var $this     = $('ul.lista-arquivos').find("li").find(".marcarArquivo:checked"),
            $contador = $('ul.lista-arquivos').find("li").find(".marcarArquivo:checked").length,
            $valores  = [];
        
        // Preenchendo o array com valores dos itens checados
        $('ul.lista-arquivos').find("li").find(".marcarArquivo:checked").each(function(n){
            $valores[n] = $(this).val();
        });        
        
        if ($this.attr("checked")) 
        {         
            // Insere a estrutura HTML dentro da DIV #dialog-modal, localizada no header.php do sistema
            $("#modal").html("<div id='modal-excluirArquivo' title='Excluir Arquivos' style='display:none;'><div class='padding-padrao-vertical'><p>Você tem certeza que deseja excluir "+$contador+" arquivo(s)?</p></div></div>");         
            
            // Abre a modal           
            $( "#modal-excluirArquivo" ).dialog({
                resizable: false,
                height:    180,
                width:     400,
                modal:     true,
                buttons:
                {
                    "Excluir": function()
                    {                        

//                            for ($i = 0; $i < $contador; $i++)
//                                {
                              $.get("?router=T0067/js.excluir&arquivos="+$valores, function(dados){
                                      if (dados == 1)
                                          {
                                            $(".marcarArquivo:checked").parents("li").remove();                                                     
                                            $( "#modal-excluirArquivo" ).dialog("close");                                              
                                          }
                                      else
                                          {
                                            alert(dados);
                                            $( "#modal-excluirArquivo" ).dialog("close");                                      
                                          }
                              })                            
//                                }
                            //$(".marcarArquivo:checked").parents("li").remove();                                                     
                            //$(this).dialog("close");
                    },                
                    "Fechar": function()
                    {
                            $(this).dialog("close");
                    }
                }                
            })            
                                
        }
        else 
        {
            alert("Selecione algum item para excluir");
        }        
        
    })
});

// Nome da Função:            Excluir Permissão
// Data de Criação da Função: 05/01/2011
// Desenvolvedor:             Jorge Nova
// Descrição:                 Função para excluir permissões dos arquivos, para retirar da lista
// Versão:                    0.0.1

 $(function(){
     
    $(".excluirPermissao").live("click",function(){

        var $this     = $('ul.lista-arquivos').find("li").find(".marcarArquivo:checked"),
            $contador = $('ul.lista-arquivos').find("li").find(".marcarArquivo:checked").length,
            $valores  = [],
            $tipo     = 2,
            $usuario  =  $("#usuario").html();            
        
        // Preenchendo o array com valores dos itens checados
        $('ul.lista-arquivos').find("li").find(".marcarArquivo:checked").each(function(n){
            $valores[n] = $(this).val();
        });        
        
        if ($this.attr("checked")) 
        {         
            // Insere a estrutura HTML dentro da DIV #dialog-modal, localizada no header.php do sistema
            $("#modal").html("<div id='modal-excluirPermissao' title='Excluir Arquivos' style='display:none;'><div class='padding-padrao-vertical'><p>Você tem certeza que deseja excluir "+$contador+" arquivo(s)?</p></div></div>");         
            
            // Abre a modal           
            $( "#modal-excluirPermissao" ).dialog({
                resizable: false,
                height:    180,
                width:     400,
                modal:     true,
                buttons:
                {
                    "Excluir": function()
                    {                        

//                            for ($i = 0; $i < $contador; $i++)
//                                {
                              $.get("?router=T0067/js.excluir&arquivos="+$valores+"&tipo="+$tipo+"&usuario="+$usuario, function(dados){
                                      if (dados == 1)
                                          {
                                            $(".marcarArquivo:checked").parents("li").remove();                                                     
                                            $( "#modal-excluirPermissao" ).dialog("close");                                              
                                          }
                                      else
                                          {
                                            alert(dados);
                                            $( "#modal-excluirPermissao" ).dialog("close");                                      
                                          }
                              })                            
//                                }
                            //$(".marcarArquivo:checked").parents("li").remove();                                                     
                            //$(this).dialog("close");
                    },                
                    "Fechar": function()
                    {
                            $(this).dialog("close");
                    }
                }                
            })            
                                
        }
        else 
        {
            alert("Selecione algum item para excluir");
        }        
        
    })
});

// Nome da Função:            Permissionar Arquivos
// Data de Criação da Função: 02/01/2012
// Desenvolvedor:             Jorge Nova
// Descrição:                 Função para aplicar permissções em arquivos marcados
// Versão:                    0.0.1

 $(function(){
     
    $(".permissionarArquivos").live("click",function(){   
           
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


// Nome da Função:            Função Retorna Usuários AutoComplete
// Data de Criação da Função: 25/11/2011
// Desenvolvedor:             Jorge Nova
// Descrição:                 Função executará um request na base de Usuários para retornar os
// dados uma string NOME - FUNÇÃO - LOGIN, e utilizar em campos autocomplete de busca de usuário
// Versão:                    0.0.1    
   
    $(".buscaUsuario").live("focus",function() 	{
        var tipo = 2;
    
        $('.buscaUsuario').autocomplete(
        {
            source:    "?router=REQUESTS/js.busca&tipo="+tipo,
            minLength: 2
        });
    
    });
 
 
// Nome da Função:            Adicionar Usuário para Select Box
// Data de Criação da Função: 02/01/2011
// Desenvolvedor:             Jorge Nova
// Descrição:                 Funçao irá incluir nome escolhido em um select box multiplo para permissionar usuarios
// 
// Versão:                    0.0.1    
   
    $(".addUsuario").live("click",function(){
        
       // Valor capturado no campo para encontrar o usuário
       var $usuario        =   $(".usuarioPermissao").val();
       
       // Valida se o campo usuário esta preenchido
       if ($usuario != "")
       {
           // SelectBox onde será incluindo o HTML dos usuários escolhidos
           var $select         =   $("#form-permissao").find("#T004_login");

           // Ele procura o HTML do primeiro option
           var $options        =   $("#form-permissao").find("#T004_login").find("option").html();

           // Captura o HRTL já incluso no Select Box multiplo
           var $htmlOptions    =   $("#form-permissao").find("#T004_login").html();

           // Variavel será usado para armazenar os códigos HTMLs a serem inseridos na TAG de variavel $select
           var $string;

           // Faz validação se o primeiro item encontrado é igual a "Adicione os usuários para esse campo!"
           // se True, quer dizer que não havia nenhum usuário escolhido ainda
           if ($options == "Adicione os usuários para esse campo!")
               {
                   // Limpa todos os options 
                   $select.find("option").remove();

                   // Atribui a variavel string o option escolhido pelo campo usuário
                   $string     =   "<option value='"+$usuario+"' selected>"+$usuario+"</option>";                
               }
           else
               {    // se false, quer dizer que já existem usuários no select box multiplo
                    // Concatena as opções já existentes no select box com uma nova opção
                    $string  =   $htmlOptions+
                                 "<option value='"+$usuario+"' selected>"+$usuario+"</option>";
               }



            // Insere o HTML gerado em $string dentro do select box
            $select.html($string);       

            // Limpa o campo de busca de usuário para uma nova busca
            $(".usuarioPermissao").val("");

            // Coloca foco para o campo de busca de usuário
            $(".usuarioPermissao").focus();
       }
       else
       {
            // Alerta o usuário para digitar um usuário no campo de usuário
            alert("Selecione primeiro um usuário válido!");
            
            // Coloca foco para o campo de busca de usuário
            $(".usuarioPermissao").focus();           
           
       }    
        
    });