<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 15/04/2011 por Rodrigo Alfieri  e Jorge Nova                */
/* Descrição: Classe para executar as Querys do Programa T0037            */
/**************************************************************************/

class models_T0037 extends models
{

    public function __construct($conn)
    {
        parent::__construct($conn);
    }

    public function listaT061()
    {
       return $this->query("SELECT T061_codigo  P0037_T061_COD
                                 , T061_nome    P0037_T061_NOM
                                 , T061_desc    P0037_T061_DES
                              FROM T061_processo");
    }

    public function buscaT061($cod)
    {
       return $this->query("SELECT T061_codigo  P0037_T061_COD
                                 , T061_nome    P0037_T061_NOM
                                 , T061_desc    P0037_T061_DES
                              FROM T061_processo
                             WHERE T061_codigo = $cod");
    }

    public function insereT061($tabela,$campos)
    {
        $insere =  $this->exec($this->insere($tabela, $campos));
        if($insere)
             $this->alerts('false', 'Alerta!', 'Incluído com Sucesso!');
        else
             $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');         
        
        return $insere;
    }

    public function excluiT061($tabela,$campos,$delim)
    {
        $exclui = $this->exec($this->exclui($tabela, $delim));

       	if($exclui)
		$this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
       	else
		$this->alerts('true', 'Erro!', 'Não foi possível Excluir!'); 

	return $exclui;
    }

    public function alteraT061($tabela,$campos,$delim)
    {
       $conn = "";
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));

       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');   

	return $altera;
       }

}
?>