<?php
// Recupera variáveis
$userioLogado = $_SESSION['user'];
$usuario      = $_REQUEST['usuario'];


// Objeto de Conexão
$obj     = new models_T0010();

// Retorna dados do usuário
$Usuario  = $obj->retornaDadosUsuario($usuario);
$Contatos = $obj->retornaContatosUsuario($usuario);


?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0010/home">Listar</a></li>
            </ul>
        </span>
    </div>
</div>

<div id="conteudo" class="paragrafo-2">
    <?php
    foreach($Usuario as $campos=>$valores)
    {
    // Captura o valor do Email para copiar em Contatos    
    $email = $valores['Email'];    
    ?>    
    <div class="div-mestre">
        <div class="coluna_02_a_tipo_01">
            <img src="template/img/usuario.png" alt="" width="96px" height="96px" class="imagem-profile" />
        </div>
        <div class="coluna_02_b_tipo_01">
            <div class="div-mestre">
                <div class="coluna_02_a_tipo_02">
                    <table class="tabela-conteudo">
                        <tr>
                            <td class="alinhado-esquerda"> <span class="titulo_conteudo_tipo_03">Matrícula:</span></td> 
                            <td>                           <?php echo $valores['Matricula']; ?>                  </td>
                        </tr>
                        <tr>
                            <td class="alinhado-esquerda"> <span class="titulo_conteudo_tipo_03">Login:</span>        </td>
                            <td>                          <?php echo $valores['Login']; ?>                           </td>
                        </tr>
                        <tr>
                            <td class="alinhado-esquerda"> <span class="titulo_conteudo_tipo_03">Nome:</span>   </td>
                            <td>                          <?php echo $valores['Nome']; ?>                      </td>
                        </tr>
                    </table>                    
                </div>
                <div class="coluna_02_b_tipo_02">
                    <table class="tabela-conteudo">
                        <tr>
                            <td class="alinhado-esquerda"> <span class="titulo_conteudo_tipo_03">Loja:     </span></td>
                            <td>                          <?php echo $valores['NomeLoja']; ?>                    </td>
                        </tr>
                        <tr>
                            <td class="alinhado-esquerda"> <span class="titulo_conteudo_tipo_03">Departamento:</span> </td>
                            <td>                          <?php echo $valores['NomeDepartamento']; ?>                </td>
                        </tr>
                        <tr>
                            <td class="alinhado-esquerda"> <span class="titulo_conteudo_tipo_03">Função:</span> </td>
                            <td>                          <?php echo $valores['Funcao']; ?>                    </td>
                        </tr>
                    </table>                    
                </div> 
            </div>
        </div>
    </div>
    <?php
    }
    ?>    
    <div class="titulo_contedo_tipo_02">
        <p>Contatos</p>
    </div>
    <div class="div-mestre">
        <table class="tabela-conteudo">
            <?php
            foreach($Contatos as $campos=>$valores)
            {    
            ?>        
                <tr>
                    <td class="alinhado-esquerda"> <span class="titulo_conteudo_tipo_03"><?php echo $valores['TipoFone']; ?></span></td>
                    <td>                          <?php echo "+ ".$valores['CodPais']." ".$valores['CodArea']." ".$valores['NumeroFone']; ?>                                           </td>
                </tr>            
            <?php
            }
            ?>  
            <tr>
                <td class="alinhado-esquerda"> <span class="titulo_conteudo_tipo_03">E-mail</span> </td>
                <td>                          <?php echo $email; ?>                                </td>
            </tr>                
        </table>
   </div>
</div>

     
