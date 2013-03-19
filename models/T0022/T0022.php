<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 30/05/2011 por Rodrigo Alfieri e Jorge Nova                 */
/* Descrição: Classe para executar as Querys do Programa T0022            */
/**************************************************************************/

class models_T0022 extends models
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

    public function listaLojas()
    {
       return $this->query("SELECT T006_codigo Codigo
                                 , T006_nome   Nome
                              FROM T006_loja
                             WHERE T065_codigo = 3");
    }

    public function retornaPostoPorLoja($LojaCod)
    {
        return $this->query("SELECT T70.T070_codigo       Codigo
                                  , T70.T070_nome	  NomePosto
                                  , T70.T070_cnpj	  CNPJ
                                  , T70.T070_endereco	  Endereco
                                  , T70.T070_influencia   Influencia
                                  , T70.T070_distancia	  Distancia
                                  , T71.T071_nome	  Bandeira
                                  , T06.T006_nome	  Loja
                               FROM T070_postos_concorrentes as T70
                               JOIN T071_bandeiras_postos as T71
                                 ON (T71.T071_codigo = T70.T071_codigo)
                               JOIN T006_loja as T06
                                 ON (T06.T006_codigo = T70.T006_codigo)
                              WHERE T70.T006_codigo = $LojaCod");
    }

    public function retornaPesquisas()
    {
        return $this->query("SELECT T72.T072_codigo                         Codigo
                                  , date_format(T72.T072_data,'%d/%m/%Y')   DataPesquisa
                                  , T06.T006_nome                           NomePosto
                                  , T04.T004_nome                           Usuario
                               FROM T072_pesquisas_postos as T72
                               JOIN T004_usuario as T04
                                 ON (T04.T004_login = T72.T004_login)
                               JOIN T006_loja as T06
                                 ON (T06.T006_codigo = T72.T006_codigo)
                           ORDER BY T72.T072_data DESC");
    }

    public function retornaPesquisaCompleta($cod)
    {
        return $this->query("SELECT T04.T004_nome 				NomeUsuario
                                  , date_format(T72.T072_data,'%d/%m/%Y')	DataPesquisa
                                  , T06.T006_Nome 				NomeLoja
                                  , T72.T072_GC_custo				CustoGC
                                  , T72.T072_GC_preco				VendaGC
                                  , round(T72.T072_GC_margem,1)			MargemGC
                                  , T72.T072_GA_custo				CustoGA
                                  , T72.T072_GA_preco				VendaGA
                                  , round(T72.T072_GA_margem,1)			MargemGA
                                  , T72.T072_EC_custo				CustoEC
                                  , T72.T072_EC_preco				VendaEC
                                  , round(T72.T072_EC_margem,1)			MargemEC
                                  , T72.T072_EA_custo				CustoEA
                                  , T72.T072_EA_preco				VendaEA
                                  , round(T72.T072_EA_margem,1)			MargemEA
                                  , T72.T072_DI_custo				CustoDI
                                  , T72.T072_DI_preco				VendaDI
                                  , round(T72.T072_DI_margem,1)			MargemDI
                                  , T72.T072_GN_custo				CustoGN
                                  , T72.T072_GN_preco				VendaGN
                                  , round(T72.T072_GN_margem,1)			MargemGN
                               FROM T072_pesquisas_postos as T72
                               JOIN T004_usuario as T04
                                 ON (T04.T004_login = T72.T004_login)
                               JOIN T006_loja as T06
                                 ON (T06.T006_codigo = T72.T006_codigo)
                              WHERE T72.T072_codigo  = $cod");
    }

    public function retornaPesquisaConcorrente($cod)
    {
        return $this->query("SELECT T73.T073_GC_preco		ValorGC
                                  , T73.T073_GA_preco		ValorGA
                                  , T73.T073_EC_preco		ValorEC
                                  , T73.T073_EA_preco		ValorEA
                                  , T73.T073_DI_preco		ValorDI
                                  , T73.T073_GN_preco		ValorGN
                                  , T70.T070_nome		NomePosto
                                  , T70.T070_cnpj		CNPJPosto
                                  , T70.T070_endereco		EnderecoPosto
                                  , T70.T070_distancia		DistanciaPosto
                                  , T70.T070_influencia		InfluenciaPosto
                               FROM T073_pesquisas_postos_concorrentes as T73
                               JOIN T070_postos_concorrentes as T70
                                 ON (T70.T070_codigo = T73.T070_codigo)
                              WHERE T73.T072_codigo = $cod");
    }

    public function retornaUltimaPesquisa($loja)
    {
        return $this->query("SELECT T072_GC_custo       CustoGC
                                  , T072_GC_preco       VendaGC
                                  , T072_GC_margem      MargemGC
                                  , T072_GA_custo       CustoGA
                                  , T072_GA_preco       VendaGA
                                  , T072_GA_margem      MargemGA
                                  , T072_EC_custo       CustoEC
                                  , T072_EC_preco       VendaEC
                                  , T072_EC_margem      MargemEC
                                  , T072_EA_custo       CustoEA
                                  , T072_EA_preco       VendaEA
                                  , T072_EA_margem      MargemEA
                                  , T072_DI_custo       CustoDI
                                  , T072_DI_preco       VendaDI
                                  , T072_DI_margem      MargemDI
                                  , T072_GN_custo       CustoGN
                                  , T072_GN_preco       VendaGN
                                  , T072_GN_margem      MargemGN
                               FROM T072_pesquisas_postos
                              WHERE T006_codigo = $loja
                           ORDER BY T072_data DESC
                              LIMIT 1");
    }


}
?>