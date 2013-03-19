<?php

/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 21/10/2011 por Jorge Nova
 * Descrição: Classe para querys do programa de parametros
           
***************************************************************************/

class models_T0059 extends models
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
    
      public function retornaParametros($cod)
    {
       return $this->query("SELECT T0455.T004_login	      Login
                                 , T04.T004_nome	      Nome
                                 , T0455.T004_T055_visualizar Visualizar
                                 , T0455.T004_T055_alterar    Alterar
                                 , T0455.T004_T055_excluir    Excluir
                             FROM T004_T055    as T0455
                             JOIN T004_usuario as T04 ON ( T04.T004_login = T0455.T004_login )
                            WHERE T0455.T055_codigo = $cod");
    }

}
?>