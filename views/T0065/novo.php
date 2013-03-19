<?php
//Chama classes
$obj = new models_T0065();

// Verifica se o POST está vazio, caso não faz os inserts nas tabelas T077_departamento e T006_T077
//if (!empty($_POST))
//{
//    // Tebelas para inserir
//    $tabela01 = "T077_departamento";
//    $tabela02 = "T006_T077";
//      
//    // Monta primeiro array para inserção
//    
//    // T077_departamento = array01
//    $array01 = array ( "T077_nome"=>$_POST['T077_nome']
//                     , "T077_desc"=>$_POST['T077_desc']);
//    
//    // Insere dados
//    $insert01 = $obj->inserir($tabela01, $array01);
//    
//    // Verifica se o primeiro insert deu certo
//    if ($insert01)
//    {    
//        // Busca o ID do último departamento inserido na tabela
//        $DepartamentoId = $obj->lastInsertId();
//                
//        // Formata a string de T004_login para deixar apenas o login
//        $arrayLogin = explode("-",$_POST['T004_login']);
//        // Iguala o T004_login para a ultima posição após separar a string em traços ex: JORGE NOVA - WEB DESIGNER - JNOVA
//        $owner = trim($arrayLogin[2]);     
//        
//        // Monta 2 array para inserir
//        $array02 = array ( "T004_login"=>$owner
//                         , "T077_codigo"=>$DepartamentoId
//                         , "T006_codigo"=>$_POST['T006_codigo']);
//        
//        // Insere dados
//        $insert02 = $obj->inserir($tabela02, $array02);
//
//        // Verifica se o segundo insert deu certo T006_T077
//        if ($insert02)
//        {
//            header('location:?router=T0033/home');            
//        }
//        else
//        { // Erro ao inserir na tabela T006_T0077
//            echo "<script>alert('ERRO AO CADASTRAR');</script>";                 
//            echo "<script>window.location='?router=T0033/home';</script>";                 
//        }
//    }
//    else
//    { // Erro ao inserir na tabela T077_departamento
//        echo "<script>alert('ERRO AO CADASTRAR');</script>";                 
//        echo "<script>window.location='?router=T0033/home';</script>";   
//    }
//} 

$user  = $_SESSION['user'];

?>
<script type="text/javascript" src="template/js/interno/T0065/T0065.js"></script>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0033/home">Listar</a></li>
                <li><a href="?router=T0033/novo" class="active">Novo</a></li>
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
        <label class="label">Nome*</label>
        <input type="text" name="T077_nome"  id="nome" class="validate[required,maxSize[20]] form-input-text" />
        <label class="label">Owner*</label>
        <input type="text" name="T004_login" id="nome_usuario" class="validate[required] form-input-text nome_usuario" />
        <label class="label">Loja*</label>
        <select name="T006_codigo" id="loja" class="validate[required] form-input-text loja">
            <option value="">Selecione...</option>
            <?php
            $lojas = $obj->retornaLojas();
            
            foreach($lojas as $campos=>$valores)
            {
            ?>
            <option value="<?php echo $valores['Codigo']; ?>"><?php echo $obj->preencheZero("E", 3, $valores['Codigo'])." - ".$valores['Nome']; ?></option>
            <?php
            }
            ?>
        </select>
        <label class="label">Descrição</label>
        <textarea name="T077_desc" id="desc"></textarea>
        <div class="form-inpu-botoes">
            <input type="submit" value="Criar" />
        </div>
    </form>
    </span>
</div>

