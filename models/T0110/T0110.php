<?php


///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 22/05/2012 por Rodrigo Alfieri
// * Descrição: Cadastro de Metas de Garantia Estendida.
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/
//
//
class models_T0110 extends models
{

    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
    }
    
    public function alterar($tabela,$campos,$delim)        
    {
        $conn = "";
        $altera = $this->exec($this->atualiza($tabela, $campos, $delim));

        if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
        else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');                  
    }
        
    public function inserir($tabela,$campos)
    {
        $insere = $this->exec($this->insere($tabela, $campos));  
        
    }
    
    public function excluir($tabela, $delim)
    {
        $exclui = $this->exec($this->exclui($tabela, $delim));

        if($exclui)
            $this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
        else
            $this->alerts('true', 'Erro!', 'Não foi possível Excluir!'); 
    }
    
    //Função para retornar os Deptos
    public function retornaDeptos()
    {
       return $this->query("SELECT T20.T020_descricao      Descricao
                                 , T20.T020_departamento  Depto  
                                 , T020_grupo             Grupo
                                 , T20.T020_secao         Secao
                                 , T020_subgrupo          SubGrupo
                              FROM T020_classificacao_mercadologica T20
                             WHERE T20.T020_secao       = 0
                               AND T20.T020_grupo       = 0
                               AND T20.T020_subgrupo    = 0");
    } 
    
    //Função para retornar os temas
    public function retornaSecoes($depto)
    {
       return $this->query("SELECT T20.T020_descricao      Descricao
                                 , T20.T020_secao         Codigo
                              FROM T020_classificacao_mercadologica T20
                             WHERE T20.T020_departamento    = ".$depto."
                               AND T20.T020_secao          <> 0                               
                               AND T20.T020_grupo           = 0 ");
    }     
    
    //Função para retornar os temas
    public function retornaGrupos($depto, $secao)
    {
       return $this->query("SELECT T20.T020_descricao      Descricao
                                 , T020_grupo             Codigo
                              FROM T020_classificacao_mercadologica T20
                             WHERE T20.T020_departamento    = ".$depto."
                               AND T20.T020_secao           = ".$secao."
                               AND T20.T020_grupo          <> 0
                               AND T20.T020_subgrupo        = 0");
    } 
    
    //Função para retornar os temas
    public function retornaSubGrupos($depto, $secao, $grupo)
    {
       return $this->query("SELECT T20.T020_descricao      Descricao
                                 , T020_subgrupo          Codigo
                              FROM T020_classificacao_mercadologica T20
                             WHERE T20.T020_departamento    = ".$depto."
                               AND T20.T020_secao           = ".$secao."                               
                               AND T20.T020_grupo           = ".$grupo."
                               AND T20.T020_subgrupo       <> 0");
    }

    public function retornaClassificacao($depto, $secao, $grupo, $subgrupo)
    {                
        $sql    =   "  SELECT T20.T020_descricao      Descricao
                            , T20.T020_departamento  Depto  
                            , T020_grupo             Grupo
                            , T20.T020_secao         Secao
                            , T020_subgrupo          SubGrupo
                        FROM T020_classificacao_mercadologica T20
                       WHERE T20.T020_departamento  = $depto
                         AND T20.T020_secao         = $secao
                         AND T20.T020_grupo         = $grupo
                         AND T20.T020_subgrupo      = $subgrupo";

        //echo $sql."<br>";
        
        return $this->query($sql)->fetchAll(PDO::FETCH_COLUMN);
    }    

}
 ?>
