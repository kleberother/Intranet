<?php 

// Instancia conexão com a models do programa 67
$obj    =  new models_T0067($conn);

// Define na variavel usuário com o session user
$user   = $_SESSION['user'];

//Variavel retorna todos os tipos de arquivos para listar o filtro de tipo de arquivo
//$TipArq = $obj->retornaTipoArquivos();


?>

<!-- Div para capturar o valor de usuário e preecher no formulário de upload -->
<div id="usuario" style="display: none;">
<?php echo $user; ?>
</div>

<!-- Div para capturar o valor de categorias de arquivos e preecher no formulário -->
<!--<div id="select-categoria-de-arquivos" style="display: none;">
<?php //foreach($TipArq as $campos=>$valores){?>
<option value="<?php //echo $valores['Codigo']?>"><?php //echo ($valores['Nome'])?></option>
<?php //}?>  
</div>-->

<?php


$Arquivos           = $obj->retornaArquivos($user);
$ArquivosPermissao  = $obj->retornaArquivosComPermissao($user);

?>


<!-- Div onde inicia o programa -->
<div id="abas">
    <ul>
        <li><a href="#aba-1">Adicionados por mim</a></li>
        <li><a href="#aba-2">Adicionados para mim</a></li>
    </ul>
    <div id="aba-1">
        <div class="caixa-de-ferramentas padding-padrao-vertical">
            <ul class="lista-horizontal">
                <li><a href="#" class="addArquivo           botao-padrao"><span class="ui-icon ui-icon-plus"  ></span>Adicionar Arquivo                  </a></li>
<!--                <li><a href="#" class="permissionarArquivos botao-padrao"><span class="ui-icon ui-icon-locked"></span>Permissionar Arquivo               </a></li>-->
<!--                <li><a href="#" class="marcarArquivos       botao-padrao"><span class="ui-icon ui-icon-check" ></span>Marcar\Desmarcar todos os Arquivos </a></li>-->
<!--                <li><a href="#" class="excluirArquivos      botao-padrao"><span class="ui-icon ui-icon-trash" ></span>Excluir                            </a></li>-->
            </ul>
        </div>
        <div class="padding-padrao-vertical">
