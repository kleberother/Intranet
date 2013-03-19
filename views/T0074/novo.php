<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 10/01/2012 por Jorge Nova
 * Descrição: Programa para incluir os usuários que deverá usar a extranet
 * Entradas:   
 * Origens:   Menu Sistema
           
**************************************************************************
*/



//Instancia Classe
$obj                =   new models_T0074();

$grantor            =   $_SESSION['user'];

$data               =   date('d/m/Y H:i:s');


if (!empty($_POST))
{       
    
    // Senha Dinâmica
    //$senha                  =   $obj->gerarSenha();
    $senha                  =   "123mudar";
    
    $_POST['T004_senha']    =   md5($senha);    
    
    $_POST['T004_cpf']      =   $obj->retiraMascara($_POST['T004_cpf']);
    
    $tabela                 =   "T004_usuario";
    
    $insere                 =   $obj->inserir($tabela, $_POST);
      
    // Número do programa
    $numprog                =   "74";

    // Nome do programa
    $nomeprog               =   "NOVO";  
    
    // Auditoria sobre a ocorrencia de inserção
    if ($insere)
    {
        $ocorrencia =   "USUARIO ".strtoupper($_POST['T004_login'])."|INSERT|INSERIU NOVO USUARIO EXTERNO NO SISTEMA NA TABELA T004_USUARIO";

        $obj->insereAuditoria($numprog, $nomeprog, $ocorrencia);
    }
    else
    {
        $ocorrencia =   "USUARIO ".strtoupper($_POST['T004_login'])."|INSERT|NAO CONSEGUIU INSERIR NA TABELA T004_USUARIO";

        $obj->insereAuditoria($numprog, $nomeprog, $ocorrencia);        
    }     

    // Prepara email para envio de dados do usuário e senha
    
    //$para       =   $_POST["T004_email"];
    $para       =   "web@davo.com.br";
    
    $assunto    =   "Acesso a Extranet D´avó";
    
    $mensagem   =   'Novo usuário criado por '.$_POST['T004_grantor'].PHP_EOL.
                    '--------------------------------------------------------'.PHP_EOL.
                    'DADOS DO USUÁRIO'.PHP_EOL.
                    '--------------------------------------------------------'.PHP_EOL.
                    'Nome do Usuário: '. $_POST['T004_nome'] . PHP_EOL . 
                    'E-mail: '. $_POST['T004_email'] . PHP_EOL . 
                    'Login: '. $_POST['T004_login'] . PHP_EOL . 
                    'Senha: '. $senha . PHP_EOL; 
    
 
    $cabecalho = "From: Extranet Davo <extranet@davo.com>.br\r\n";
    $cabecalho .= "MIME-Version: 1.0\r\n"; 
    $cabecalho .= "Content-type: text/plain; charset=utf-8\r\n";
    $cabecalho .="Content-Transfer-Encoding: 8bit";    
    
    $email      =   mail($para, $assunto, $mensagem, $cabecalho);
     
    
    header('location:?router=T0074/home');    
}

?>

<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="?router=T0074/novo" class="botao-padrao"><span class="ui-icon ui-icon-plus"            ></span>Novo    </a></li>
        <li><a href="?router=T0074/home" class="botao-padrao"><span class="ui-icon ui-icon-arrowthick-1-w"  ></span>Voltar  </a></li>
    </ul>
</div>

<div class="div-primaria padding-padrao-vertical">
    <form action="" method="post" id="formCad">
        
        <label class="label">Nome</label>
        <input type="text" name="T004_nome"     />
        
        <label class="label">Login</label>
        <input type="text" name="T004_login" maxlength="8"    />
        
        <label class="label">E-mail</label>
        <input type="text" name="T004_email"    class="validate[required,custom[email]]"    />
        
        <label class="label">CPF</label>
        <input type="text" name="T004_cpf"      class="cpf"      />
        
        <input type="hidden"    name="T004_grantor"               value="<?php echo $grantor; ?>"                 />
        <input type="hidden"    name="T004_funcao"                value="<?php echo "Automático - Extranet"; ?>"  />
        <input type="hidden"    name="T004_permissao_arquivo"     value="1"                                       />

        
        <div class="rodape-formulario-botao padding-5px-vertical margin-padrao-vertical">
            <input type="submit" value="Salvar" class="botao-padrao" >
        </div>
        
    </form>
</div>





