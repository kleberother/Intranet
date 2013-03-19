<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 08/08/2011 por Jorge Nova                                   */
/* Descrição: Classe para executar as Querys do Programa T0033            */
/**************************************************************************/

class models_T0033 extends models
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

    public function retornaDepartamentosPai($CodigoPai) 
    {
        $sql    =   "   SELECT T77.T077_codigo  CodigoDpto
                             , T77.T077_desc    DescDpto
                             , T77.T077_nome    NomeDpto
                             , T77b.T077_nome   NomePaiDpto
                             , T77.T077_pai     PaiDpto
                          FROM T077_departamento T77
                     LEFT JOIN T077_departamento T77b ON T77.T077_pai = T77b.T077_codigo";
                         
        if(empty($CodigoPai))
            $sql    .=  " WHERE T77.T077_pai IS NULL";
        else
            $sql    .=  " WHERE T77.T077_pai =  $CodigoPai";    
        
        $sql    .=  " ORDER BY 3";
        
        
        return $this->query($sql);
    }    
    
    public function retornaDepartamentos()
    {
       $sql =   "   SELECT T77.T077_codigo  CodigoDpto
                         , T77.T077_desc    DescDpto
                         , T77.T077_nome    NomeDpto
                         , T77b.T077_nome   NomePaiDpto
                         , T77.T077_pai     PaiDpto
                      FROM T077_departamento T77
                 LEFT JOIN T077_departamento T77b ON T77.T077_pai = T77b.T077_codigo";

       return $this->query($sql);
       
    }
    
    public function retornaDepartamentoAltera($cod)
    {
       $sql =   "   SELECT T77.T077_codigo  CodigoDpto
                         , T77.T077_desc    DescDpto
                         , T77.T077_nome    NomeDpto
                         , T77b.T077_nome   NomePaiDpto
                         , T77.T077_pai     PaiDpto
                      FROM T077_departamento T77
                 LEFT JOIN T077_departamento T77b ON T77.T077_pai = T77b.T077_codigo
                     WHERE T77.T077_codigo = $cod";
       
       return $this->query($sql);
    }    
          
}
?>