<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 16/09/2011 por Jorge Nova                              
 * Descrição: Arquivo contém todas as querys para o programa de áreas de templates
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/

class models_T0038 extends models
{


    public function inserir($tabela,$campos)
    {
        $insere =  $this->exec($this->insere($tabela, $campos));
        if($insere)
             $this->alerts('false', 'Alerta!', 'Incluído com Sucesso!');
        else
             $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');         
        
        return $insere;
    } 

    public function excluir($tabela, $delim)
    {
        $exclui = $this->exec($this->exclui($tabela, $delim));

       	if($exclui)
		$this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
       	else
		$this->alerts('true', 'Erro!', 'Não foi possível Excluir!'); 

	return $exclui;
    }
    
    public function alterar($tabela,$campos,$delim)
    {
       $conn = "";
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));

       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');   

	return $altera;
    } 

    public function retornaAreasTemplates()
    {
       return $this->query("SELECT T80.T080_codigo	CodigoArea
                                 , T80.T080_nome	NomeArea  
                                 , T80.T076_codigo      CodigoTemplate
                                 , T76.T076_nome	NomeTemplate
                              FROM T080_areas_template T80
                              JOIN T076_template       T76 ON ( T76.T076_codigo = T80.T076_codigo )");
    }

    public function retornaUnicaArea($codigo)
    {
       return $this->query("SELECT T80.T080_codigo	CodigoArea
                                 , T80.T080_nome	NomeArea 
                                 , T80.T080_desc        DescricaoArea
                                 , T80.T076_codigo      CodigoTemplate
                              FROM T080_areas_template T80
                             WHERE T80.T080_codigo = $codigo");
    }

    public function retornaTemplates()
    {
       return $this->query("SELECT T076_codigo	Codigo
                                 , T076_nome	Nome
                              FROM T076_template");
    }
    
    public function retornaProximaArea($TemplateCodigo)
    {
        $sql = " SELECT IFNULL(max(T80.T080_codigo),0)+1 ProximaArea
                   FROM T080_areas_template T80
                  WHERE T80.T076_codigo = $TemplateCodigo
                ";
        
        return $this->query($sql);
    }
    
}
?>

<?php
/* -------- Controle de versões - T0038.php --------------
 * 1.0.0 - 16/09/2011 - Jorge --> Liberada versao inicial
 *                                
 */
?>