<!--            <ul class="menu-tree">
                                <li class="diretorio"><a href="#">Categoria 01</a>
                    <ul class="submenu-tree item">
                        <li><a href="#">Item 01</a></li>
                        <li><a href="#">Item 02</a></li>
                    </ul>                                   
                </li>
                <li class="diretorio"><a href="#">Categoria 02</a>
                    <ul class="submenu-tree item">
                        <li><a href="#">Item 01</a></li>
                        <li><a href="#">Item 02</a></li>
                    </ul>   
                </li>
                <li class="diretorio"><a href="#">Categoria 03</a>
                    <ul class="submenu-tree item">
                        <li><a href="#">Item 01</a></li>
                        <li><a href="#">Item 02</a></li>
                    </ul>    
                </li>        
            </ul>                         -->
            <ul class="lista-arquivos">
                <?php
                foreach($Arquivos as $campos=>$valores)
                {
                 
                    $arquivo    = $obj->preencheZero("E", 8,$valores['Codigo']);
                    $categoria  = $obj->preencheZero("E", 4, $valores['CodCategoria']);
                    $extensao   = $valores['NomeExtensao'];
                    $link    = CAMINHO_ARQUIVOS."CAT".$categoria."/".$arquivo;
                ?>
                <li>
                    <div class="padding-padrao-vertical celula conteudo-visivel">
                        
                        <!-- Div com o checkbox para seleção de arquivos -->
<!--                        <div class="coluna_05_tipo_a_01 margim-5px-horizontal">
                            <input type="checkbox" value="<?php //echo $valores['Codigo']; ?>" name="marcar[]" class="marcarArquivo"/>
                        </div>-->
                        
                        <!-- Div com o nome e link do arquivo para download -->
                        <div class="coluna_05_tipo_a_02 margim-5px-horizontal">
                            <p class="negrito"><a href="?router=T0067/js.file&file=<?php echo $arquivo; ?>&categoria=<?php echo $categoria; ?>&extensao=<?php echo $extensao; ?>" target="_blank"><?php echo $valores['Nome'].".".$valores['NomeExtensao']; ?></a></p>
                        </div>
                        
                        <!-- Div com a descrição do arquivo -->
                        <div class="coluna_05_tipo_a_03 margim-5px-horizontal">
                            <p class="texto-alinhado-justificado"><?php echo $valores['Descricao']; ?></p>
                        </div>
                        
                        <!-- Div com o data de upload do arquivo -->
                        <div class="coluna_05_tipo_a_04 margim-5px-horizontal">
                            <p class="texto-alinhado-meio"><?php echo $valores['DataUp']; ?></p>
                        </div>
                        
                        <!-- Div com o nome das pessoas que podem enxergar esse arquivo -->
<!--                        <div class="coluna_05_tipo_a_05 margim-5px-horizontal">
                                <div class="Scroll-Y div_usuarios_com_permissao">-->
                                    <?php
                                    //$UsuariosPermissao = $obj->retornaUsuariosComPermissao($valores['Codigo']);

                                    //foreach($UsuariosPermissao as $campos2=>$valores2)
                                    //{
                                    ?>
<!--                                    <p><?php //echo $valores2['Nome']; ?></p>-->
                                    <?php
                                    //}
                                    ?>
<!--                                </div> 
                        </div>-->
                    </div>
                </li> 
                <?php
                }
                ?>
            </ul>                         
        </div>
    </div>

    <div id="aba-2">
        <div class="caixa-de-ferramentas padding-padrao-vertical">
            <ul class="lista-horizontal">
                <li><a href="#" class="marcarArquivos       botao-padrao"><span class="ui-icon ui-icon-check" ></span>Marcar\Desmarcar todos os Arquivos </a></li>
                <li><a href="#" class="excluirPermissao     botao-padrao"><span class="ui-icon ui-icon-trash" ></span>Excluir                            </a></li>
            </ul>
        </div>        
        <div class="padding-padrao-vertical">
            <ul class="lista-arquivos">
                <?php
                foreach($ArquivosPermissao as $campos=>$valores)
                {
                 
                    $arquivo    = $obj->preencheZero("E", 8,$valores['Codigo']);
                    $categoria  = $obj->preencheZero("E", 4, $valores['CodCategoria']);
                    $extensao   = $valores['NomeExtensao'];
                    $link    = CAMINHO_ARQUIVOS."CAT".$categoria."/".$arquivo;
                ?>
                <li>
                    <div class="padding-padrao-vertical celula conteudo-visivel">
                        
                        <!-- Div com o checkbox para seleção de arquivos -->
                        <div class="coluna_05_tipo_a_01 margim-5px-horizontal">
                            <input type="checkbox" value="<?php echo $valores['Codigo']; ?>" name="marcar[]" class="marcarArquivo"/>
                        </div>
                        
                        <!-- Div com o nome e link do arquivo para download -->
                        <div class="coluna_05_tipo_a_02 margim-5px-horizontal">
                            <p class="negrito"><a href="?router=T0067/js.file&file=<?php echo $arquivo; ?>&categoria=<?php echo $categoria; ?>&extensao=<?php echo $extensao; ?>" target="_blank"><?php echo $valores['Nome'].".".$valores['NomeExtensao']; ?></a></p>
                        </div>
                        
                        <!-- Div com a descrição do arquivo -->
                        <div class="coluna_05_tipo_a_03 margim-5px-horizontal">
                            <p class="texto-alinhado-justificado"><?php echo $valores['Descricao']; ?></p>
                        </div>
                        
                        <!-- Div com o data de upload do arquivo -->
                        <div class="coluna_05_tipo_a_04 margim-5px-horizontal">
                            <p class="texto-alinhado-meio"><?php echo $valores['DataUp']; ?></p>
                        </div>
                        
                        <!-- nome do usuário dono do arquivo -->
                        <div class="coluna_05_tipo_a_05 margim-5px-horizontal">
                            <p><?php echo $valores['NomeUsuario']; ?></p>
                        </div>
                    </div>
                </li> 
                <?php
                }
                ?>
            </ul>                         
        </div>        
    </div>              
</div>

