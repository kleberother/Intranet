<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 16/09/2011 por Jorge Nova                              
 * Descrição: Arquivo contém todas as querys para o programa de templates
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/

class models_T0036 extends models
{


    public function inserir($tabela,$campos)
    {
        return $this->exec($this->insere($tabela, $campos));
    }

    public function excluir($tabela, $delim)
    {
        return $this->exec($this->exclui($tabela, $delim));
    }
    
    public function alterar($tabela,$campos,$delim)
    {
       $conn = "";
       return $this->exec($this->atualiza($tabela, $campos, $delim));
    } 



    public function retornaTemplates()
    {
       return $this->query("SELECT T076_codigo	Codigo
                                 , T076_nome	Nome
                                 , T076_desc 	Descricao
                              FROM T076_template");
    }

    public function retornaUnicoTemplate($codigo)
    {
       return $this->query("SELECT T076_codigo	Codigo
                                 , T076_nome	Nome
                                 , T076_desc 	Descricao
                              FROM T076_template
                             WHERE T076_codigo = $codigo");
    }

}
?>

<?php
/* -------- Controle de versões - T0036.php --------------
 * 1.0.0 - 16/09/2011 - Jorge --> Liberada versao inicial
 *                                
 */
?>