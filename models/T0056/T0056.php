<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 29/09/2011 por Rodrigo Alfieri
 * Descrição: Classe para intereração com banco do programa T0056 (Produtos TV Digital)  
           
***************************************************************************/

class models_T0056 extends models
{ 

    public function __construct($conn)
    {
        parent::__construct($conn);
    }

    public function inserir($tabela,$campos)
    {
        $insere =  $this->exec($this->insere($tabela, $campos));
        if($insere)
             $this->alerts('false', 'Alerta!', 'Incluído com Sucesso!');
        else
             $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');         
        
        return $insere;
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
        
    public function retornaProdutos($ProdutoCodigo)
    {
        $sql = "    SELECT T75.T075_codigo              ProdutoCodigo
                         , T75.T075_digito              ProdutoDigito
                         , T75.T075_descricao           ProdutoDescricao
                         , T75.T075_descricao_comercial ProdutoDescComercial
                         , T20D.T020_departamento       DepartamentoCodigo
                         , T20D.T020_descricao           DepartamentoDescricao
                         , T20S.T020_departamento       SecaoCodigo
                         , T20S.T020_descricao           SecaoDescricao
                         , T20G.T020_departamento       GrupoCodigo
                         , T20G.T020_descricao           GrupoDescricao
                         , T20SG.T020_departamento      SubGrupoCodigo
                         , T20SG.T020_descricao          SubGrupoDescricao
                      FROM T075_produtos T75
                 LEFT JOIN T020_classificacao_mercadologica T20D
                        ON T75.T020_departamento = T20D.T020_departamento
                       AND T20D.T020_secao              = 0
                       AND T20D.T020_grupo              = 0
                       AND T20D.T020_subgrupo           = 0
                 LEFT JOIN T020_classificacao_mercadologica T20S
                        ON T75.T020_departamento        = T20S.T020_departamento
                       AND T75.T020_secao               = T20S.T020_secao
                       AND T20S.T020_grupo              = 0
                       AND T20S.T020_subgrupo           = 0
                 LEFT JOIN T020_classificacao_mercadologica T20G
                        ON T75.T020_departamento = T20G.T020_departamento
                       AND T75.T020_secao               = T20G.T020_secao
                       AND T75.T020_grupo               = T20G.T020_grupo
                       AND T20G.T020_subgrupo           = 0
                 LEFT JOIN T020_classificacao_mercadologica T20SG
                        ON T75.T020_departamento        = T20SG.T020_departamento
                       AND T75.T020_secao               = T20SG.T020_secao
                       AND T75.T020_grupo               = T20SG.T020_grupo
                       AND T75.T020_subgrupo            = T20SG.T020_subgrupo";
        
        if(!empty($ProdutoCodigo))
           $sql .= " WHERE T75.T075_codigo = $ProdutoCodigo";
        //echo $sql; /* TESTE */
        
        return $this->query($sql);
        
    }

    public function retornaArquivos($ProdutoCodigo)
    { 
        $sql = "SELECT T55.T055_codigo    ArquivoCodigo
                     , T55.T055_nome      ArquivoNome
                     , T55.T055_desc      ArquivoDescricao  
                     , T55.T055_dt_upload ArquivoDtUpload
                     , T55.T056_codigo    ArquivoCategoria
                     , T57.T057_nome      ArquivoExtensao
                     , T55.T061_codigo    ArquivoProcesso
                  FROM T055_T075 T5575    
                  JOIN T055_arquivos T55 
                       ON (T5575.T055_codigo = T55.T055_codigo)
                  JOIN T057_extensao T57
                       ON (T55.T057_codigo = T57.T057_codigo)";
      //  if(!empty($ProdutoCodigo))
       $sql .= " WHERE T5575.T075_codigo = $ProdutoCodigo";
        
        return $this->query($sql);
    }
    
    public function retornaQtdeArquivos($ProdutoCodigo)
    {
        $sql = "SELECT COUNT(T5575.T055_codigo) Qtde
                  FROM T055_T075 T5575 
                 WHERE T075_codigo = $ProdutoCodigo
                ";
        
        return $this->query($sql);
    }  
    
    public function retornaParametroUP()
    {
        return $this->query(" SELECT T89.T089_valor Valor
                                FROM T003_parametros T03
                                JOIN T089_parametro_detalhe T89 ON T03.T003_codigo = T89.T003_codigo
                               WHERE T03.T003_codigo = 1");
    }    

    //Para Upload
    public function selecionaExtensao($extensao)
    {
       return $this->query("SELECT T1.T057_codigo   Codigo
                                  , T1.T057_nome    Nome
                                  , T1.T057_desc    Descricao
                               FROM T057_extensao   T1
                              WHERE T1.T057_nome = '$extensao'");
    }

    public function retornaExtensaoArquivos($cod)
    {
        return $this->query("SELECT T55.T057_codigo Codigo 
                                  , T57.T057_nome   Nome
                               FROM T055_arquivos T55
                               JOIN T057_extensao T57 ON ( T57.T057_codigo = T55.T057_codigo)
                              WHERE T055_codigo = $cod");
    }   
    
    
}
?>
<?php
/* -------- Controle de versões - models/T0034.php --------------
 * 1.0.0 - 29/09/2011   --> Liberada a versão
*/
?>