<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 21/03/2011 por Rodrigo Alfieri e Jorge Nova                 */
/* Descrição: Classe para executar as Querys do Programa T0015            */
/**************************************************************************/

class models_T0015 extends models 
{

    public function __construct()
    {
        $conn = "";
        parent::__construct($conn);
    }

    public function inserir($tabela,$campos)
    {
        $insere = $this->exec($this->insere($tabela, $campos));
       if($insere)
            $this->alerts('false', 'Alerta!', 'Incluído com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');          
    }
    
    public function retornaProcessos()
    {
        $sql    =   "   SELECT T61.T061_codigo  ProcessoCodigo
                             , T61.T061_desc    ProcessoDescricao  
                             , T61.T061_nome    ProcessoNome
                          FROM T061_processo T61";
        
        return $this->query($sql);
    }
    
    public function retornaGrupos($cod)
    {
        $sql    =   "   SELECT T59.T004_login   GrupoLogin
                             , T59.T059_codigo  GrupoCodigo
                             , T59.T059_desc    GrupoDescricao
                             , T59.T059_nome    GrupoNome
                             , T59.T061_codigo  GrupoCodigoProcesso
                          FROM T059_grupo_workflow T59
                         WHERE T061_codigo  = $cod";
        
        return $this->query($sql);
    }
    
    public function retornaUltimaEtapa()
    {
        $sql    =   "SELECT MAX(T60.T060_codigo)+1  ProxEtapa
                       FROM T060_workflow T60";
        
        //return $this->lastInsertId();
        
        return $this->query($sql);
    }
    
    public function retornaWorkflow($Codigo)
    {
        $sql    =   "   SELECT T60.T059_codigo              CodigoGrupo
                             , T59.T059_nome                NomeGrupo
                             , T59.T059_desc                DescricaoGrupo
                             , T60.T060_codigo              CodigoWorkflow
                             , T60.T060_num_dias            NumDiasWorkflow
                             , T60.T060_obriga_aprovacao    ObrigaWorkflow
                             , T60.T060_ordem               OrdemWorkflow
                             , T60.T060_proxima_etapa       ProxEtapaWorkflow
                             , T60.T061_codigo              CodigoProcesso
                          FROM T060_workflow T60
                          JOIN T059_grupo_workflow T59 ON ( T60.T061_codigo = T59.T061_codigo 
                                                       AND  T60.T059_codigo = T59.T059_codigo )";
        if (empty($Codigo))
            $sql    .="  WHERE T60.T060_proxima_etapa IS NULL";
        else
            $sql    .="  WHERE T60.T060_proxima_etapa    =   $Codigo";
            
        $sql    .="  ORDER BY 4";                
        
        return $this->query($sql);
    }

}
?>