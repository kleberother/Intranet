<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 14/09/2011 por Rodrigo Alfieri
 * Descrição: Para cadastro de um novo Painél (TV Digital)
           
***************************************************************************/
?>
<script src='template/js/interno/T0034/mensagens.js'></script>
<script src='template/js/interno/T0034/produtos.js'></script>
<?php

//mostra mensagem
$msg  = $_GET["msg"];
if ($msg == "S")
   echo "<script>show_stack_bottomleft();</script>";
else if ($msg == "N")
   echo "<script>show_stack_bottomleft(true);</script>";

//Instancia Classe
$obj                    =   new models_T0034();

//Retorna Lojas
$Lojas                  =   $obj->listaLojas();
//Retorna temas
$Temas                  =   $obj->retornaTemas();
//Retorna Deptos
$Deptos                 =   $obj->retornaDeptos();
//Loja usuario
$usuario                =   $_SESSION['user'];
$CodigoLojaUsuario      =   $obj->retornaLojaUsuario($usuario);

$tabela = "T078_painel";    

if(!empty($_POST))
{
    //Caso os campos estejam em branco inclui NULL para inserir
    if(empty($_POST['T020_departamento']))
            $_POST['T020_departamento'] = "null";
    if(empty($_POST['T020_secao']))
            $_POST['T020_secao'] = "null";
    if(empty($_POST['T020_grupo']))
            $_POST['T020_grupo'] = "null";
    if(empty($_POST['T020_subgrupo']))
            $_POST['T020_subgrupo'] = "null";
    
    //Inseri na tabela
    $Insert = $obj->inserir($tabela, $_POST);
    header("location:?router=T0034/home");
}
?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0034/home"                >Painéis</a></li>
                <li><a href="?router=T0034/novo"  class="active">Novo   </a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
    <form action="" method="post" id="formCad">
        <label class="label">Cabeçalho*</label>
            <input type="text" name="T078_titulo" id="Cabecalho" class="validate[required]"/>
        <label class="label">Rodapé</label>
            <input type="text" name="T078_rodape" id="Rodape"/>
        <label class="label">Descrição*</label>
            <textarea          name="T078_descricao" id="desc" rows="" cols="" class="validate[required]"></textarea>
        <label class="label">Produtos Própria Seção*</label>
            <div id="radio">
                <input type="radio" id="radio2" name="T078_secao_propria" value="1" class="validate[required]" /><label for="radio2">Sim</label>
                <input type="radio" id="radio1" name="T078_secao_propria" value="0" class="validate[required]" /><label for="radio1">Não</label>                
            </div>
        <label class="label">Loja*</label>
            <select name="T006_codigo" id="loja" class="validate[required] form-input-text-table">
                <option value="">Selecione...</option>
            <?php foreach($Lojas as $campos=>$valores){ ?>
                <option value='<?php echo $valores['Codigo'];?>' <?php echo ($valores['Codigo']==$CodigoLojaUsuario)?"selected":"";  ?>><?php echo $obj->preencheZero("E", 3, $valores['Codigo']); ?> - <?php echo ($valores['Nome']); ?></option>
            <?php }?>
            </select>        
        <label class="label">Template*</label>
            <select name="T076_codigo" id="tema" class="validate[required] form-input-text-table">
                <option value="">Selecione...</option>
            <?php foreach($Temas as $campos=>$valores){ ?>
                <option value='<?php echo $valores['Codigo']; ?>'><?php echo $obj->preencheZero("E", 3, $valores['Codigo']); ?> - <?php echo ($valores['Nome']); ?></option>
            <?php }?>
            </select>         
        <label class="label">Departamento</label>   
            <select name="T020_departamento" id="ProdutoDepartamento" class="form-input-text-table">
                <option value="null">Selecione...</option>
            <?php foreach($Deptos as $campos=>$valores){ ?>
                <option value='<?php echo $valores['Depto']; ?>'><?php echo $obj->preencheZero("E", 3, $valores['Depto']); ?> - <?php echo ($valores['Descricao']); ?></option>
            <?php }?>
            </select>      
        <label class="label">Seção</label>   
            <select name="T020_secao" id="ProdutoSecao" class="form-input-text-table">
                <option value="null"></option>
            </select>  
        <label class="label">Grupo</label>   
            <select name="T020_grupo" id="ProdutoGrupo" class="form-input-text-table">
                <option value="null"></option>
            </select>  
        <label class="label">SubGrupo</label>   
            <select name="T020_subgrupo" id="ProdutoSubGrupo" class="form-input-text-table">
                <option value="null"></option>
            </select>          
        <div class="form-inpu-botoes">
            <input type="submit"            value="Criar" />
        </div>
    </form>
    </span>
</div>
<?php
/* -------- Controle de versões - tema.php --------------
 * 1.0.0 - 14/09/2011   --> Liberada a versão
*/
?>
