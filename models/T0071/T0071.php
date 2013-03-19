<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 30/12/2011 por Jorge Nova                              
 * Descrição: Classe para executar as Querys do Programa T0071
 * Entradas:  Vide Cada função
 * Origens:   T0071/*
           
**************************************************************************
*/

class models_T0071 extends models
{

    public function __construct($conn)
    {
        parent::__construct($conn);
    }
       
    // Usa o código do fornecedor para retornar aps
    public function retornaNotasFornecedor($codigo,$data_inicial,$data_final,$loja)
    {
        $sql = "SELECT TF1.T026_codigo                                  Codigo
                     , TF1.T026_rms_razao_social                        RazaoSocial
                     , TJ1.T008_codigo                                  Ap
                     , TJ1.T008_nf_numero                               NotaFiscal
                     , date_format(TJ1.T008_nf_dt_emiss,'%d/%m/%Y')     DataEmissao
                     , TJ1.T008_nf_valor_bruto                          ValorBruto
                     , TJ1.T008_desc                                    Descricao
                  FROM T026_fornecedor TF1
                  JOIN T008_approval   TJ1 ON ( TJ1.T026_codigo = TF1.T026_codigo ) 
                 WHERE TF1.T026_codigo                  =  $codigo
                   AND TJ1.T008_nf_dt_emiss             >= '$data_inicial'
                   AND TJ1.T008_nf_dt_emiss             <= '$data_final'
                   AND TJ1.T008_T026T059_T006_codigo    =  $loja     
              ORDER BY TJ1.T008_nf_dt_emiss";
        
        //echo $sql;
        
        return $this->query($sql);
    }

    // Usa o código do fornecedor para retornar total das notas
    public function retornaNotasFornecedorTotal($codigo,$data_inicial,$data_final)
    {
        $sql = "SELECT sum(TJ1.T008_nf_valor_bruto) Total
                  FROM T026_fornecedor TF1
                  JOIN T008_approval   TJ1 ON ( TJ1.T026_codigo = TF1.T026_codigo ) 
                 WHERE TF1.T026_codigo      =  $codigo
                   AND TJ1.T008_nf_dt_emiss >= '$data_inicial'
                   AND TJ1.T008_nf_dt_emiss <= '$data_final'       
              ORDER BY TJ1.T008_nf_dt_emiss";
        
        //echo $sql;
        
        return $this->query($sql);
    }
    
    public function retornaLojas()
    {
        $sql = "SELECT TF1.T006_codigo 	Codigo
                     , TF1.T006_nome	Nome 
                  FROM T006_loja TF1
                 WHERE TF1.T006_codigo <> 0";
        
        return $this->query($sql);
    }      


}
?>

<?php
/* -------- Controle de versões --------------
 * 0.0.1 - 30/12/2011 --> Liberada versao inicial
 * 
*/
?>
