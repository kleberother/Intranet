<?php


/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 31/01/2012 por Jorge Nova
 * Descrição: Classe de models para o programa T088
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/


class models_T0091 extends models
{

    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
    }
    
    public function inserir($tabela,$campos)
    {
        try
        {
            $insere = $this->exec($this->insere($tabela, $campos));
            return $insere;
        }
       catch (PDOException $i)
        {
            //se houver exceção, exibe
            print_r( "Erro: <code>" . $i->getMessage() . "</code>");
        }
       
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
    

    //Função para retornar os Deptos
    public function retornaDeptos()
    {
       return $this->query("SELECT T20.T020_descricao     Descricao
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
       return $this->query("SELECT T20.T020_descricao     Descricao
                                 , T20.T020_secao         Codigo
                              FROM T020_classificacao_mercadologica T20
                             WHERE T20.T020_departamento    = ".$depto."
                               AND T20.T020_secao          <> 0                               
                               AND T20.T020_grupo           = 0 ");
    }     
    
    //Função para retornar os temas
    public function retornaGrupos($depto, $secao)
    {
       return $this->query("SELECT T20.T020_descricao     Descricao
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
    
    public function retornaProdutos($dataRMS7, $loja, $depto, $secao, $grupo, $subgrupo)
    {
        $connORA  =   $this->consulta;
        
        $lojaSDigito    =   intval($loja/10);
        
        $sql = "   SELECT SE1.EAN_COD_EAN                                    EAN
                        , SE1.EAN_COD_PRO_ALT                                CODIGOITEM
                        , ITM.GIT_CODIGO_PAI                                 CODIGOPAI
                        , ITM.GIT_DESC_COML                                  DESCRICAO
                        , RMS.F_RETORNA_PRECOS(ITM.GIT_COD_ITEM, $dataRMS7, $lojaSDigito) INFOPRECO
                        , to_char(EST.GET_VEND_ACUM_ANO,'90.99')             SAIDAMEDIA
                        , decode(ITM.GIT_DAT_SAI_LIN, 0, 'S', 'N')           EMLINHA
                        , EST.GET_ESTOQUE                                    ESTOQUE
                        , GIT_COD_FOR                                        CODIGOFORNECEDOR
                        , GIT_COMPRADOR                                      CODIGOCOMPRADOR
                        , GIT_EMB_FOR                                        EMBALAGEM
                        , GIT_TPO_EMB_FOR                                    TIPOEMBALAGEM   
                    FROM (SELECT EAN.EAN_COD_PRO_ALT                     
                                , EAN.EAN_COD_EAN            
                            FROM RMS.AA3CCEAN EAN 
                        ) SE1
                        , RMS.AA3CITEM ITM 
                    JOIN RMS.AA2CESTQ EST ON (EST.GET_COD_PRODUTO  = (10*ITM.GIT_COD_ITEM)+ITM.GIT_DIGITO)      
                   WHERE TRUNC(SE1.EAN_COD_PRO_ALT/10,0) = ITM.GIT_COD_ITEM 
                     AND LENGTH(SE1.EAN_COD_EAN)<=13
                     AND EST.GET_COD_LOCAL               = $loja";
        
                    if(!empty($depto))
                        $sql  .=  " AND ITM.GIT_DEPTO  = $depto";
                    
                    if(!empty($secao))
                        $sql  .=  " AND ITM.GIT_SECAO  = $secao";
                    
                    if(!empty($grupo))
                        $sql  .=  " AND ITM.GIT_GRUPO  = $grupo";
                    
                    if(!empty($subgrupo))
                        $sql  .=  " AND ITM.GIT_SUBGRUPO = $subgrupo"; 
                    
                        $sql  .=  " ORDER BY 1";
                    
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);
    }
    
    public function retornaLojas($user)
    {
        $sql = "SELECT TF1.T006_codigo  Codigo
                     , TF1.T006_nome    Nome
                  FROM T006_loja TF1
                  JOIN T004_usuario TJ1	ON ( TF1.T006_codigo = TJ1.T006_codigo )
                 WHERE TJ1.T004_login = '$user'
                   AND TF1.T006_codigo NOT IN (999)";
        
        return $this->query($sql);
    }    
    
    public function retornaLojasSelectBox()
    {
        $sql = "SELECT TF1.T006_codigo  Codigo
                     , TF1.T006_nome    Nome
                  FROM T006_loja TF1                  
                 WHERE TF1.T006_codigo <> 0
                   AND TF1.T006_codigo NOT IN (999)";
        
        return $this->query($sql);
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
    
    public function retornaArquivos($codigoArquivo)
    {
        $sql    =   "  SELECT T93.T093_codigo        CodigoArquivo
                            , T06.T006_codigo               CodigoLoja
                            , T06.T006_nome                 NomeLoja
                            , T04.T004_login                LoginUsuario
                            , T04.T004_nome                 NomeUsuario
                            , CASE T20D.T020_departamento
                              WHEN 0 THEN NULL
                              ELSE T20D.T020_departamento
                              END                           CodigoDpto
                            , CASE T20D.T020_departamento
                              WHEN 0 THEN ''
                              ELSE T20D.T020_descricao
                              END                           DescricaoDpto
                            , CASE T20S.T020_secao
                              WHEN 0 THEN NULL
                              ELSE T20S.T020_secao
                              END                           CodigoSecao
                            , CASE T20S.T020_secao
                              WHEN 0 THEN ''
                              ELSE T20S.T020_descricao
                              END                           DescricaoSecao
                            , CASE T20G.T020_grupo
                              WHEN 0 THEN NULL
                              ELSE T20G.T020_grupo
                              END                           CodigoGrupo
                            , CASE T20G.T020_grupo
                              WHEN 0 THEN ''
                              ELSE T20G.T020_descricao
                              END                           DescricaoGrupo
                            , CASE T20SB.T020_subgrupo
                              WHEN 0 THEN NULL
                              ELSE T20SB.T020_subgrupo
                              END                           CodigoSubgrupo
                            , CASE T20SB.T020_subgrupo
                              WHEN 0 THEN ''
                              ELSE T20SB.T020_descricao
                              END                           DescricaoSubgrupo
                            , T93.T093_dt_inicio            DtInicioArquivo
                            , T93.T093_dt_fim               DtFimArquivo
                        FROM T093_auditoria T93
                        JOIN T006_loja T06                           ON T93.T006_codigo       = T06.T006_codigo
                        JOIN T020_classificacao_mercadologica T20D   ON T93.T020_departamento = T20D.T020_departamento 
                                                                    AND T20D.T020_secao        = 0 
                                                                    AND T20D.T020_grupo        = 0 
                                                                    AND T20D.T020_subgrupo     = 0
                        JOIN T020_classificacao_mercadologica T20S   ON T93.T020_departamento = T20S.T020_departamento 
                                                                    AND T93.T020_secao        = T20S.T020_secao 
                                                                    AND T20S.T020_grupo        = 0 
                                                                    AND T20S.T020_subgrupo     = 0
                        JOIN T020_classificacao_mercadologica T20G   ON T93.T020_departamento = T20G.T020_departamento 
                                                                    AND T93.T020_secao        = T20G.T020_secao 
                                                                    AND T93.T020_grupo        = T20G.T020_grupo 
                                                                    AND T20G.T020_subgrupo     = 0
                        JOIN T020_classificacao_mercadologica T20SB  ON T93.T020_departamento = T20SB.T020_departamento 
                                                                    AND T93.T020_secao        = T20SB.T020_secao 
                                                                    AND T93.T020_grupo        = T20SB.T020_grupo 
                                                                    AND T93.T020_subgrupo     = T20SB.T020_subgrupo
                        JOIN T004_usuario T04                        ON T93.T004_login        = T04.T004_login
                       WHERE T93.T093_tipo  = 'C'";
        
        if (!empty($codigoArquivo))
        {
            $sql    .="   AND T93.T093_codigo  = $codigoArquivo";
            return $this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }
        else
            return $this->query($sql);
    }
    
    public function retornaItens($codigoArquivo)
    {
        $sql    =   "     SELECT T94.T093_codigo        CodigoAuditoria
                               , T94.T094_EAN           EAN
                               , T94.T094_descricao     Descricao
                               , CASE T94.T094_oferta
                                 WHEN 'S' THEN 'SIM'
                                 ELSE 'NÃO'
                                 END                    Oferta
                               , CASE T94.T094_linha
                                 WHEN 'S' THEN 'SIM'
                                 ELSE 'NÃO'
                                 END                    EmLinha        
                               , T94.T094_qtde_etiqueta QtdeEtiqueta
                               , T094_preco_rms         Preco
                            FROM T094_auditoria_detalhes T94
                           WHERE T94.T093_tipo = 'C'
                             AND T94.T093_codigo = $codigoArquivo";
        
        return $this->query($sql);
    }
    
    public function produtosIntranet()
    {
        $sql    =   " SELECT T94.T094_EAN EAN
                        FROM T094_auditoria_detalhes T94
                       WHERE T093_tipo = 'I'
                         AND T94.T094_codigo_rms IS NULL";
        
        return $this->query($sql);
    }
    
    public function produtoRMS($codigoEAN)
    {
        
        $connORA  =   $this->consulta;
        
        
        $sql    =   " SELECT EAN.EAN_COD_PRO_ALT EAN
                        FROM RMS.AA3CCEAN EAN 
                       WHERE EAN.EAN_COD_EAN  = $codigoEAN";
        
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);        
                
    }
    
}
?>
