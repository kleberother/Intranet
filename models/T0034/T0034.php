<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 14/09/2011 por Rodrigo Alfieri
 * Descrição: Classe para intereração com banco do programa T0034 (TV Digital)  
           
***************************************************************************/

class models_T0034 extends models
{


    public function __construct()
    {
        $conn = "";
        parent::__construct($conn);
    }

    public function conora()
    {
       $conn = "ora";
       parent::__construct($conn);
    }

    public function alterar($tabela,$campos,$delim)
    {
       $conn = "";
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));

       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');   

	return $altera;
    } 
    
    public function alteraVisibilidade($tabela,$campos,$delim)
    {
       $conn = "";
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));

       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');   

	return $altera;
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
    
    public function inserirProduto($tabela,$campos)
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

    //Função para retornar as lojas
    public function listaLojas()
    {
       return $this->query("SELECT L.T006_codigo AS Codigo
                                 , L.T006_nome   AS Nome
                              FROM T006_loja     AS L");
    }

    //Função para retornar os temas
    public function retornaTemas()
    {
       return $this->query("SELECT T76.T076_codigo  Codigo
                                 , T76.T076_desc    Descricao
                                 , T76.T076_nome    Nome
                              FROM T076_template T76");
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
    
    //Função para retornar os painéis
    public function retornaPaineis($cod,$Loja)
    {
       $sql =  "SELECT T78.T078_codigo          Codigo,
                       T78.T078_titulo          Cabecalho,
                       T78.T078_rodape          Rodape,
                       T78.T078_descricao       Descricao,
                       T78.T076_codigo          TemaCodigo,
                       T76.T076_nome            TemaNome,
                       T78.T006_codigo          Loja,
                       T06.T006_nome            LojaNome,
                       T78.T020_departamento    DeptoCodigo,
                       T20D.T020_descricao       DeptoDesc,
                       T78.T020_secao           SecaoCodigo,
                       T20S.T020_descricao       SecaoDesc,
                       T78.T020_grupo           GrupoCodigo,
                       T20G.T020_descricao       GrupoDesc,
                       T78.T020_subgrupo        SubGrupoCodigo,
                       T20SG.T020_descricao      SubGrupoDesc,
                       T78.T078_secao_propria   SecaoPropria
                  FROM T078_painel T78
                       JOIN T006_loja T06
                          ON T78.T006_codigo = T06.T006_codigo
                       JOIN T076_template T76
                          ON T78.T076_codigo = T76.T076_codigo
                       LEFT JOIN T020_classificacao_mercadologica T20D
                          ON     T78.T020_departamento = T20D.T020_departamento
                             AND T20D.T020_secao = 0
                             AND T20D.T020_grupo = 0
                             AND T20D.T020_subgrupo = 0
                       LEFT JOIN T020_classificacao_mercadologica T20S
                          ON     T78.T020_departamento = T20S.T020_departamento
                             AND T78.T020_secao = T20S.T020_secao
                             AND T20S.T020_grupo = 0
                             AND T20S.T020_subgrupo = 0
                       LEFT JOIN T020_classificacao_mercadologica T20G
                          ON     T78.T020_departamento = T20G.T020_departamento
                             AND T78.T020_secao = T20G.T020_secao
                             AND T78.T020_grupo = T20G.T020_grupo
                             AND T20G.T020_subgrupo = 0
                       LEFT JOIN T020_classificacao_mercadologica T20SG
                          ON     T78.T020_departamento = T20SG.T020_departamento
                             AND T78.T020_secao = T20SG.T020_secao
                             AND T78.T020_grupo = T20SG.T020_grupo
                             AND T78.T020_subgrupo = T20SG.T020_subgrupo";
        if(!empty($cod))
            $sql .= "      WHERE T78.T078_codigo = ".$cod;
        if((!empty($Loja)) && (empty($cod)))
            $sql .= "      WHERE T78.T006_codigo = ".$Loja;
        else if(!empty($Loja))
            $sql .= "        AND T78.T006_codigo = ".$Loja;

       //echo $sql;
       return $this->query($sql);
    }     
  
    public function retornaProdutosAssociados($PainelCod)
    {
        $sql = "  SELECT T80.T080_codigo                    AreaCodigo
                       , T80.T080_nome                      AreaNome
                       , T75.T075_codigo                    ItemCodigo
                       , T75.T075_digito                    ItemDigito
                       , T75.T075_descricao_comercial       ItemDescricao
                       , T757880.T075_T078_T080_visivel     Visivel
                       , T5575.T055_codigo                  Arquivo
                    FROM T075_T078_T080 T757880
                    JOIN T080_areas_template T80 ON (     T80.T080_codigo = T757880.T080_codigo 
                                                      AND T80.T076_codigo = T757880.T076_codigo
                                                    )
                    JOIN T075_produtos T75       ON (     T75.T075_codigo = T757880.T075_codigo 
                                                      AND T75.T075_digito = T757880.T075_digito 
                                                    )
               LEFT JOIN T055_T075 T5575        ON (     
                                                          T5575.T075_codigo = T75.T075_codigo 
                                                          AND T5575.T075_digito = T75.T075_digito
                                                    )
                   WHERE T757880.T078_codigo  = $PainelCod 
                ORDER BY 1 , 3 "    ;

        //echo $sql."...................";
        
        return $this->query($sql);
    }
    
    public function retornaProdutosParaAssociar($PainelCod,$TemplateCod,$AreaCod,$Filtro)
    {
        $sql = " SELECT T75.T075_codigo                 Codigo
                      , T75.T075_digito                 Digito
                      , T75.T075_descricao_comercial    Descricao
                      , T5575.T055_codigo               Arquivo
                   FROM T075_produtos T75
                 LEFT JOIN T075_T078_T080 T757880 ON (     T757880.T075_codigo  = T75.T075_codigo 
                                                       AND T757880.T075_digito  = T75.T075_digito
                                                       AND T757880.T078_codigo  = $PainelCod    
                                                       AND T757880.T076_codigo  = $TemplateCod  
                                                       AND T757880.T080_codigo  = $AreaCod      
                                                       )
                 LEFT JOIN T055_T075 T5575        ON (     
                                                           T5575.T075_codigo = T75.T075_codigo 
                                                       AND T5575.T075_digito = T75.T075_digito
                                                       )
                  WHERE T757880.T078_codigo  IS NULL   /* somente itens que nao foram associados */";
        if(!empty($Filtro))
            $sql .= $Filtro ;
        
        $sql .= " ORDER BY 1";
        
        //echo $sql;    
        
        return $this->query($sql);
    }    
    
    public function retornaSecaoPropria($painel)
    {
        $sql = "SELECT T078_secao_propria SecaoPropria 
                     , T020_departamento  Departamento
                     , T020_secao	       Secao
                     , T020_grupo	       Grupo
                     , T020_subgrupo      Subgrupo
                  FROM T078_painel
                 WHERE T078_codigo = $painel";
        
        return $this->query($sql);
    }
    
    public function retornaSecaoPorDepartamento($secao)
    {
        $sql = "SELECT T078_secao_propria SecaoPropria 
                     , T020_departamento  Departamento
                     , T020_secao	       Secao
                     , T020_grupo	       Grupo
                     , T020_subgrupo      Subgrupo
                  FROM T078_painel
                 WHERE T078_codigo = $painel";
        
        return $this->query($sql);
    }

    public function retornaAreasTemplate($TemplateCod)
    {
       $sql = "SELECT T80.T080_codigo AreaCod
                    , T80.T080_nome   AreaNome
                 FROM Satelite.T080_areas_template T80
                WHERE T80.T076_codigo = $TemplateCod " ;
       
       $sql .= " ORDER BY T80.T080_codigo" ;
        
       //echo $sql;
       
        return $this->query($sql);
    }
    
    public function retornaDetalhesPainel ($PainelCod)
    {
        $sql = "SELECT T78.T078_descricao     PainelDescricao
                     , T78.T078_secao_propria SecaoPropria
                     , T78.T020_departamento  Departamento
                     , T78.T020_secao         Secao
                     , T78.T020_grupo         Grupo
                     , T78.T020_subgrupo      SubGrupo
                     , T78.T076_codigo        TemplateCodigo
                     , T78.T006_codigo        LojaCod
                  FROM T078_painel T78
                 WHERE T78.T078_codigo = $PainelCod 
                 " ;
        
        return $this->query($sql);
        
    }
    
}
?>
<?php
/* -------- Controle de versões - models/T0034.php --------------
 * 1.0.0 - 14/09/2011   --> Liberada a versão
 * 1.0.1 - 21/09/2011   --> Criação de novas querys
 *                          1. Retorna Seção Propria ( linha 241 )
*/
?>