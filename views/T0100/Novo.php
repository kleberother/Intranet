<?php
//Chama classes

//Classe para Usuarios
$obj            =  new models_T0100();

//Combo Loja
$loja           =  $obj->retornaLoja(); 

$tabela         =  "T100_meta_ge";

$mes            =   $_POST['T100_mes'];
$ano            =   $_POST['T100_ano'];



if (!is_null($_POST))
{
    $obj->inserir($tabela, $_POST);
    //header('location:?router=T0100/home');
}

$user   =   $_SESSION['user'];  

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0100/home">Listar</a></li>
                <li><a href="?router=T0100/novo" class="active">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
 <div id="formulario">
     
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
     
        
    <form action="" method="post" id="formCad">
        
      
        <label class="label">Loja*</label>
            <select name="T006_codigo"  id="pai">
            <option value="">Selecione..</option>
        <?php foreach($loja as $campos=>$valores){?>
            <option value="<?php echo $valores['LojaCodigo']?>"><?php echo $obj->preencheZero("E", 3, $valores['LojaCodigo'])."-".$valores['LojaNome']?></option>
        <?php }?>
        </select>
      
        <div class="c02_tipo_a_01">        
           <label class="label">Mês</label>
        <select name="T100_mes" id="mes" >    
             <option value=""</option>
             <option value="01"<?php echo $mes=="01"?"selected":""?>>01</option>
             <option value="02"<?php echo $mes=="02"?"selected":""?>>02</option>
             <option value="03"<?php echo $mes=="03"?"selected":""?>>03</option>
             <option value="04"<?php echo $mes=="04"?"selected":""?>>04</option>
             <option value="05"<?php echo $mes=="05"?"selected":""?>>05</option>
             <option value="06"<?php echo $mes=="06"?"selected":""?>>06</option>
             <option value="07"<?php echo $mes=="07"?"selected":""?>>07</option>
             <option value="08"<?php echo $mes=="08"?"selected":""?>>08</option>
             <option value="09"<?php echo $mes=="09"?"selected":""?>>09</option>
             <option value="10"<?php echo $mes=="10"?"selected":""?>>10</option>
             <option value="11"<?php echo $mes=="11"?"selected":""?>>11</option>
             <option value="12"<?php echo $mes=="12"?"selected":""?>>12</option>
         </select>
       </div>
 
        
       <div class="c02_tipo_a_02">
         <label class="label">Ano</label>
         <select name="T100_ano" id="ano">
             <option value=""</option>
             <option value="2012"<?php echo $ano=="2012"?"selected":""?>>2012</option>
             <option value="2013"<?php echo $ano=="2013"?"selected":""?>>2013</option>
             <option value="2014"<?php echo $ano=="2014"?"selected":""?>>2014</option>
             <option value="2015"<?php echo $ano=="2015"?"selected":""?>>2015</option>
             <option value="2016"<?php echo $ano=="2016"?"selected":""?>>2016</option>
             <option value="2017"<?php echo $ano=="2017"?"selected":""?>>2017</option>
             <option value="2018"<?php echo $ano=="2018"?"selected":""?>>2018</option>
             <option value="2019"<?php echo $ano=="2019"?"selected":""?>>2019</option>
             <option value="2020"<?php echo $ano=="2020"?"selected":""?>>2020</option>
             <option value="2021"<?php echo $ano=="2021"?"selected":""?>>2021</option>
             <option value="2022"<?php echo $ano=="2022"?"selected":""?>>2022</option>
         </select>
       </div>
                
                
        <label class="label">Quantidade Meta</label>
        <input type="text"      name="T100_quantidade"   id="titulo" class=""       />
        
        <label class="label">Valor Meta*</label>
        <input type="text"      name="T100_meta"         id="nome"   class="valor"  />
        
        <input type="hidden"    name="T004_login"   value="<?php echo $user;?>"      />
        
        <div class="form-inpu-botoes">
            <input type="submit"            value="Criar" />
        </div>
    </form>
</div>

