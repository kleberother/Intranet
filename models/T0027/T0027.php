<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 30/06/2011 por Jorge Nova                                   */
/* Descrição: Classe para executar as Querys do Programa T0027            */
/**************************************************************************/

class models_T0027 extends models
{

    public function __construct($conn)
    {
        parent::__construct($conn);
    }

    public function retornaPostosDavo()
    {
       return $this->query("SELECT T006_codigo Codigo
                                 , T006_nome   Nome
                              FROM T006_loja
                             WHERE T065_codigo = 3");
    }

    public function retornaBandeirasPostos()
    {
       return $this->query("SELECT T071_codigo	Codigo
                                  , T071_nome   Nome
                          FROM T071_bandeiras_postos");
    }

    public function retornaPostosConcorrentes()
    {
       return $this->query("SELECT T70.T070_codigo      Codigo
                                 , T70.T070_nome	NomePosto
                                 , T70.T070_cnpj	CNPJ
                                 , T70.T070_endereco	Endereco
                                 , T70.T070_influencia	Influencia
                                 , T70.T070_distancia	Distancia
                                 , T71.T071_nome	Bandeira
                                 , T06.T006_nome	Loja
                              FROM T070_postos_concorrentes as T70
                              JOIN T071_bandeiras_postos as T71
                                ON (T71.T071_codigo = T70.T071_codigo)
                              JOIN T006_loja as T06
                                ON (T06.T006_codigo = T70.T006_codigo)
                          ORDER BY 1");
    }

    public function retornaPostoDados($cod)
    {
       return $this->query("SELECT T70.T070_codigo      Codigo
                                 , T70.T070_nome	NomePosto
                                 , T70.T070_cnpj	CNPJ
                                 , T70.T070_endereco	Endereco
                                 , T70.T070_influencia  Influencia
                                 , T70.T070_distancia	Distancia
                                 , T70.T071_codigo	IdBandeira
                                 , T71.T071_nome	Bandeira
                                 , T70.T006_codigo	IdLoja
                                 , T06.T006_nome	Loja
                              FROM T070_postos_concorrentes as T70
                              JOIN T071_bandeiras_postos as T71
                                ON (T71.T071_codigo = T70.T071_codigo)
                              JOIN T006_loja as T06
                                ON (T06.T006_codigo = T70.T006_codigo)
                             WHERE T70.T070_codigo = $cod");
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

    public function excluir($tabela,$campos,$delim)
    {
        $exclui = $this->exec($this->exclui($tabela, $campos, $delim));

       if($exclui)
            $this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Excluir!'); 
    }

    public function altera($tabela,$campos,$delim)
    {
       $conn = "";
       $altera =  $this->exec($this->atualiza($tabela, $campos, $delim));
       
       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');         
       
       return $altera;
    }

}
?>