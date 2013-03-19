<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 10/01/2012 por Jorge Nova
 * Descrição: Programa para listar todos os usuários cadastrados para usar a extranet
 * Entradas:   
 * Origens:   Menu Sistema
           
**************************************************************************
*/


//Instancia Classe

$obj            =   new models_T0074();

$Usuarios       =   $obj->retornaGrantors($_GET['login']);

if (!empty($_POST))
{
    // Tabela para inserção de novos grantors
    $tabela                 =   "T004_T004";
    
    // Formata o usuário enviado, deixando apenas o login
    $_POST['T004_grantor']  =   $obj->formataLoginAutoComplete($_POST['T004_grantor']);
    
    // Insere os dados
    $insere                 =   $obj->inserir($tabela, $_POST);
    
    // Número do programa
    $numprog                =   "74";

    // Nome do programa
    $nomeprog               =   "ASSOCIAR";  
    
    // Auditoria sobre a ocorrencia de inserção
    if ($insere)
    {
        $ocorrencia =   "USUARIO ".strtoupper($_POST['T004_grantor'])."|INSERT|INSERIU NOVO GRANTOR PARA O USUARIO EXTERNO ".strtoupper($_POST['T004_login']);

        $obj->insereAuditoria($numprog, $nomeprog, $ocorrencia);
    }
    else
    {
        $ocorrencia =   "USUARIO ".strtoupper($_POST['T004_grantor'])."|INSERT|NAO INSERIU NOVO NOVO GRANTOR PARA O USUARIO EXTERNO ".strtoupper($_POST['T004_login']);

        $obj->insereAuditoria($numprog, $nomeprog, $ocorrencia);        
    }       
    
    // Encontra todos os arquivos upados pelo usuário externo
    $arquivos   =   $obj->retornaArquivosUsuario($_POST['T004_login']);
    
           
    // Varre retorno de arquivos encontrados e da permissão para o novo usuário
    foreach($arquivos as $campos=>$valores)
    {
        
        $arrayArquivos   =   array ( "T055_codigo"           => $valores['Codigo']
                                   , "T004_login"            => $_POST['T004_grantor']  
                                   , "T004_T055_visualizar"  => 1
                                   , "T004_T055_alterar"     => 1
                                   , "T004_T055_excluir"     => 0    );

        $obj->inserir("T004_T055",$arrayArquivos);
        
    }
    
    // Redireciona para a o associar setando o login
    header("location:?router=T0074/associar&login=".$_POST['T004_login']);           
}

?>

<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    
    <ul class="lista-horizontal">
        <li><a href="?router=T0074/novo" class="             botao-padrao"><span class="ui-icon ui-icon-plus"     ></span>Novo    </a></li>
        <li><a href="#" class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-filter"   ></span>Filtros </a></li>
        <li><a href="?router=T0074/home" class="botao-padrao"><span class="ui-icon ui-icon-arrowthick-1-w"></span>Voltar  </a></li>
    </ul>
    
</div>

<!-- Div para incluir conteúdo de modal -->
<div id="modal">
    <div id="dialog-confirm" title="Mensagem!" style="display:none">
        <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja excluir este item?</p>
    </div>  
</div>


<!-- Divs com filtros oculta -->
<div class="div-primaria div-filtro">
    <div class="div-filtro-oculto">
        <form>
            <label class="negrito">Pesquisa Dinâmica</label>
            <input type="text" name="search" value="" id="id_search" />
        </form>
    </div>
</div>

<div class="padding-padrao-vertical div-primaria">
    
    <form method="post" action="">
        
        <label class="label">Usuário</label>
        <input type="text" name="T004_grantor" class="buscaUsuario" />
        
        <input type="hidden" name="T004_login" value="<?php echo $_GET['login']; ?>">
        
        <div class="rodape-formulario-botao padding-5px-vertical margin-padrao-vertical">
            <input type="submit" value="Associar" class="botao-padrao" >
        </div>        
        
    </form>
    
</div>

<div class="div-primaria padding-padrao-vertical">
    
    <!-- Cabecalho da Lista - Traz o título das colunas a serem listadas -->
    <ul class="lista-itens-head">
        
        <li>
            <div class="padding-padrao-vertical celula-01 conteudo-visivel">

                <!-- Div com o nome e link do arquivo para download -->
                <div class="coluna c03_tipo_a_01 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Nome</p>
                </div>

                <!-- Div com a descrição do arquivo -->
                <div class="coluna c03_tipo_a_02 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Login</p>
                </div>

                <!-- Div com o data de upload do arquivo -->
                <div class="coluna c03_tipo_a_03 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda">Ações</p>
                </div>

            </div>
        </li> 

    </ul>

    <!-- Corpo da Lista - Traz as linhas de conteúdo retornada pela query -->    
    <ul class="lista-itens-body">    
        <?php
        // Faz a mesma ação para todos os arquivos encontrados
        foreach($Usuarios as $campos=>$valores)
        {
            if ($celula == "celula-02")
                $celula = "celula-03";
            else
                $celula = "celula-02";
        ?>
        
        <!-- Class dados é utilizado pelo quicksearch -->        
        <li class="dados">
            
            <div class="padding-2px-vertical <?php echo $celula; ?> conteudo-visivel">

                <div class="coluna c03_tipo_a_01 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda"><?php echo $valores['Nome']; ?></p>
                </div>

                <div class="coluna c03_tipo_a_02 margim-5px-horizontal">
                    <p class="negrito texto-alinhado-esquerda"><?php echo $valores['Login']; ?></p>
                </div>

                <div class="coluna c03_tipo_a_03 margim-5px-horizontal">
                    <ul class="lista-de-acoes">
                        <li><a href="javascript:excluir('T0074','T0074/home','T004_T004','T004_grantor','<?php echo ($valores['Login']);?>','T004_login','<?php echo $_GET['login']; ?>',2)" title="Excluir"><span class='ui-icon ui-icon-close'></span></a></li>
                    </ul>
                </div>

            </div>
        </li> 
        <?php
        }
        ?>
    </ul>
    
</div>





