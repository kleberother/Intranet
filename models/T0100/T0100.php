<?php


///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 22/05/2012 por Rodrigo Alfieri
// * Descrição: Cadastro de Metas de Garantia Estendida.
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/
//
//
class models_T0100 extends models
{

    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
    }
    
    public function retornaDados($loja, $dataI, $dataF, $tipo, $filtro)
    {   $connORA  =   $this->consulta;
        
        $sql = "  SELECT 
                         G.SGE_LOJA                  LOJA 
                  , SUM (G.SGE_PRECO_GAR)            VALOR
                   FROM RMS.SEG_GARITEM G
                  WHERE to_char(G.SGE_DAT_EMISSAO, 'DD/MM/YYYY') = '$dataI'
                    AND G.SGE_NUM_CUPOM   > 0
                    AND G.SGE_DAT_CANCELAMENTO IS NULL
               GROUP BY G.SGE_LOJA    "    ;

               
                
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);
    echo print_r;
    }
   
    
    public function retornaPerfil($user)
    {
        $sql    =   "  SELECT T0409.T009_codigo  CodigoPerfil
                         FROM T004_T009 T0409 
                        WHERE T009_codigo IN (47,48) 
                          AND T004_login = '$user'";
        
        return $this->query($sql)->fetchAll(PDO::FETCH_COLUMN);
    }
    
    public function retornaLoja()
    {
        $sql    =   "  SELECT T06.T006_codigo LojaCodigo
                            , T06.T006_nome   LojaNome
                         FROM T006_loja T06
                         JOIN T065_segmento_filiais T65 ON T06.T065_codigo = T65.T065_codigo
                        WHERE T65.T065_codigo  = 1";
        
        return $this->query($sql);
    }
    
    public function retornaMetas($codigoMeta)
    {
        $sql    =   "  SELECT T100.T100_codigo                   CodigoMeta
                            , T06.T006_codigo                    CodigoLoja
                            , T06.T006_nome                      NomeLoja
                            , T04.T004_login                     Login
                            , CONCAT(T100.T100_mes ,'/', T100.T100_ano) MesMeta
                            , T100.T100_quantidade               QtdeMeta
                            , T100.T100_meta                     ValorMeta
                        FROM T100_meta_ge T100
                        JOIN T006_loja T06 ON T100.T006_codigo = T06.T006_codigo
                        JOIN T004_usuario T04 ON T100.T004_login = T04.T004_login";
        
        if(!empty($codigoMeta))
            $sql    .=  " WHERE T100.T100_codigo    =   $codigoMeta";
                
            $sql    .=  " order by T06.T006_codigo, T100.T100_mes";
        
        return $this->query($sql);
    }
    
    
        public function alterar($tabela,$campos,$delim)
        
   {
       $conn = "";
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));
       
       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');                  
    }
    
    
    
    public function inserir($tabela,$campos)
    {
        $insere = $this->exec($this->insere($tabela, $campos));  
        
    }
    
    
    
    
    
     public function excluir($tabela, $delim)
    {
        $exclui = $this->exec($this->exclui($tabela, $delim));
        
       if($exclui)
            $this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Excluir!'); 
    }
    

    
}
 ?>
