<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 10/04/2011 por Rodrigo Alfieri                              */
/* Descrição: Classe para executar as Querys do Programa T0007            */
/**************************************************************************/

class models_T0007 extends models
{

    public function __construct()
    {
        $conn = "";
        parent::__construct($conn);
    }

    public function selecionaExtensoes()
    {
        return $this->query("SELECT T057_codigo     COD
                                  , T057_nome       NOM
                                  , T057_desc       DES
                               FROM T057_extensao;")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selecionaExtensao($cod)
    {
        return $this->query("SELECT T057_codigo     COD
                                  , T057_nome       NOM
                                  , T057_desc       DES
                               FROM T057_extensao
                              WHERE T057_codigo =   $cod");
    }

    public function insereT057($tabela,$campos)
    {
        $insere = $this->exec($this->insere($tabela, $campos));
        
       if($insere)
            $this->alerts('false', 'Alerta!', 'Incluído com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');          
    }

    public function excluiT057($tabela,$campos,$delim)
    {
        $exclui = $this->exec($this->exclui($tabela, $campos, $delim));
        
        if($exclui)
            $this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
        else
            $this->alerts('true', 'Erro!', 'Não foi possível Excluir!'); 
    }

    public function alteraT057($tabela,$campos,$delim)
    {
       $conn = "";
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));
       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');   
    }

}
?>