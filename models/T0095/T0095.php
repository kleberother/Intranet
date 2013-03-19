<?php

///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 02/05/2012 por Roberta Schimidt                               
// * Descrição: Tela controle de cheques
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/
//
//
class models_T0095 extends models
{

    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
    }
    
    public function inserir($tabela,$campos)
    {
        
        $insere = $this->exec($this->insere($tabela, $campos));
        
//       if($insere)
//            $this->alerts('false', 'Alerta!', 'Incluido com Sucesso!');
//       else
//            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');
       
       return $insere;
    }      
    
    public function retornaLojas($user)
    {
        $sql = "SELECT TF1.T006_codigo  Codigo
                     , TF1.T006_nome    Nome
                  FROM T006_loja TF1
                  JOIN T004_usuario TJ1	ON ( TF1.T006_codigo = TJ1.T006_codigo )
                 WHERE TJ1.T004_login = '$user'";
        
        return $this->query($sql);
    }      
    
    public function retornaLojasSelectBox()
    {
        $sql = "   SELECT T06.T006_codigo LojaCodigo
                        , T06.T006_nome   LojaNome
                     FROM T006_loja T06
                     JOIN T065_segmento_filiais T65 ON T06.T065_codigo = T65.T065_codigo
                    WHERE T65.T065_codigo  = 1";
        
        return $this->query($sql);
    }
    
    public function retornaAuditoria($loja, $arquivo, $dt_inicio, $dt_fim)
    {
        $dt_inicio  =     $this->formataData($dt_inicio);
        $dt_fim  =     $this->formataData($dt_fim);
        
        $sql    =   "      SELECT T93.T093_codigo                                       CodigoAuditoria
                                , T93.T093_gerente                                      Gerente 
                                , T93.T093_inventario                                   CoordInventario
                                , T93.T020_departamento                                 Departamento
                                , T93.T020_secao                                        Secao
                                , T93.T020_grupo                                        Grupo
                                , T93.T020_subgrupo                                     Subgrupo            
                                , T06.T006_codigo                                       CodigoLoja
                                , T06.T006_nome                                         NomeLoja 
                                , date_format(T93.T093_dt_inicio,'%d/%m/%Y')            Data
                                , FNDVINT_Auditoria_QtItens(T93.T093_codigo)            QtdeItens
                                , FNDVINT_Auditoria_QtEmLinha(T93.T093_codigo)          EmLinha
                                , FNDVINT_Auditoria_QtAuditados(T93.T093_codigo)        Auditados
                                , FNDVINT_Auditoria_QtDivergente(T93.T093_codigo)       Divergente
                                , FNDVINT_Auditoria_QtForaLinha(T93.T093_codigo)        ForaLinha
                                , FNDVINT_Auditoria_Erro(T93.T093_codigo)               Erro
                                , FNDVINT_Auditoria_PrcDivergente(T93.T093_codigo)      ErroPrc
                                , FNDVINT_Auditoria_SemEtiqueta(T93.T093_codigo)        ErroEtq
                                , FNDVINT_Auditoria_Ruptura(T93.T093_codigo)            Ruptura
                                , FNDVINT_Auditoria_RupturaComPer(T93.T093_codigo)      RupturaCom
                                , FNDVINT_Auditoria_RupturaLojaPer(T93.T093_codigo)     RupturaLoja
                                , FNDVINT_Auditoria_QtSemCadastro(T93.T093_codigo)      SemCadastro
                             FROM T093_auditoria T93
                             JOIN T006_loja T06 ON T93.T006_codigo = T06.T006_codigo
                            WHERE T93.T093_tipo = 'I'";
          
        if (!empty($loja))
            $sql    .=  " AND T06.T006_codigo= $loja";
        if (!empty($arquivo))
            $sql    .=  " AND T93.T093_codigo= $arquivo"; 
        if ($dt_inicio != 'null')
            $sql    .=  " AND date_format(T93.T093_dt_inicio, '%Y-%m-%d') BETWEEN '$dt_inicio' AND '$dt_fim' ";
           
      //echo $sql."<br>";
        
        return $this->query($sql);
        
    
        
    }
    
    public function retornaEstoqueItem($loja, $codigoItemRMS)
    {
        $connORA  =   $this->consulta;
        
        $sql = "  SELECT EST.GET_ESTOQUE    ESTOQUE
                    FROM RMS.AA2CESTQ EST
                    JOIN RMS.AA3CITEM ITM ON ITM.GIT_COD_ITEM = TRUNC(EST.GET_COD_PRODUTO/10,0)
                   WHERE EST.GET_COD_LOCAL      = $loja
                     AND EST.GET_COD_PRODUTO    = $codigoItemRMS";
                        
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        
        while($valores  = oci_fetch_assoc($stid))
        {
            $estoqueItem    =   $valores['ESTOQUE'];
        }
        
        return($estoqueItem);        
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
    
    public function retornaRupturasComercial($codigoArquivo)
    {
        $sql    =   "   SELECT T94.T093_codigo                              Auditoria
                             , T94.T094_descricao                           Descricao
                             , T94.T094_codigo_rms                          CodigoRMS
                             , T94.T094_EAN                                 Ean
                             , CASE T94.T094_oferta
                               WHEN 'S' THEN 'SIM'
                               ELSE 'NÃO'
                               END                                          Oferta 
                             , T94.T094_preco_rms                           PrecoRMS
                             , T94.T094_preco_auditado                      PrecoAuditado                             
                             , T93.T006_codigo                              Loja
                             , T06.T006_nome                                LojaNome
                             , T94.T094_estoque_rms                         Estoque
                             , date_format(T93.T093_dt_inicio,'%d/%m/%Y')   Data
                             , T93.T020_departamento                        Departamento
                             , T93.T020_secao                               Secao
                             , T93.T020_grupo                               Grupo
                             , T93.T020_subgrupo                            Subgrupo                                 
                          FROM T094_auditoria_detalhes T94
                          JOIN T093_auditoria T93 ON T93.T093_codigo    = T94.T093_codigo 
                                                 AND T93.T093_tipo      = T94.T093_tipo
                          JOIN T006_loja T06 ON T06.T006_codigo = T93.T006_codigo
                         WHERE T94.T093_codigo = $codigoArquivo
                           AND T94.T093_tipo = 'C'
                           AND T94.T094_linha= 'S'
                           AND T94.T094_item_pai_rms NOT IN (
                                                                SELECT T94.T094_item_pai_rms
                                                                  FROM T094_auditoria_detalhes T94 
                                                                 WHERE T093_codigo = $codigoArquivo
                                                                   AND T093_tipo = 'I' 
                                                             )
                           AND T94.T094_estoque_rms =   0
             GROUP BY T94.T094_item_pai_rms
             ORDER BY 7 DESC";
        
        return $this->query($sql);
    }
    
    public function retornaRupturasLoja($codigoArquivo)
    {
        $sql    =   "   SELECT T94.T093_codigo                              Auditoria
                             , T94.T094_descricao                           Descricao
                             , T94.T094_codigo_rms                          CodigoRMS
                             , T94.T094_EAN                                 Ean
                             , CASE T94.T094_oferta
                               WHEN 'S' THEN 'SIM'
                               ELSE 'NÃO'
                               END                                          Oferta 
                             , T94.T094_preco_rms                           PrecoRMS
                             , T94.T094_preco_auditado                      PrecoAuditado                             
                             , T93.T006_codigo                              Loja
                             , T06.T006_nome                                LojaNome
                             , T94.T094_estoque_rms                         Estoque
                             , date_format(T93.T093_dt_inicio,'%d/%m/%Y')   Data
                             , T93.T020_departamento                        Departamento
                             , T93.T020_secao                               Secao
                             , T93.T020_grupo                               Grupo
                             , T93.T020_subgrupo                            Subgrupo                                 
                          FROM T094_auditoria_detalhes T94
                          JOIN T093_auditoria T93 ON T93.T093_codigo    = T94.T093_codigo 
                                                 AND T93.T093_tipo      = T94.T093_tipo
                          JOIN T006_loja T06 ON T06.T006_codigo = T93.T006_codigo
                         WHERE T94.T093_codigo = $codigoArquivo
                           AND T94.T093_tipo = 'C'
                           AND T94.T094_linha= 'S'
                           AND T94.T094_item_pai_rms NOT IN (
                                                                SELECT T94.T094_item_pai_rms
                                                                  FROM T094_auditoria_detalhes T94 
                                                                 WHERE T093_codigo = $codigoArquivo
                                                                   AND T093_tipo = 'I' 
                                                             )
                           AND T94.T094_estoque_rms >   0
             GROUP BY T94.T094_item_pai_rms
             ORDER BY 7 DESC";
        
       // echo $sql;
        
        return $this->query($sql);
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
    
    public function retornaForaLinha($codigoArquivo)
    {
        $sql    =   "   SELECT T94.T093_codigo                              Auditoria
                             , T94.T094_descricao                           Descricao
                             , T94.T094_codigo_rms                          CodigoRMS
                             , T94.T094_EAN                                 Ean
                             , CASE T94.T094_oferta
                               WHEN 'S' THEN 'SIM'
                               ELSE 'NÃO'
                               END                                          Oferta 
                             , T94.T094_preco_rms                           PrecoRMS
                             , T94.T094_preco_auditado                      PrecoAuditado                             
                             , T93.T006_codigo                              Loja
                             , T06.T006_nome                                LojaNome
                             , T94.T094_estoque_rms                         Estoque
                             , date_format(T93.T093_dt_inicio,'%d/%m/%Y')   Data
                             , T93.T020_departamento                        Departamento
                             , T93.T020_secao                               Secao
                             , T93.T020_grupo                               Grupo
                             , T93.T020_subgrupo                            Subgrupo                                 
                          FROM T094_auditoria_detalhes T94
                          JOIN T093_auditoria T93 ON T93.T093_codigo    = T94.T093_codigo 
                                                 AND T93.T093_tipo      = T94.T093_tipo
                          JOIN T006_loja T06 ON T06.T006_codigo = T93.T006_codigo
                         WHERE T94.T093_codigo = $codigoArquivo
                           AND T94.T093_tipo    = 'I'
                           AND T94.T105_status  = 4
                      GROUP BY T94.T094_item_pai_rms";
                        
        return $this->query($sql);
    }
    
    public function retornaErrosPreco($codigoArquivo)
    {
        $sql    =   "     SELECT T94.T093_codigo                              Auditoria
                             , T94.T094_descricao                           Descricao
                             , T94.T094_codigo_rms                          CodigoRMS
                             , T94.T094_EAN                                 Ean
                             , CASE T94.T094_oferta
                               WHEN 'S' THEN 'SIM'
                               ELSE 'NÃO'
                               END                                          Oferta 
                             , T94.T094_preco_rms                           PrecoRMS
                             , T94.T094_preco_auditado                      PrecoAuditado                             
                             , T93.T006_codigo                              Loja
                             , T06.T006_nome                                LojaNome
                             , T94.T094_estoque_rms                         Estoque
                             , date_format(T93.T093_dt_inicio,'%d/%m/%Y')   Data
                             , T93.T020_departamento                        Departamento
                             , T93.T020_secao                               Secao
                             , T93.T020_grupo                               Grupo
                             , T93.T020_subgrupo                            Subgrupo                                 
                          FROM T094_auditoria_detalhes T94
                          JOIN T093_auditoria T93 ON T93.T093_codigo    = T94.T093_codigo 
                                                 AND T93.T093_tipo      = T94.T093_tipo
                          JOIN T006_loja T06 ON T06.T006_codigo = T93.T006_codigo
                           WHERE T94.T093_tipo    = 'I'
                             AND T94.T105_status IN (5)
                             AND T94.T093_codigo  = $codigoArquivo 
                        GROUP BY T94.T094_item_pai_rms
                        UNION ALL
                    SELECT DISTINCT T94.T093_codigo                              Auditoria
                             , T94.T094_descricao                           Descricao
                             , T94.T094_codigo_rms                          CodigoRMS
                             , T94.T094_EAN                                 Ean
                             , CASE T94.T094_oferta
                               WHEN 'S' THEN 'SIM'
                               ELSE 'NÃO'
                               END                                          Oferta 
                             , T94.T094_preco_rms                           PrecoRMS
                             , T94.T094_preco_auditado                      PrecoAuditado                             
                             , T93.T006_codigo                              Loja
                             , T06.T006_nome                                LojaNome
                             , T94.T094_estoque_rms                         Estoque
                             , date_format(T93.T093_dt_inicio,'%d/%m/%Y')   Data
                             , T93.T020_departamento                        Departamento
                             , T93.T020_secao                               Secao
                             , T93.T020_grupo                               Grupo
                             , T93.T020_subgrupo                            Subgrupo                                 
                          FROM T094_auditoria_detalhes T94
                          JOIN T093_auditoria T93 ON T93.T093_codigo    = T94.T093_codigo 
                                                 AND T93.T093_tipo      = T94.T093_tipo
                          JOIN T006_loja T06 ON T06.T006_codigo = T93.T006_codigo
                            WHERE T94.T093_tipo    = 'I'
                                AND T94.T105_status  =4
                                AND T94.T094_preco_auditado > 0
                                AND T94.T093_codigo  = $codigoArquivo 
                            GROUP BY T94.T094_item_pai_rms        
                        ORDER BY 6";

        return  $this->query($sql);
    }
    
    public function retornaErrosEtiqueta($codigoArquivo)
    {
        $sql    =   "     SELECT T94.T093_codigo                            Auditoria
                             , T94.T094_descricao                           Descricao
                             , T94.T094_codigo_rms                          CodigoRMS
                             , T94.T094_EAN                                 Ean
                             , CASE T94.T094_oferta
                               WHEN 'S' THEN 'SIM'
                               ELSE 'NÃO'
                               END                                          Oferta 
                             , T94.T094_preco_rms                           PrecoRMS
                             , T94.T094_preco_auditado                      PrecoAuditado                             
                             , T93.T006_codigo                              Loja
                             , T06.T006_nome                                LojaNome
                             , T94.T094_estoque_rms                         Estoque
                             , date_format(T93.T093_dt_inicio,'%d/%m/%Y')   Data
                             , T93.T020_departamento                        Departamento
                             , T93.T020_secao                               Secao
                             , T93.T020_grupo                               Grupo
                             , T93.T020_subgrupo                            Subgrupo
                             , T94.T094_qtde_etiqueta                       Etiqueta    
                          FROM T094_auditoria_detalhes T94
                          JOIN T093_auditoria T93 ON T93.T093_codigo    = T94.T093_codigo 
                                                 AND T93.T093_tipo      = T94.T093_tipo
                          JOIN T006_loja T06 ON T06.T006_codigo = T93.T006_codigo
                           WHERE T94.T093_tipo    = 'I'
                             AND T94.T105_status IN (6)
                             AND T94.T093_codigo  = $codigoArquivo 
                        GROUP BY T94.T094_item_pai_rms
                        UNION ALL
                       SELECT DISTINCT T94.T093_codigo                      Auditoria
                             , T94.T094_descricao                           Descricao
                             , T94.T094_codigo_rms                          CodigoRMS
                             , T94.T094_EAN                                 Ean
                             , CASE T94.T094_oferta
                               WHEN 'S' THEN 'SIM'
                               ELSE 'NÃO'
                               END                                          Oferta 
                             , T94.T094_preco_rms                           PrecoRMS
                             , T94.T094_preco_auditado                      PrecoAuditado                             
                             , T93.T006_codigo                              Loja
                             , T06.T006_nome                                LojaNome
                             , T94.T094_estoque_rms                         Estoque
                             , date_format(T93.T093_dt_inicio,'%d/%m/%Y')   Data
                             , T93.T020_departamento                        Departamento
                             , T93.T020_secao                               Secao
                             , T93.T020_grupo                               Grupo
                             , T93.T020_subgrupo                            Subgrupo   
                             , T94.T094_qtde_etiqueta                       Etiqueta
                          FROM T094_auditoria_detalhes T94
                          JOIN T093_auditoria T93 ON T93.T093_codigo    = T94.T093_codigo 
                                                 AND T93.T093_tipo      = T94.T093_tipo
                          JOIN T006_loja T06 ON T06.T006_codigo = T93.T006_codigo
                            WHERE T94.T093_tipo    = 'I'
                                AND T94.T105_status  =4
                                AND T94.T094_preco_auditado = 0
                                AND T94.T093_codigo  = $codigoArquivo 
                            GROUP BY T94.T094_item_pai_rms          
                        ORDER BY 6";
       //echo $sql;                
        return  $this->query($sql);
    }
    
    public function retornaSemCadastro($codigoArquivo)
    {
        $sql    =   "  SELECT T94.T093_codigo          Auditoria
                             , T94.T093_tipo            Tipo
                             , T94.T094_descricao       Descricao
                             , T94.T094_codigo_rms      CodigoRMS
                             , T94.T094_linha           Linha
                             , T94.T094_EAN             Ean
                             , T94.T094_estoque_rms     Estoque
                             , CASE T94.T094_oferta
                               WHEN 'S' THEN 'SIM'
                               ELSE 'NÃO'
                               END                      Oferta 
                             , T94.T094_preco_rms       PrecoRMS
                             , T93.T006_codigo          Loja
                          FROM T094_auditoria_detalhes T94
                          JOIN T093_auditoria T93 ON T93.T093_codigo = T94.T093_codigo 
                                                 AND T93.T093_tipo = T94.T093_tipo
                         WHERE T94.T093_codigo = $codigoArquivo
                           AND T94.T093_tipo = 'I'
                           AND T94.T105_status = 3
                      GROUP BY T94.T094_item_pai_rms";
        
        return $this->query($sql);
    }
    
    public function retornaDescricaoClassificacao($depto, $secao, $grupo, $sbgrp)
    {
        $sql    =   "   SELECT T20.T020_descricao Descricao
                          FROM T020_classificacao_mercadologica T20
                         WHERE T20.T020_departamento  = $depto
                           AND T20.T020_secao         = $secao
                           AND T20.T020_grupo         = $grupo
                           AND T20.T020_subgrupo      = $sbgrp";
        
        $dados  =   $this->query($sql);
        
        foreach ($dados as $campos => $valores)
        {
           $descricao  =   $valores['Descricao'];
        }
        
        return $descricao;
    }    
    
    public function retornaItensTabelaTemporaria($codigoAuditoria)
    {
        $sql    =   "  SELECT tmp.T093_codigo          Auditoria
                            , tmp.T093_tipo            Tipo
                            , tmp.tmp_codigo_rms       CodigoRMS
                            , tmp.tmp_EAN              Ean
                            , tmp.tmp_descricao        Descricao
                            , tmp.tmp_oferta           Oferta
                            , tmp.tmp_linha            Linha
                            , tmp.tmp_preco_rms        PrecoRMS
                            , tmp.tmp_preco_auditado   PrecoAuditado
                            , tmp.tmp_estoque          Estoque
                            , tmp.tmp_qtde_etiqueta    QtdeEtiqueta
                         FROM tmp_auditoria_relatorio tmp
                        WHERE tmp.T093_codigo    =   $codigoAuditoria
                     ORDER BY 10 DESC";
        
        return $this->query($sql);
    }
    
    public function retornaItensSemCadastro()
    {
        $sql    =   "";
        
        return $this->query($sql);
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
       return $this->query("SELECT T20.T020_decricao      Descricao
                                 , T20.T020_secao         Codigo
                              FROM T020_classificacao_mercadologica T20
                             WHERE T20.T020_departamento    = ".$depto."
                               AND T20.T020_secao          <> 0                               
                               AND T20.T020_grupo           = 0 ");
    }     
    
    //Função para retornar os temas
    public function retornaGrupos($depto, $secao)
    {
       return $this->query("SELECT T20.T020_decricao      Descricao
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
       return $this->query("SELECT T20.T020_decricao      Descricao
                                 , T020_subgrupo          Codigo
                              FROM T020_classificacao_mercadologica T20
                             WHERE T20.T020_departamento    = ".$depto."
                               AND T20.T020_secao           = ".$secao."                               
                               AND T20.T020_grupo           = ".$grupo."
                               AND T20.T020_subgrupo       <> 0");
    }    
    
    public function retornaDadosGrafico($loja, $dataInicial, $dataFinal, $depto, $secao, $grupo, $subgrupo)
    {
        //Formata Datas
        $dataInicial    =   $this->formataData($dataInicial);
        $dataFinal      =   $this->formataData($dataFinal);
        
        
        $sql    =   "  SELECT T93.T093_codigo                                          CodigoAuditoria 
                            , T06.T006_codigo                                          CodigoLoja 
                            , T06.T006_nome                                            NomeLoja 
                            , date_format(T93.T093_dt_inicio,'%d/%m')                  Data 
                            , CASE T20D.T020_departamento
                              WHEN 0 THEN NULL
                              ELSE T20D.T020_departamento
                               END                                                     CodigoDpto
                            , CASE T20D.T020_departamento
                              WHEN 0 THEN ''
                              ELSE T20D.T020_descricao
                               END                                                     DescricaoDpto
                            , CASE T20S.T020_secao
                              WHEN 0 THEN NULL
                              ELSE T20S.T020_secao
                               END                                                     CodigoSecao
                            , CASE T20S.T020_secao
                              WHEN 0 THEN ''
                              ELSE T20S.T020_descricao
                               END                                                     DescricaoSecao
                            , CASE T20G.T020_grupo
                              WHEN 0 THEN NULL
                              ELSE T20G.T020_grupo
                               END                                                     CodigoGrupo
                            , CASE T20G.T020_grupo
                              WHEN 0 THEN ''
                              ELSE T20G.T020_descricao
                               END                                                     DescricaoGrupo
                            , CASE T20SB.T020_subgrupo
                              WHEN 0 THEN NULL
                              ELSE T20SB.T020_subgrupo
                               END                                                     CodigoSubgrupo
                            , CASE T20SB.T020_subgrupo
                              WHEN 0 THEN ''
                              ELSE T20SB.T020_descricao
                               END                                                     DescricaoSubgrupo       
                            , FNDVINT_Auditoria_QtItens(T93.T093_codigo)               QtdeItens 
                            , FNDVINT_Auditoria_QtEmLinha(T93.T093_codigo)             EmLinha 
                            , FNDVINT_Auditoria_QtAuditados(T93.T093_codigo)           Auditados 
                            , FNDVINT_Auditoria_QtDivergente(T93.T093_codigo)          Divergente 
                            , FNDVINT_Auditoria_QtForaLinha(T93.T093_codigo)           ForaLinha 
                            , FNDVINT_Auditoria_Erro(T93.T093_codigo)                  Erro 
                            , FNDVINT_Auditoria_PrcDivergente(T93.T093_codigo)         ErroPrc 
                            , FNDVINT_Auditoria_SemEtiqueta(T93.T093_codigo)           ErroEtq
                            , FNDVINT_Auditoria_Ruptura(T93.T093_codigo)               Ruptura 
                            , FNDVINT_Auditoria_QtSemCadastro(T93.T093_codigo)         SemCadastro    
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
                        WHERE T93.T093_tipo          = 'I' ";
        
                        if (!empty($loja))
                            $sql    .=  " AND T06.T006_codigo        =    $loja";
                        if (!empty($dataInicial))
                            $sql    .=  " AND T93.T093_dt_inicio     >=   '$dataInicial 00:00:00'";
                        if (!empty($dataFinal))        
                            $sql    .=  " AND T93.T093_dt_inicio     <=   '$dataFinal 23:59:59'";
                        if (!empty($depto))        
                            $sql    .=  " AND T93.T020_departamento  =    $depto";
                        if (!empty($secao))        
                            $sql    .=  " AND T93.T020_secao         =    $secao";
                        if (!empty($grupo))        
                            $sql    .=  " AND T93.T020_grupo         =    $grupo";
                        if (!empty($subgrupo))        
                            $sql    .=  " AND T93.T020_subgrupo      =    $subgrupo";
                
                        $sql    .=  " ORDER BY T93.T093_dt_inicio";
                        
        return $this->query($sql);
        
    }
    
    public function retornaPerfil($user) {
        
        $sql = "SELECT T0409.T009_codigo  PERFIL
                  FROM T004_T009 T0409
                 WHERE T004_login   =   '$user'
                   AND T009_codigo  IN  ('55','56')";
        
        return $this->query($sql);
        
    }
    
    public function retornaLojaAudit($auditoria){
        $sql    =   "SELECT T93.T006_codigo     Loja
                           ,T06.T006_nome       Nome
                       FROM T093_auditoria  T93
                       JOIN T006_loja       T06
                         ON T93.T006_codigo =   T06.T006_codigo   
                      WHERE T093_codigo =   $auditoria";
        //echo $sql;
        return $this->query($sql);
    }

        public function retornaRupturasLoja2($codigoArquivo, $user)
    {
        
        $retornaPerfil = $this->retornaPerfil($user);
        
        foreach($retornaPerfil as $campos=>$valores)
        {
            $perfil =   $valores['PERFIL'];
        }
        
        
        if($perfil == 56)
        {
        
        $sql    =   "   SELECT T94.T093_codigo                              Auditoria
                             , T94.T094_descricao                           Descricao
                             , T94.T094_codigo_rms                          CodigoRMS
                             , T94.T094_item_pai_rms                        CodigoPaiRMS
                             , T94.T094_EAN                                 Ean
                             , CASE T94.T094_oferta
                               WHEN 'S' THEN 'SIM'
                               ELSE 'NÃO'
                               END                                          Oferta 
                             , T94.T094_preco_rms                           PrecoRMS
                             , T94.T094_preco_auditado                      PrecoAuditado                             
                             , T93.T006_codigo                              Loja
                             , T06.T006_nome                                LojaNome
                             , T94.T094_estoque_rms                         Estoque
                             , date_format(T93.T093_dt_inicio,'%d/%m/%Y')   Data
                             , T93.T020_departamento                        Departamento
                             , T93.T020_secao                               Secao
                             , T93.T020_grupo                               Grupo
                             , T93.T020_subgrupo                            Subgrupo   
                             , T94.T094_status_ge                           StatusGe
                             , T94.T094_status_inv                          StatusInv
                          FROM T094_auditoria_detalhes T94
                          JOIN T093_auditoria T93 ON T93.T093_codigo    = T94.T093_codigo 
                                                 AND T93.T093_tipo      = T94.T093_tipo
                          JOIN T006_loja T06 ON T06.T006_codigo = T93.T006_codigo
                         WHERE T94.T093_codigo = $codigoArquivo
                           AND T94.T093_tipo = 'C'
                           AND T94.T094_linha= 'S'
                           AND T94.T094_status_ge is null
                           AND T94.T094_status_inv is null
                           AND T94.T094_item_pai_rms NOT IN (
                                                                SELECT T94.T094_item_pai_rms
                                                                  FROM T094_auditoria_detalhes T94 
                                                                 WHERE T093_codigo = $codigoArquivo
                                                                   AND T093_tipo = 'I' 
                                                             )
                           AND T94.T094_estoque_rms >   0
             GROUP BY T94.T094_item_pai_rms
             ORDER BY 7 DESC"; 
        
             } else  {
        
                        $sql    =   "   SELECT    T94.T093_codigo                              Auditoria
                                                , T94.T094_descricao                           Descricao
                                                , T94.T094_codigo_rms                          CodigoRMS
                                                , T94.T094_item_pai_rms                        CodigoPaiRMS
                                                , T94.T094_EAN                                 Ean
                                                , CASE T94.T094_oferta
                                                  WHEN 'S' THEN 'SIM'
                                                  ELSE 'NÃO'
                                                  END                                          Oferta 
                                                , T94.T094_preco_rms                           PrecoRMS
                                                , T94.T094_preco_auditado                      PrecoAuditado                             
                                                , T93.T006_codigo                              Loja
                                                , T06.T006_nome                                LojaNome
                                                , T94.T094_estoque_rms                         Estoque
                                                , date_format(T93.T093_dt_inicio,'%d/%m/%Y')   Data
                                                , T93.T020_departamento                        Departamento
                                                , T93.T020_secao                               Secao
                                                , T93.T020_grupo                               Grupo
                                                , T93.T020_subgrupo                            Subgrupo
                                                , T94.T094_status_ge                           StatusGe
                                                , T94.T094_status_inv                          StatusInv
                                             FROM T094_auditoria_detalhes T94
                                             JOIN T093_auditoria T93 ON T93.T093_codigo    = T94.T093_codigo 
                                                                    AND T93.T093_tipo      = T94.T093_tipo
                                             JOIN T006_loja T06 ON T06.T006_codigo = T93.T006_codigo
                                            WHERE T94.T093_codigo = $codigoArquivo
                                              AND T94.T093_tipo = 'C'
                                              AND T94.T094_linha= 'S'
                                              AND T94.T094_status_ge is  NULL 
                                              AND T94.T094_status_inv   =   2
                                              AND T94.T094_item_pai_rms NOT IN (
                                                                                   SELECT T94.T094_item_pai_rms
                                                                                     FROM T094_auditoria_detalhes T94 
                                                                                    WHERE T093_codigo = $codigoArquivo
                                                                                      AND T093_tipo = 'I' 
                                                                                )
                                              AND T94.T094_estoque_rms >   0
                                GROUP BY T94.T094_item_pai_rms
                                ORDER BY 7 DESC";
                       }
        
      //  echo $sql;
        
        return $this->query($sql);
    }
    
    public function altera($tabela,$campos,$delim)
    {              
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));
       
//       if($altera)
//            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
//       else
//            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');          
       
      // echo $altera;
       return $altera;
    }
    
    public function retornaStatusItens($auditoria)  {
        
       $sql = "   SELECT *
                          FROM T094_auditoria_detalhes T94
                          JOIN T093_auditoria T93 ON T93.T093_codigo    = T94.T093_codigo 
                                                 AND T93.T093_tipo      = T94.T093_tipo
                          JOIN T006_loja T06 ON T06.T006_codigo = T93.T006_codigo
                         WHERE T94.T093_codigo = $auditoria
                           AND T94.T093_tipo = 'C'
                           AND T94.T094_linha= 'S'
                           AND T94.T094_status_inv is  null 
                           AND T94.T094_item_pai_rms NOT IN (
                                                                SELECT T94.T094_item_pai_rms
                                                                  FROM T094_auditoria_detalhes T94 
                                                                 WHERE T093_codigo = $auditoria
                                                                   AND T093_tipo = 'I' 
                                                             )
                           AND T94.T094_estoque_rms >   0
             GROUP BY T94.T094_item_pai_rms
             ORDER BY 7 DESC ";
       
       //echo $sql."<br>";
       
        return $this->query($sql);
    }
    
    public function retornaGerentes($loja) {
        
        $sql = "SELECT T0409.T004_login Usuario 
                  FROM T004_T009 T0409 
                  JOIN T004_usuario T04
                    ON T0409.T004_login = T04.T004_login
                 WHERE T0409.T009_codigo = 55 AND T04.T006_codigo = $loja";
     //   echo $sql."<br>";
        return $this->query($sql);
    }
    
        public function retornaCoordenadores($loja) {
        
        $sql = "SELECT T0409.T004_login Usuario 
                  FROM T004_T009 T0409 
                  JOIN T004_usuario T04
                    ON T0409.T004_login = T04.T004_login
                 WHERE T0409.T009_codigo = 56 AND T04.T006_codigo = $loja";
     //   echo $sql."<br>";
        return $this->query($sql);
    }
    
    public function retornaContatos($user) {
        
        $sql =  "SELECT T004_login Usuario
                       ,T004_nome  Nome  
                   FROM T004_usuario
                  WHERE T004_login = '$user'";
        
  //      echo $sql."<br>";
        
        return $this->query($sql);
        
    }
    
    public function retornaProdConfCoord($auditoria) {
        
        $sql = "SELECT T094_codigo_rms   CodRms
                     , T094_descricao    Descricao
                     , T093_codigo       Auditoria
                FROM T094_auditoria_detalhes T94
               WHERE T093_codigo  = '$auditoria' 
                 AND T094_status_inv  = '2'";
        //echo $sql;
        return $this->query($sql);
    }
    
    public function     retornaRecebimentoProd($loja) {
        
        
        $connORA  =   $this->consulta;
        
        $dataJD = gregoriantojd(date("m"), date("d"), date("Y"));
        
        $sql =  "  ,A.ESCLC_CODIGO||A.ESCLC_DIGITO LOJA
       ,A.ESCHC_DATA                   DTA
                   FROM RMS.AG1IENSA A 
                   JOIN RMS.AA1CTCON C ON (C.TBC_AGENDA = A.ESCHC_AGENDA3 
                    AND C.TBC_INTG_11 IN ('C' , 'R' ) )
                  WHERE A.ESCHC_DATA = $dataJD
                    AND A.ESCLC_CODIGO||A.ESCLC_DIGITO = $loja 
                 GROUP BY   A.ESITC_CODIGO||A.ESITC_DIGITO 
                           ,A.ESCLC_CODIGO||A.ESCLC_DIGITO 
                           ,A.ESCHC_DATA     ";
        
        echo $sql;
        
         $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        
   
        
    return($stid);
        
         
     
        
        
        
    }
    


            
    
}
 ?>
