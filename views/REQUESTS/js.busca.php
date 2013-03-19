<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 25/11/2011 por Jorge Nova
 * Descrição: Página para fazer buscas das funções gerais do sistema com AJAX
           
***************************************************************************/

// Instancia Classe de conexão com as models para executar os selects
$obj    =   new models_REQUESTS(); 

// Caputura o tipo de request a ser utilizado
$tipo = $_REQUEST['tipo'];


// Tipos de Request
// 1 -> Função Retorna Dados do Usuário em Modal
// 2 -> Função Retorna Usuários AutoComplete
// 3 -> Função Busca Departamentos da Loja
// 4 -> Função Retorna Fornecedor AutoComplete
// 5 -> Função Retorna Colaboradores AutoComplete
// 6 -> Função Retorna Codigo RMS e Razao Social

if ($tipo == 1)
{
    
    // Caputura o Login e Depatamento do usuário na URL
    $login        = strtolower($_REQUEST['login']); 
    $departamento = strtolower($_REQUEST['departamento']); 
    
    // Retorna Dados do Usuário
    $Usuario  = $obj->retornaDadosUsuario($login,$departamento);
    
    // Retorna contatos do Usuário
    $Contatos = $obj->retornaContatosUsuario($login);    
    
    // Formata o código html dentro da variavel
    $html  = "<div id='dialog-mostraUsuario' title='Dados do Usuário' style='display:none'>";
    $html .= "<div id='conteudo' class='paragrafo-2'>";

    foreach($Usuario as $campos=>$valores)
    {
    // Captura o valor do Email para copiar em Contatos    
    $email = $valores['Email'];    

    $html .= "<div class='div-mestre'>
                <div class='coluna_02_a_tipo_01'>
                    <img src='template/img/usuario.png' alt='' width='96px' height='96px' class='imagem-profile' />
                </div>
                <div class='coluna_02_b_tipo_01'>
                    <div class='div-mestre'>
                        <div class='coluna_02_a_tipo_02'>
                            <table class='tabela-conteudo'>
                                <tr>
                                    <td class='alinhado-esquerda'> <span class='titulo_conteudo_tipo_03'>Matrícula:</span></td> 
                                    <td>                           ".$valores['Matricula']."                              </td>
                                </tr>
                                <tr>
                                    <td class='alinhado-esquerda'> <span class='titulo_conteudo_tipo_03'>Login:</span>        </td>
                                    <td>                          ".$valores['Login']."                                       </td>
                                </tr>
                                <tr>
                                    <td class='alinhado-esquerda'> <span class='titulo_conteudo_tipo_03'>Nome:</span>         </td>
                                    <td>                           ".$valores['Nome']."                                       </td>
                                </tr>
                            </table>                    
                        </div>
                        <div class='coluna_02_b_tipo_02'>
                            <table class='tabela-conteudo'>
                                <tr>
                                    <td class='alinhado-esquerda'> <span class='titulo_conteudo_tipo_03'>Loja:     </span></td>
                                    <td>                          ".$valores['NomeLoja']."                                </td>
                                </tr>
                                <tr>
                                    <td class='alinhado-esquerda'> <span class='titulo_conteudo_tipo_03'>Departamento:</span> </td>
                                    <td>                           ".$valores['NomeDepartamento']."                           </td>
                                </tr>
                                <tr>
                                    <td class='alinhado-esquerda'> <span class='titulo_conteudo_tipo_03'>Função:</span> </td>
                                    <td>                          ".$valores['Funcao']."                                </td>
                                </tr>
                            </table>                    
                        </div> 
                    </div>
                </div>
            </div>";
    }
    
    $html .= "<div class='titulo_contedo_tipo_02'>
                    <p>Contatos</p>
              </div>
              <div class='div-mestre'>
                  <table class='tabela-conteudo'>";
                      foreach($Contatos as $campos=>$valores)
                      {        
                       $html .= "<tr>
                                    <td class='alinhado-esquerda'> <span class='titulo_conteudo_tipo_03'>".$valores['TipoFone']."</span></td>
                                    <td>                           + ".$valores['CodPais']." ".$valores['CodArea']." ".$valores['NumeroFone']."                                           </td>
                                 </tr>";            
                      }

    $html .= "<tr>
              <td class='alinhado-esquerda'> <span class='titulo_conteudo_tipo_03'>E-mail</span> </td>
              <td>                           ".$email."                                          </td>
          </tr>                
          </table>
          </div>
          </div>
          </div>";           
    
    // Retorna o código html para imprimir dentro da div de modais
    echo $html;
    
}

else if ($tipo == 2)
{
    
    //busca valor digitado no campo autocomplete "$_GET['term']
    $nome = mysql_real_escape_string($_GET['term']);

    // Busca o os nomes de usuários com tal nome
    $Usuarios = $obj->retornaUsuarios($nome);

    // prepara o array de resultados
    $json  = '[';
    $first = true;

    foreach($Usuarios as $campos=>$valores){

      if ($valores['Funcao'] == "")
          $valores['Funcao'] = 'Cargo não informado';

      if (!$first) { $json .=  ','; } else { $first = false; }
      $json .= '{"value":"'.$valores['Nome'].
//               " - ".$valores['Funcao'].
               " - ".$valores['Login'].'"}';    
    }

    $json .= ']';

    // Imprimi o array na função java script
    echo $json;
    
}

else if ($tipo == 3)
{
    //  Captura a loja escolhida no select box .selecionaLoja
    $loja   =   $_REQUEST['loja'];

    // Busca Departamentos associados a loja
    $Departamentos = $obj->retornaDepartamentos($loja);

    // Prepara o html a ser impresso no Select Box .retornaDepartamentos
    foreach($Departamentos as $campos=>$valores)
    {
        $html  .= "<option value=".$valores['Codigo'].">".$obj->preencheZero("E", 2, $valores['Codigo'])." - ".$valores['Nome']."</option>";
    }

    // Retorno para o jQuery
    echo json_encode($html);
    
}

else if ($tipo == 4)
{
    
    //busca valor digitado no campo autocomplete "$_GET['term']
    $nome = mysql_real_escape_string($_GET['term']);

    // Busca o os nomes de fornecedores com tal nome
    $Fornecedor = $obj->retornaFornecedor($nome);

    // prepara o array de resultados
    $json  = '[';
    $first = true;

    foreach($Fornecedor as $campos=>$valores){

      if (!$first) { $json .=  ','; } else { $first = false; }
      $json .= '{"value":"'.$valores['Codigo'].
               " - ".$valores['RazaoSocial'].'"}';    
    }

    $json .= ']';

    // Imprimi o array na função java script
    echo $json;
    
}

else if ($tipo == 5)
{
    
    //busca valor digitado no campo autocomplete "$_GET['term']
    $nome = mysql_real_escape_string($_GET['term']);

    // Busca o os nomes de usuários com tal nome
    $Usuarios = $obj->retornaColaboradores($nome);

    // prepara o array de resultados
    $json  = '[';
    $first = true;

    foreach($Usuarios as $campos=>$valores){

      if (!$first) { $json .=  ','; } else { $first = false; }
      $json .= '{"value":"'.$valores['Matricula'].
               " - ".trim($valores['Nome']).
               " - ".$valores['NomeLoja'].'"}';    
    }

    $json .= ']';

    // Imprimi o array na função java script
    echo $json;
    
}


?>
