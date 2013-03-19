<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 06/12/2011 por Rodrigo Alfieri
 * Descrição: Programa para criação do corpo do template.
           
***************************************************************************/

class models_T0068 extends models
{

    public function __construct($conn,$verificaConexao)
    {
        parent::__construct($conn,$verificaConexao);
    }
    
    public function inserir($tabela,$campos)
    {
        $insere = $this->exec($this->insere($tabela, $campos));
        
       if($insere)
            $this->alerts('false', 'Alerta!', 'Incluido com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');  
    }   
    
    public function altera($tabela,$campos,$delim)
    {
       $conn = "";
       
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));
       
       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');          
       
       return $altera;
    }

    public function excluir($tabela, $delim)
    {
        $exclui = $this->exec($this->exclui($tabela, $delim));
        
       if($exclui)
            $this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Excluir!'); 
    }    
    
    public function retornaCorpos($cod)
    {
        $sql = "SELECT T33.T033_codigo  CodigoCorpo
                     , T33.T076_codigo  CodigoTemplate
                     , T76.T076_nome    NomeTemplate
                     , T33.T033_nome    NomeCorpo
                     , T33.T033_desc    DescricaoCorpo
                     , T33.T033_corpo   Corpo
                  FROM T033_corpo T33
                  JOIN T076_template T76 ON T33.T076_codigo = T76.T076_codigo ";
        
        if (!empty($cod))
            $sql .= "WHERE T33.T033_codigo  =   $cod";
        
        return $this->query($sql);
    }
        
    public function retornaTemplate()
    {
        $sql = "SELECT T76.T076_codigo  CodigoTemplate
                     , T76.T076_nome    NomeTemplate
                     , T76.T076_desc    DescricaoTemplate
                FROM T076_template T76";
        
        return $this->query($sql);
    }
 
}
?>
<?php
/* -------- Controle de versões - models/T0060.php --------------
 * 
*/
?>