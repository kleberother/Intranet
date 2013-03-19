// Data de Criação: 24/11/2011 
// Descrição:      Funções Gerais do Sistema, que executam um request no banco e retornam resultados
// Desenvolvedor:  Jorge Nova

// Nome da Função:            Atribuição de nomes para os elementos
// Data de Criação da Função: 21/12/2011
// Desenvolvedor:             Jorge Nova
// Descrição:                 Todos os elementos que deverão ser utilizados no sistema serão informados nessa área
// Versão:                    0.0.1

$(function() {   
//        $(".botao-padrao").live("click",function(event) {
//            event.preventDefault();
//            $(this).submit();
//            
//        })
        // Botões do Sistema
        // 
        //$( "input:submit, button").button();
        
        // Href com estilo dos botões
        $( "a",".botao-jquery-padrao").button();
        
        $( "a",".botao-jquery-padrao" ).click(function() {return false;});
        
        // Abas do sistema
	$( "#abas" ).tabs();     
        
        // Máscaras de campos
        $(".cpf").mask("999.999.999-99");          //CPF
        
        //Trata CPF
        $('.cpf').live("blur", function(){
            var $this   =   $(this);
            var cpf     =   $this.val();
            if (cpf!="___.___.___-__")
                {
                    $.get("?router=REQUESTS/js.validaCpf",{campocpf:cpf},function(retorno){
                        if (retorno!=1)
                        {
                            show_stack_bottomleft(true, 'Erro!', 'CPF Inválido!');                
                            $this.val("");   
                            $this.focus();                
                        }             
                    })
                }

        });        

        
        $(".cnpj").mask("99.999.999/9999-99");     //CNPJ        
                             
// Nome da Função:            Abrir Div de Filtros
// Data de Criação da Função: 11/01/2012
// Desenvolvedor:             Jorge Nova
// Descrição:                 Abrirá a div de filtros
// Versão:                    0.0.1

    $(".abrirFiltros").live("click",function(){
        
        var $div_filtro     = $(".div-filtro").find("form");
        
        $div_filtro.toggle("fast");
                                     
    });   
        
                
// Nome da Função:            Retorna Dados do Usuário Modal
// Data de Criação da Função: 24/11/2011
// Desenvolvedor:             Jorge Nova
// Descrição:                 Função executará um request na base de Usuários e Fones, 
// para retornar os dados gerais do usuário, toda a informação aparecerá em uma Caixa de Dialogo Modal
// Versão:                    0.0.1
    
    $(".dadosUsuario").live("click",function(){
        var login          =  $(this).find(".Login").html();           
        var departamento   =  $(this).find(".Departamento").html();           
        var tipo           =  1;
               
        $.get("?router=REQUESTS/js.busca&login="+login+"&departamento="+departamento+"&tipo="+tipo, function(dados){
            
            // Insere a estrutura HTML dentro da DIV #dialog-modal, localizada no header.php do sistema
            $("#dialog-modal").html(dados);
            
            // Abre a modal           
            $( "#dialog-mostraUsuario" ).dialog({
                resizable: false,
                height:    400,
                width:     600,
                modal:     true,
                buttons:
                {
                    "Fechar": function()
                    {
                            $(this).dialog("close");
                    }
                }                
            });
            
            //$( "#dialog-mostraUsuario" ).dialog("open");
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
  
// Nome da Função:            Função Busca Departamentos da Loja
// Data de Criação da Função: 25/11/2011
// Desenvolvedor:             Jorge Nova
// Descrição:                 Função será ativa quando a classe .selecionaLoja no select box, 
// retorna no select box .retornaDepartamentos a lista de departamentos associados a loja escolhida 
// Versão:                    0.0.1  

    $(".selecionaLoja").live("change",function(){
        var loja       =   $(".selecionaLoja").val();
        var tipo       =   3;

        $.getJSON("?router=REQUESTS/js.busca&loja="+loja+"&tipo="+tipo, function(dados){
           $('.retornaDepartamentos').html(dados);
        });
    })    


// Nome da Função:            Função Retorna Fornecedor AutoComplete
// Data de Criação da Função: 29/12/2011
// Desenvolvedor:             Jorge Nova
// Descrição:                 Função executará um request na base de Fornecedores para retornar os
// dados uma string NOME - CNPJ, e utilizar em campos autocomplete de busca de fornecedor
// Versão:                    0.0.1    
   
    $(".buscaFornecedor").live("focus",function() 	{
        var tipo = 4;
    
        $('.buscaFornecedor').autocomplete(
        {
            source:    "?router=REQUESTS/js.busca&tipo="+tipo,
            minLength: 2
        });
    
    });
    
// Nome da Função:            Função Retorna Colaborador AutoComplete
// Data de Criação da Função: 23/01/2012
// Desenvolvedor:             Jorge Nova
// Descrição:                 Função executará um request na tabela de Colaboradores retornando os
//                            dados uma string MATRÍCULA - NOME - LOJA
// Versão:                    0.0.1    
   
    $(".buscaColaborador").live("focus",function() 	{
        var tipo = 5;
    
        $('.buscaColaborador').autocomplete(
        {
            source:    "?router=REQUESTS/js.busca&tipo="+tipo,
            minLength: 2
        });
    
    });    

// Nome da Função:            Aprovar Item Workflow
// Data de Criação da Função: 03/02/2012
// Desenvolvedor:             Rodrigo Alfieri
// Descrição:                 Chama página js.aprovar
// Versão:                    1.0.0    

    $(".Aprovar").live("click",function(event){
        event.preventDefault();
        var hashes      =   window.location.href.slice(window.location.href.indexOf('?') +1).split('/');    //captura url
        var url         =   "?"+hashes[0]+"/js.aprovar";                                                    //url js.aprovar        
        var linha       =   $(this).parents(".dados");                                                      //parametro do item a ser aprovado
        var parametros  =   linha.find(".parametros").text();                                               //parametro do item a ser aprovado
        
        $("#dialog-aprovar").dialog
        ({
                resizable: false,
                height:140,
                modal: true,
                buttons:
                {
                        Aprovar: function()
                        {
                            $.post(url,{parametros:parametros})
                                .success(function() { 
                                    linha.remove();
                                    show_stack_bottomleft(false, 'Alerta!', 'Aprovado(a) com Sucesso!'); 
                                })
                                .error(function() {show_stack_bottomleft(true, 'Erro!', 'Não foi possível Aprovar!');});
                                
                            $(this).dialog("close");
                        }
                        ,
                        Cancelar: function()
                        {
                            $(this).dialog("close");
                        }
                }                     

        });
    });   
    
// Nome da Função:            CheckBox para Selecionar Vários Itens
// Data de Criação da Função: 06/02/2012
// Classes Utilizadas:        dados, chkSelecionaTodos, chkItem
// Desenvolvedor:             Rodrigo Alfieri
// Descrição:                 Chama página js.aprovar
// Versão:                    1.0.0        
    
    $(".chkSelecionaTodos").live("click",function(){
        var $this = $(".dados").find(".chkItem");
        if ($(this).attr("checked")) {
            $this.attr("checked", "checked");  
        }
        else {
            $this.removeAttr("checked");
        }        
    })        

// Nome da Função:            Aprovar todos itens selecionados
// Data de Criação da Função: 06/02/2012
// Classes Utilizadas:        aprovarTodos, dados, chkItem
// Desenvolvedor:             Rodrigo Alfieri
// Descrição:                 Chama página js.aprovar
// Versão:                    1.0.0        
 
    $(".aprovarSelecionados").live("click", function(event){
        event.preventDefault();
        var hashes      =   window.location.href.slice(window.location.href.indexOf('?') +1).split('/');    //captura url
        var url         =   "?"+hashes[0]+"/js.aprovar";                                                    //url js.aprovar        
        var $this       =   $(".dados").find(".chkItem");                                                   //this para checkbox        
        var parametros  =   new Array();                                                                    //variavel array com os parametros
        //Verifica se item está marcado/selecionado
        if($this.is(':checked'))
        {
            $(".chkItem:checked").each(function(){
                //preenche array parametro com o valor do checkbox
                parametros.push($(this).val());
            });
                              
            //abre caixa de dialogo
            $("#dialog-aprovar").dialog
            ({
                    resizable: false,
                    height:140,
                    modal: true,
                    buttons:
                    {
                            Aprovar: function()
                            {      
                                //chama página js.aprovar
                                $.post(url,{parametros:parametros})   
                                    .success(function() {
                                        if($this.is(':checked'))
                                        {
                                            $(".chkItem:checked").each(function(){
                                                $(this).parents(".dados").remove();
                                            });
                                        }                                      
                                        show_stack_bottomleft(false, 'Alerta!', 'Aprovados(as) com Sucesso!'); 
                                    })
                                    .error(function() {show_stack_bottomleft(true, 'Erro!', 'Não foi possível Aprovar!');});

                                $(this).dialog("close");
                            }
                            ,
                            Cancelar: function()
                            {
                                $(this).dialog("close");
                            }
                    }                     
            });        
        }else{
            show_stack_bottomleft(true, 'Alerta!', 'Não há itens selecionado(s) para Aprovar!'); 
        }
    });
 
 
$(".Upload").live("click", function(event){
    event.preventDefault();
    var linha       =   $(this).parents(".dados");                                                      
    var parametros  =   linha.find(".parametros").text();                                               
    $("#dialog-upload-arquivo").dialog
    ({
            resizable: false,
            height:500,
            width:500,
            modal: true,
            buttons:
            {
                    Upload: function()
                    {   
                        $("#iframeUploadArquivo").contents().find("#form-upload-arquivo").append("<input type='hidden' value='"+parametros+"' class='parametros'/>");
                        $("#iframeUploadArquivo").contents().find("#form-upload-arquivo").submit();                       
                        //$(this).dialog("close");
                    }
                    ,
                    Cancelar: function()
                    {
                        $(this).dialog("close");
                    }
            }                     
    }); 
}) 
// Nome da Função:            Caixa de Aprovações do Usuário            
// Data de Criação da Função: 19/03/2012
// Desenvolvedor:             Rodrigo Alfieri
// Versão:                    1.0.0           
           
            $.get("?router=home/js.parametro",{codigoParametro:5},function(valorParametro){
                var timeRefresh =   (valorParametro*60)*1000;
                setInterval(function(){
                            var existePendente  =   false;
                            $.getJSON("?router=home/js.caixaAprovacoes", function(dados){                
                                if(dados!="0")
                                    {
                                        $.each(dados, function(i, item){
                                            if (i    ==  "QtdeApPendente"){
                                                if(item!=0)
                                                    existePendente = true;
                                                    $("#ApPendente").text(item);
                                            }else if (i    ==  "QtdeApAnteriores"){
                                                $("#ApAbaixo").text(item);
                                            }else if (i    ==  "QtdeApForaPrazo"){
                                                $("#ApForaPrazo").text(item);
                                            }else if (i    ==  "QtdeApDentroPrazo"){
                                                $("#ApDentroPrazo").text(item);
                                            }else if (i    ==  "QtdeDespesaPendente"){
                                                if(item!=0)
                                                    existePendente = true;
                                                    $("#DespesaPendente").text(item);
                                            }else if (i    ==  "QtdeDespesaAnteriores"){
                                                $("#DespesaAbaixo").text(item);
                                            }
                                        });                            

                                        if(existePendente)
                                            {
                                                $("#dialog-form3").dialog
                                                ({
                                                        resizable: false,
                                                        height:300,
                                                        width:270,
                                                        draggable: false,
                                                        modal: true,
                                                        buttons:
                                                        {
                                                            Fechar: function()
                                                            {
                                                                $(this).dialog("close");
                                                            }
                                                        }                     
                                                });                                  
                                            }                       
                                    }              
                            });                                       
                        },timeRefresh);  
            });  
        
        
/*=================== FIM jQuery =========================*/    
});    


