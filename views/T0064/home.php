<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 21/11/2011 por Jorge Nova                              
 * Descrição: Listagem de todos os departamentos mostrando a loja, 
 * owner e colaboradores pertencentes a esse departamento
 * Entrada:   
 * Origens:   
           
**************************************************************************
 */

//Captura usuário da session
$user          = $_SESSION['user'];

// Classe para Usuarios
$obj           = new models_T0064();

// Captura dados para filtro
$filtroLoja = $_POST['filtroLoja'];
$filtroDPTO = $_POST['filtroDepartamento'];

//Retorna lista de departamentos
$Departamentos = $obj->retornaDepartamentos($filtroLoja,$filtroDPTO);

// Retorna Lista das lojas para filtro
$SelectLojas         = $obj->retornaLojas();

// Retorna Lista das lojas para departamentos
$SelectDepartamentos = $obj->retornaDptoFiltros();

?> 
<div id="ferramenta"> 
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0064/home" class="active">Listar</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="tabs">
    <ul>
        <li><a href="#tabs-2">Filtro Dinâmico</a></li>
    </ul>
    <div id="tabs-2">
        <form action="" method="post">
        <div id="formulario">
            <span  class="form-input">            
            <table class="form-inpu-tab">
                <thead>
                    <tr>
                        <th><label>Filtro Dinâmico</label></th>
                        <th><label>Loja</label></th>
                        <th><label>Departamento</label></th>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="search" value="" id="id_search" />
                            <br/><span class="loading">Carregando...</span>
                        </td>
                        <td>
                            <select name="filtroLoja">
                                <option value="">Selecione...</option>
                                <?php
                                foreach($SelectLojas as $campos=>$valores)
                                {
                                ?>
                                <option value="<?php echo $valores['Codigo']; ?>" <?php if ($valores['Codigo'] == $filtroLoja) echo "SELECTED"; ?>><?php echo $valores['Nome']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>    
                        <td>
                            <select name="filtroDepartamento">
                                <option value="">Selecione...</option>
                                <?php
                                foreach($SelectDepartamentos as $campos=>$valores)
                                {
                                ?>
                                <option value="<?php echo $valores['Codigo']; ?>" <?php if ($valores['Codigo'] == $filtroDPTO) echo "SELECTED"; ?>><?php echo $valores['Nome']; ?></option>
                                <?php
                                }
                                ?>                                
                            </select>                        
                        </td>
                    </tr>
                </thead>
            </table>
            <div class="form-inpu-botoes">
                <input type="submit" value="Filtrar" />
            </div>
            </span>
        </div>
        </form>
    </div>
</div>
<div id="conteudo">
    <span class="lista_itens">
	<table class="ui-widget ui-widget-content">
		<thead>
                    <tr class="ui-widget-header ">
                        <th>Unidade          </th>                            
                        <th>Área             </th>
                        <th>Owner            </th>
                        <th>Pai              </th>
                        <th>Colaboradores    </th>
                        <th width="9%">Ações </th>
                    </tr>
		</thead>
		<tbody>
                        <?php foreach($Departamentos as $campos=>$valores){?>
			<tr class="dados">
                            <td><?php echo $obj->preencheZero("E", 3, $valores['CodigoLoja']);?> - <?php echo ($valores['NomeLoja']);?></td>
                            <td><?php echo $obj->preencheZero("E", 3, $valores['CodigoDepartamento']);?> - <?php echo ($valores['NomeDepartamento']);?></td>
                            <td><?php echo "<a href='#' class='dadosUsuario'><span class='Login'>".strtoupper($valores['Usuario'])."</span><span class='Departamento'>".$valores['CodigoDepartamento']."</span></a> ".$valores['NomeUsuario'];?></td>
                            <td><?php echo empty($valores['PaiDepartamento'])?"":$obj->preencheZero("E", 3, $valores['PaiDepartamento']);?></td>
                            <td>
                                <?php
                                // Retorna os colaboradores do departamento e loja listado
                                
                                $colaboradores = $obj->retornaUsuariosPorDepartamento($valores['CodigoDepartamento'], $valores['CodigoLoja']);
                                
                                foreach ($colaboradores as $campos2=>$valores2)
                                {
                                    echo "<a href='#' class='dadosUsuario'><span class='Login'>".strtoupper($valores2['Login'])."</span><span class='Departamento'>".$valores['CodigoDepartamento']."</span></a> ".$valores2['Nome'];
                                    echo "<br/>";
                                    echo "<br/>";
                                }                                 
                                ?>
                            </td>                            
                            <td class="acoes">
                                <span class="lista_acoes">
                                    <ul>
                                        <?php
                                        // Verifica se o owner do departamento é igual ao usuário logado, se sim
                                        // libera a opção de associar usuário ao departamento
                                        if ($user == $valores['Usuario'])
                                        {
                                        ?>
                                        <li class="ui-state-default ui-corner-all" title="Associar" ><a href="?router=T0064/associar&codigo=<?php echo ($valores['CodigoDepartamento']);?>&nome=<?php echo ($valores['NomeDepartamento']);?>&loja=<?php echo $valores['CodigoLoja']?>" class="ui-icon ui-icon-plusthick"           ></a></li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </span>
                            </td>
			</tr>
                        <?php }?>
		</tbody>
                <!-- Caixa Dialogo Excluir -->
                <div id="dialog-confirm" title="Mensagem!" style="display:none;">
                    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Tem certeza que deseja excluir este item?</p>
                </div>                
	</table>
    </span>
</div>