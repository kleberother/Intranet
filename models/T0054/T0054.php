<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 22/09/2011 por Jorge Nova                              
 * Descrição: Arquivo contém query para exibir conteúdo no display por área
 * Entrada:   Código do Painel e Código da Área
 * Origens:   
           
**************************************************************************
*/

class models_T0054 extends models
{  
    public function __construct($conn,$verificaConexao)
    {
        parent::__construct($conn,$verificaConexao);   
    }
    
    public function alterar($tabela,$campos,$delim)
    {
       $conn = "";
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));

//       if($altera)
//            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
//       else
//            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');   

	return $altera;
    } 

    public function retornaDetalhesPainel($CodPainel)
    {
       $sql="SELECT T78.T076_codigo TemplateCodigo
                  , T78.T006_codigo LojaCodigo
                  , T78.T078_titulo Titulo
                  , T78.T078_rodape Rodape
               FROM T078_painel T78
              WHERE T78.T078_codigo = $CodPainel
            ";
       
        return $this->query($sql);
    }
    
    public function retornaProdutosArea($CodPainel,$CodArea)
    {   
        //  // retorna os produtos de uma determinada área do Painel
        $sql = " SELECT TF.T075_codigo		        ItemCod
                      , TF.T075_digito		        ItemDig
                      , T75.T075_descricao_comercial	DescCml
                      , fnDV_T054_PrecoVigente( T75.T075_codigo , T75.T075_digito , T78.T006_codigo, 'D') ValorDe
                      , fnDV_T054_PrecoVigente( T75.T075_codigo , T75.T075_digito , T78.T006_codigo, 'P') ValorPor
                  FROM T075_T078_T080       TF
                  JOIN T075_produtos        T75 ON ( T75.T075_codigo = TF.T075_codigo ) 
                  JOIN T076_template        T76 ON ( T76.T076_codigo = TF.T076_codigo )          
                  JOIN T080_areas_template  T80 ON ( T80.T080_codigo = TF.T080_codigo
                                                     AND T80.T076_codigo = T76.T076_codigo  
                                                   )
                  
                  JOIN T078_painel          T78 ON ( T78.T078_codigo = TF.T078_codigo )
                 WHERE TF.T078_codigo = $CodPainel
                   AND TF.T080_codigo = $CodArea
                   AND T075_T078_T080_visivel = '1' /* somente produtos que estao ativos para visualizacao */
               "
        ;
        // echo $sql ; 
        $sql .= " ORDER BY T75.T075_descricao_comercial " ;
          
        return $this->query($sql);
    }          
    
    public function retornaProdutosAreaQuebraGrupo($CodPainel,$CodArea)
    {   
        //  // retorna os produtos de uma determinada área do Painel
        $sql = " SELECT T75.T020_departamento Depto
                      , T75.T020_secao Secao
                      , T75.T020_grupo Grupo 
                      , TF.T075_codigo		        ItemCod
                      , TF.T075_digito		        ItemDig
                      , T75.T075_descricao_comercial	DescCml
                      , fnDV_T054_PrecoVigente( T75.T075_codigo , T75.T075_digito , T78.T006_codigo, 'D') ValorDe
                      , fnDV_T054_PrecoVigente( T75.T075_codigo , T75.T075_digito , T78.T006_codigo, 'P') ValorPor
                  FROM T075_T078_T080       TF
                  JOIN T075_produtos        T75 ON ( T75.T075_codigo = TF.T075_codigo ) 
                  JOIN T076_template        T76 ON ( T76.T076_codigo = TF.T076_codigo )          
                  JOIN T080_areas_template  T80 ON ( T80.T080_codigo = TF.T080_codigo
                                                     AND T80.T076_codigo = T76.T076_codigo  
                                                   )
                  
                  JOIN T078_painel          T78 ON ( T78.T078_codigo = TF.T078_codigo )
                 WHERE TF.T078_codigo = $CodPainel
                   AND TF.T080_codigo = $CodArea
                   AND T075_T078_T080_visivel = '1' /* somente produtos que estao ativos para visualizacao */
               "
        ;
        // echo $sql ; 
        $sql .= " ORDER BY T75.T020_grupo,T75.T075_descricao_comercial " ;
        
        return $this->query($sql);
    } 
    
    public function retornaProdutosPrecosPainel($CodPainel)
    {   
        //  // retorna os produtos de uma determinada área do Painel
        $sql = "SELECT TF.T075_codigo		        ItemCod
                     , TF.T075_digito		        ItemDig

                     , fnDV_T054_PrecoVigente( T75.T075_codigo , T75.T075_digito , T78.T006_codigo, 'D') ValorDe
                     , fnDV_T054_PrecoVigente( T75.T075_codigo , T75.T075_digito , T78.T006_codigo, 'P') ValorPor
                FROM T075_T078_T080       TF
                JOIN T075_produtos        T75 ON ( T75.T075_codigo = TF.T075_codigo ) 
                JOIN T076_template        T76 ON ( T76.T076_codigo = TF.T076_codigo )          
                JOIN T080_areas_template  T80 ON ( T80.T080_codigo = TF.T080_codigo
                                                   AND T80.T076_codigo = T76.T076_codigo  
                                                 )

                JOIN T078_painel          T78 ON ( T78.T078_codigo = TF.T078_codigo )
                WHERE TF.T078_codigo = $CodPainel
               "
        ;
        // echo $sql ; 
        
        return $this->query($sql);
    }          
    
    public function retornaPrecosRMS($ItemCod,$DataRMS7,$LojaCod)
    {
        
        $connORA  =   $this->consulta;
                
        $sql = "SELECT RMS.F_RETORNA_PRECOS ( $ItemCod , $DataRMS7 , $LojaCod ) Retorno
                  FROM DUAL ";
            
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        
        return($stid);
    }
    
    public function retornaPrecosEMP($ItemCod , $DataEmp , $LojaSD )
    {   
        //  // retorna os produtos de uma determinada área do Painel
        $sql = "SELECT fnDV_GetPriceFromPLUStoreDate($LojaSD,$DataEmp,$ItemCod) Retorno" ;
        //echo $sql ; 
        
        return $this->query($sql);
    }       
    
    public function InsereOuAtualiza($tabela,$campos,$delimitador)
    {        
        $insere =  $this->exec($this->insere($tabela, $campos));
//        if($insere)
//             $this->alerts('false', 'Alerta!', 'Incluído com Sucesso!');
//        else
//             $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');         
        
        return $insere;
    }
        
    //Função para retornar os detalhes do Grupo
    public function retornaDetalhesGrupo($depto, $secao, $grupo)
    {
        $sql    =" SELECT T20.T020_descricao           Descricao
                        , T20.T020_descricao_painel    DescricaoPainel
                     FROM T020_classificacao_mercadologica T20
                    WHERE T20.T020_departamento    = ".$depto."
                      AND T20.T020_secao           = ".$secao."                               
                      AND T20.T020_grupo           = ".$grupo."
                      AND T20.T020_subgrupo        = 0";
        
        //echo $sql;
        
       return $this->query($sql);
    }
    
    // função para retornar os itens com alteracoes no RMS
    public function retornaItensAtualizadosRMS()
    {
        
        $connORA  =   $this->consulta;
                
        $sql = " SELECT PPRO.ppro_codigo            ItemCodigo
                      , PPRO.ppro_digito            ItemDigito
                      , PPRO.PPRO_DESCRICAO         ItemDescricao
                      , PPRO.PPRO_DESC_COML         ItemDescricaoComercial
                      , PPRO.PPRO_DEPTO             ItemDepartamento
                      , PPRO.PPRO_SECAO             ItemSecao
                      , PPRO.PPRO_GRUPO             ItemGrupo
                      , PPRO.PPRO_SUBGRUPO          ItemSubGrupo
                      , PPRO.PPRO_TIPO              Tipo      
                   FROM DAVO.DVINT_PAINEL_PRODUTOS  PPRO
                  WHERE PPRO.PPRO_ATU_INTRANET      IS NULL 
                ";
            
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        
        return($stid);
    }

    // função para atualizar o item como atualizado na fonte do RMS
    public function atualizaStatusIntegracaoRMS($ItemCod, $ItemDig)
    {
        
        $connORA  =   $this->consulta;
                
        $sql = "UPDATE DAVO.DVINT_PAINEL_PRODUTOS PPRO
                   SET PPRO.PPRO_ATU_INTRANET = 'S' /*marca como atualizado*/
                     , PPRO.PPRO_TIMESTAMP_INTRANET = sysdate
                 WHERE PPRO.PPRO_CODIGO             = $ItemCod
                   AND PPRO.PPRO_DIGITO             = $ItemDig
                ";
            
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        
        return($stid);
    }

    // função para retornar ID do arquivo da FOTO do item
    public function retornaCodigoFoto($ItemCod, $ItemDig)
    {
        
        $sql = "SELECT T5575.T055_codigo ArquivoCodigo
                  FROM T055_T075 T5575 
                 WHERE T5575.T075_codigo = $ItemCod
                   AND T5575.T075_digito = $ItemDig
               "
        ;
        // echo $sql ; 
        
        return $this->query($sql);
    }
    
    public function executaProcedureExportaProdutos()
    {
        $connORA  =   $this->consulta;
                
        $sql = "begin
                  spdvint_painel_exportaprodutos;
                end;";
            
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        
        return($stid);        
    }
    
    public function executaProcedureExportaClassificacaoMerc()
    {
        $connORA  =   $this->consulta;
                
        $sql = "begin
                  spdvint_painel_exportacmerc;
                end;";
            
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        
        return($stid);        
    }
    
}
?>

<?php
/* -------- Controle de versões - T0036.php --------------
 * 1.0.0 - 22/09/2011 - Jorge --> Liberada versao inicial
 *                                
 */
?>