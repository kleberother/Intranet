<?php


/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 19/01/2012 por Jorge Nova
 * Descrição: Classe de models para o programa T083
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/


class models_T0083 extends models
{

    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
    }
    
    public function inserir($tabela,$campos)
    {
        $insere = $this->exec($this->insere($tabela, $campos));
        
       if($insere)
            $this->alerts('false', 'Alerta!', 'Incluido com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');
       
       return $insere;
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
       
       return $exclui;
    }    
    
    public function retornaLojas()
    {
        
        $sql = "SELECT TF1.T006_codigo	Codigo
                     , TF1.T006_nome	Nome    
                  FROM T006_loja TF1
                 WHERE TF1.T006_codigo <> 0";
        
        return $this->query($sql);        
    }
    
    public function  retornaColaboradores($filtros)
    {
        $sql = "SELECT TF1.T052_matricula	Matricula
                     , TF1.T052_nome		Nome
                     , TF1.T052_cargo		Cargo
                     , TF1.T052_setor		Setor
                     , TF1.T006_codigo		CodigoLoja
                     , TJ1.T006_nome 		NomeLoja	
                  FROM T052_colaborador	TF1
                  JOIN T006_loja	TJ1 ON ( TJ1.T006_codigo	=	TF1.T006_codigo )";
        
        // Insere o filtro caso houver
        
        $sql .= $filtros;
                
        return $this->query($sql);
        
    }
    
   
}
?>
