<?php

function conectaIntranet()
{
    try
    {
            ob_start();
            return $db = new PDO('mysql:host=10.2.1.141;dbname=Satelite', 'root', '');

    }catch (Exception $e) {
            $db->rollBack();
            echo "Failed: " . $e->getMessage();
    }
}

function conectaEmporium()
{
    try
    {
            ob_start();
            return $db = new PDO('mysql:host=10.2.1.110;dbname=emporium', 'root', 'emporium');

    }catch (Exception $e) {
            $db->rollBack();
            echo "Failed: " . $e->getMessage();
    }
}

function calculaDigitoMod11($NumDado, $NumDig, $LimMult)
{
    $Dado = $NumDado;
    for($n=1; $n<=$NumDig; $n++)
    {
        $Soma = 0;
        $Mult = 2;

        for($i=strlen($Dado) - 1; $i>=0; $i--)
        {
            $Soma += $Mult * intval(substr($Dado,$i,1));
            if(++$Mult > $LimMult) $Mult = 2;
        }

        $Dado .= strval(fmod(fmod(($Soma * 10), 11), 10));
    }
    return substr($Dado, strlen($Dado)-$NumDig);        
} 

function retornaLotesDisponiveis(){
    $sql = "   SELECT l.store_key , l.lote_numero , tipo_codigo
                 FROM davo_ccu_lote l
                WHERE l.aprovacao_status_id = 0
           ";

    $db =       conectaEmporium();

    return $db->query($sql);    
}

function insereIntranet(){
  $dados =   retornaLotesDisponiveis();
  $db    =   conectaIntranet();
  $dbEMP =   conectaEmporium();
  
  foreach($dados as $campos => $valores)
  {
      $DigLoja = calculaDigitoMod11($valores['store_key'],1,100);
      $LojaCD  = $valores['store_key'].$DigLoja; // loja Com Digito
      $Loja    = $valores['store_key'];
      $Lote    = $valores['lote_numero'];
      $Tipo    = $valores['tipo_codigo'];
      
      $insere = $db->exec("INSERT INTO T116_ccu_lote (T006_codigo  , T116_lote  
                                                    , T116_status_aprovacao ,T117_codigo)
                                              VALUES ($LojaCD      , $Lote  
                                                     , 1 , $Tipo ) ");
      
      
      if($insere)
      {
            $atualiza = $dbEMP->exec("UPDATE davo_ccu_lote l
                                         SET l.aprovacao_status_id = 1
                                       WHERE l.store_key           = $Loja
                                         AND l.lote_numero         = $Lote
                                     ");        
      }else{
        $atualiza = $dbEMP->exec("UPDATE davo_ccu_lote l
                           SET l.aprovacao_status_id = 9
                         WHERE l.store_key           = $Loja
                           AND l.lote_numero         = $Lote
                       ");        

      }
                
  }
}

insereIntranet();
// echo "A";

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
