<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 21/11/2011 por Jorge Nova
 * Descrição: Classe para interação com banco do programa T0065 (Lojas)
           
***************************************************************************/

class models_T0065 extends models
{

    public function __construct($conn,$verificaConexao)
    {
        parent::__construct($conn,$verificaConexao);
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
    
    public function retornaLojas()
    {   
        $sql = "  SELECT T06.T006_codigo	CodigoLoja
                       , T06.T006_nome		NomeLoja
                       , T06.T065_codigo	CodigoSegmento
                       , T65.T065_nome		NomeSegmento
                    FROM T006_loja              T06
                    JOIN T065_segmento_filiais  T65 ON ( T65.T065_codigo = T06.T065_codigo )";
        
        return $this->query($sql);

    }
    
    public function retornaUsuarios($nome)
    {
        return $this->query("SELECT T004_login     Login
                                  , T004_nome      Nome
                                  , T004_funcao    Funcao 
                               FROM T004_usuario
                              WHERE T004_nome LIKE '%$nome%'
                           ORDER BY T004_nome");
    }       

    public function retornaDptoNaoAssociados($codigo)
    {
        $sql = "SELECT TF1.T077_codigo  Codigo
                     , TF1.T077_nome    Nome
                  FROM T077_departamento TF1
                 WHERE TF1.T077_codigo NOT IN (	  SELECT TF2.T077_codigo
                                                    FROM T077_departamento TF2
                                               LEFT JOIN T006_T077         TJ1 ON ( TJ1.T077_codigo = TF2.T077_codigo ) 
                                                   WHERE TJ1.T006_codigo = $codigo
                                              )";
        
        return $this->query($sql);
    }       

    public function retornaDptoAssociados($codigo)
    {
        $sql = "SELECT TF1.T077_codigo   CodigoDepartamento
                     , TJ2.T077_nome     NomeDepartamento
                     , TF1.T004_login    Usuario
                     , TJ3.T004_nome     NomeUsuario
                     , TJ3.T004_funcao   FuncaoUsuario                                 
                  FROM T006_T077         TF1
                  JOIN T077_departamento TJ2 ON ( TJ2.T077_codigo = TF1.T077_codigo )
                  JOIN T004_usuario      TJ3 ON ( TJ3.T004_login  = TF1.T004_login  )
                 WHERE TF1.T006_codigo = $codigo";

        return $this->query($sql);
    }       
    
}
?>
<?php
/* -------- Controle de versões - models/T0065.php --------------
 * 1.0.0 - 21/11/2011   --> Liberada a versão
*/
?>