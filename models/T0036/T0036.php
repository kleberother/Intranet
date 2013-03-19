<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 16/09/2011 por Jorge Nova                              
 * Descrição: Arquivo contém todas as querys para o programa de templates
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/

class models_T0036 extends models
{


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

    public function retornaTemplates()
    {
       return $this->query("SELECT T076_codigo	Codigo
                                 , T076_nome	Nome
                                 , T076_desc 	Descricao
                              FROM T076_template");
    }

    public function retornaUnicoTemplate($codigo)
    {
       return $this->query("SELECT T076_codigo	Codigo
                                 , T076_nome	Nome
                                 , T076_desc 	Descricao
                              FROM T076_template
                             WHERE T076_codigo = $codigo");
    }
    
    public function retornaProdutosArea($CodPainel,$CodArea)
    {   
        //  // retorna os produtos de uma determinada área do Painel
        $sql = " SELECT TF.T075_codigo		        ItemCod
                      , TF.T075_digito		        ItemDig
                      , T75.T075_descricao_comercial	DescCml
                      , fnDV_T036_PrecoVigente( T75.T075_codigo , T75.T075_digito , T78.T006_codigo, 'D') ValorDe
                      , fnDV_T036_PrecoVigente( T75.T075_codigo , T75.T075_digito , T78.T006_codigo, 'P') ValorPor
                  FROM T075_T078_T080       TF
                  JOIN T075_produtos        T75 ON ( T75.T075_codigo = TF.T075_codigo ) 
                  JOIN T076_template        T76 ON ( T76.T076_codigo = TF.T076_codigo )          
                  JOIN T080_areas_template  T80 ON ( T80.T080_codigo = TF.T080_codigo
                                                     AND T80.T076_codigo = T76.T076_codigo  
                                                   )
                  
                  JOIN T078_painel          T78 ON ( T78.T078_codigo = TF.T078_codigo )
                 WHERE TF.T078_codigo = $CodPainel
                   AND TF.T080_codigo = $CodArea" ;
         echo $sql ; 
        $sql .= " ORDER BY T75.T075_descricao_comercial " ;
        
        return $this->query($sql);
    }    
    
    // -- FUNÇÕES TEMPORÁRIAS -- TUDO PARA BAIXO SÃO QUERYS TEMPORÁRIAS PARA TESTE DO TEMPLATE
    public function retornaProdutosLista()
    {
        return $this->query("SELECT TF.T075_codigo		Codigo
                                  , TF.T075_digito		Digito
                                  , TJ1.T075_descricao_reduzida	DescReduzida
                                  , TJ5.T079_valor_de		ValorDe
                                  , TJ5.T079_valor_por		ValorPor
                               FROM T075_T078_T080       TF
                               JOIN T075_produtos        TJ1 ON ( TJ1.T075_codigo = TF.T075_codigo ) 
                               JOIN T080_areas_template  TJ2 ON ( TJ2.T080_codigo = TF.T080_codigo )
                               JOIN T076_template        TJ3 ON ( TJ3.T076_codigo = TF.T076_codigo )
                               JOIN T078_painel          TJ4 ON ( TJ4.T078_codigo = TF.T078_codigo )
                               JOIN T079_precos_produtos TJ5 ON ( TJ5.T075_codigo = TF.T075_codigo )   
                              WHERE TF.T078_codigo = 21
                                AND TF.T080_codigo = 5");
    }

    public function retornaProdutosImagem()
    {
        return $this->query("SELECT TF.T075_codigo		Codigo
                                  , TF.T075_digito		Digito
                                  , TJ1.T075_descricao_reduzida	DescReduzida
                                  , TJ5.T079_valor_de		ValorDe
                                  , TJ5.T079_valor_por		ValorPor
                               FROM T075_T078_T080       TF
                               JOIN T075_produtos        TJ1 ON ( TJ1.T075_codigo = TF.T075_codigo ) 
                               JOIN T080_areas_template  TJ2 ON ( TJ2.T080_codigo = TF.T080_codigo )
                               JOIN T076_template        TJ3 ON ( TJ3.T076_codigo = TF.T076_codigo )
                               JOIN T078_painel          TJ4 ON ( TJ4.T078_codigo = TF.T078_codigo )
                               JOIN T079_precos_produtos TJ5 ON ( TJ5.T075_codigo = TF.T075_codigo )   
                              WHERE TF.T078_codigo = 21
                                AND TF.T080_codigo = 6");
    }

    public function retornaProdutoImg1()
    {
        return $this->query("SELECT T75.T075_codigo		Codigo
                                  , T75.T075_descricao_reduzida	DescReduzida
                                       , T79.T079_valor_de	ValorDe
                                       , T79.T079_valor_por  	ValorPor
                               FROM T075_produtos        T75
                               JOIN T079_precos_produtos T79 ON ( T75.T075_codigo = T79.T075_codigo )
                              WHERE T75.T075_codigo = 1045");
    }

    public function retornaProdutoImg2()
    {
        return $this->query("SELECT T75.T075_codigo		Codigo
                                  , T75.T075_descricao_reduzida	DescReduzida
                                       , T79.T079_valor_de	ValorDe
                                       , T79.T079_valor_por  	ValorPor
                               FROM T075_produtos        T75
                               JOIN T079_precos_produtos T79 ON ( T75.T075_codigo = T79.T075_codigo )
                              WHERE T75.T075_codigo = 1631");
    }

}
?>

<?php
/* -------- Controle de versões - T0036.php --------------
 * 1.0.0 - 16/09/2011 - Jorge --> Liberada versao inicial
 *                                
 */
?>