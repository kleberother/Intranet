<?php


/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 31/01/2012 por Jorge Nova
 * Descrição: Classe de models para o programa T088
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/


class models_T0088 extends models
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
    
    public function retornaDescReduzida($codigo)
    {
        
        $connORA  =   $this->consulta;
        
        $sql = "SELECT B.TBC_CODIGO CODIGO
                     , C.CTA_DCR    DESCRICAO  
                  FROM RMS.AA1CTCON B  INNER JOIN RMS.AA1CTCOA A ON (
                           B.TBC_AGENDA               = A.TBC_CTB_AGE
                       AND B.TBC_CODIGO               = A.TBC_CTB_COD
                       AND A.TBC_CTB_INT              = 'F  '
                       AND A.TBC_CTB_CON          LIKE 'VAL_CONT%'  )
                       INNER JOIN RMS.AA3CTBPC C ON (
                           C.CTA_CTA                  = A.TBC_CTB_CRE_CTA
                       AND C.CTA_ANO                  = 111  )
                WHERE B.TBC_AGENDA       = 454
                   AND B.TBC_CODIGO      = $codigo ";
        
        $stid    =  oci_parse($connORA, $sql);
        
        oci_execute($stid);                
        
        return($stid);
        
    }

    public function retornaCRFsORA()
    {
        
        $connORA  =   $this->consulta;
        
        $sql      = "SELECT  F.TCG_CRF               CRF
                          ,  P.CFOP_DESCRICAO_REDUZ  Descricao
                       FROM  RMS.AA1CCFOP            P
                       JOIN  RMS.AG1CRFCF            F ON F.TCG_CFOP    =    P.CFOP_CODIGO";
        
        $stid    =  oci_parse($connORA, $sql);
        
        oci_execute($stid);                
        
        return($stid);
        
    }

    public function retornaCRFs()
    {
               
        $sql      = "SELECT	TF1.T088_descricao_nota_debito	Descricao
                          , 	TF1.T088_crf_rms		CodigoRMS
                          , 	TF1.T088_descricao_rms		DescricaoRMS
                       FROM     T088_crf                	TF1";
        
        return  $this->query($sql);
    }

    public function retornaCRF($codigo)
    {
               
        $sql      = "SELECT TF1.T088_descricao_nota_debito	Descricao
                          , TF1.T088_crf_rms                    CodigoRMS
                          , TF1.T088_descricao_rms		DescricaoRMS
                       FROM T088_crf                            TF1
                      WHERE TF1.T088_crf_rms    =   $codigo";
        
        return  $this->query($sql);
    }
           
}
?>
