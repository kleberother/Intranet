<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 19/10/2011 por Jorge Nova
 * Descrição: Programa para transferir (autorizacao de pagamentos), com objetivo de quando a 
 *            AP estiver com o fluxo errado, a pessoa pode enviar a outro fluxo
 * Entradas:  Código AP 
 * Origens:   T0016/home, template/js/interno/T0016/transferir.js
           
**************************************************************************
*/

// Instancia objeto de conexão com as models da T0016
$obj       =   new models_T0016();

// Variáveis do programa
$pagina    =   $_GET['pagina'];         // Página de retorno 
$codigo_ap =   $_GET['valor'];          // Código da AP  
$grupo     =   $_GET['grupo'];          // Grupo Novo de Workflow
$data      =   date('d/m/Y H:i:s');     // Data e Hora do Sistema
$user      =   $_SESSION['user'];       // Usuário da Sessão

// Faz busca do código do fornecedor, loja faturada da AP e criador da AP
$BuscaFornecedor    =   $obj->retornaCodigoFornecedorAP($codigo_ap);

foreach($BuscaFornecedor as $campos=>$valores)
{
    $fornecedor =   $valores['CodigoFornecedor'];   // Código do Fornecedor
    $loja       =   $valores['CodigoLoja'];         // Código da Loja
    $login      =   $valores['Login'];              // Login do usuário que gerou a AP
}

// Faz busca se existe a associação de Fornecedor, Grupo de Workflow e Loja
$BuscaAssociacao    =   $obj->retornaQtdeAssociacao($fornecedor, $grupo, $loja);

foreach($BuscaAssociacao as $campos=>$valores)
{
    $Contador01 =   $valores['Contador'];   // Contador de Associações, pode ser 1 ou 0
}

// Se não encontrar nenhuma associação, fazer o insert na tabela
if ($Contador01 == 0)
{
    // Prepara array para inserir na tabela
    $array01    =   array ( "T026_codigo" => $fornecedor
                          , "T059_codigo" => $grupo
                          , "T006_codigo" => $loja  
                          , "T061_codigo" => 1);
    
    // Objeto de inserção passando a tabela e os campos
    $insGrupo   =   $obj->inserir("T026_T059", $array01);       
    
    // Se a inserção der errado, retorna o valor 0 e finaliza o arquivo
    if (!($insGrupo))
    {
        echo "Não Inseriu o Grupo";
        die;
    }
        
}

// Delimitador que será usado para exclusão de fluxo e alteração de AP
$delim          =   "T008_codigo = ".$codigo_ap;

// Fase para exclusão do fluxo atual

// Exclui o fluxo atual da AP
$excluirFluxo   =   $obj->excluir("T008_T060", $delim);

// Verifica se a exclusão deu certo, caso não, retorna o valor 0 e finaliza o arquivo
if (!($excluirFluxo))
{
    echo "0";
    die;    
}

// Fase para alteração do grupo atual da AP

// Prepara array 02 para alterar o grupo da AP
$array02        =   array("T008_T026T059_T059_codigo" => $grupo);

// Atualiza a AP
$atualizaGrupo  =   $obj->altera("T008_approval", $array02, $delim);

// Verifica se a alteração deu certo, caso não, retorna o valor 0 e finaliza o arquivo
if (!($atualizaGrupo))
{
    echo "0";
    die;    
}

// Busca a etapa que esta o grupo e suas próximas etapas
$Etapa = $obj->retornaEtapaGrupo($grupo);

// faz loop para insersão dos dados
foreach($Etapa as $campos=>$valores)
{
    // Prepara array para inserção
    $array03    =   array ( "T060_codigo"      =>  $valores['EtapaCodigo']
                          , "T008_codigo"      =>  $codigo_ap
                          , "T008_T060_ordem"  =>  1
                          , "T008_T060_status" =>  0
                          , "T004_login"       =>  $login                   );
    
    
    $insere2 = $obj->inserir("T008_T060", $array03);
      
    $insere3 = $obj->TemporariaInserirFluxoAp($codigo_ap, $valores['ProxEtapaCodigo'], 2, $login);

}

if ($insere3)
    echo "1";
else
    echo "0";

?>

<?php
/* -------- Controle de versões - js.trasnferir.php --------------
 * 1.0.0 - 19/10/2011                  --> Liberada versao sem controle de versionamento
 * 
*/
?>