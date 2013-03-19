<?php

$obj = new models_T0095();

$connORA    =   "ora";
$objORA = new models_T0095($connORA);
//$auditoria = $_POST["codigoAuditoria"];

$auditoria = "53238";



$a = 0;
$retornaConfirmados = $obj->retornaStatusItens($auditoria);
foreach ($retornaConfirmados as $cps => $valoresStatus) {
    $a++;
}



if ($a == 0) {
    
    $retornaLojaAudit   =   $obj->retornaLojaAudit($auditoria);
    foreach ($retornaLojaAudit as $cpsLoja => $valoresLoja) {   
        $loja       =   $valoresLoja["Loja"];
        $nomeLoja   =   $valoresLoja["Nome"];
        
    }
    
    
    $retornaProdRecebidos       =   $objORA->retornaRecebimentoProd($loja);
    
    
              
//        while($vlrRec  = oci_fetch_array($retornaProdRecebidos)){
//                
//                
//        
//            
//        }
        
       
        
        $retornaCoordenador =   $obj->retornaCoordenadores($loja);

        foreach ($retornaCoordenador as $cpsCoor => $valoresCoor) {
            
            $retornaContato =   $obj->retornaContatos($valoresCoor["Usuario"]);
            
            foreach ($retornaContato as $cpsCont    =>  $valoresCont){

            $from        = "web@davo.com.br";
            $headers     = "From: $from\r\n";
            $headers    .= "Content-type: text/html\r\n";
            $headers    .= "Cc: web@davo.com.br, erocha@davo.com.br"; 
            //$para        = $valoresCont["Usuario"]."@davo.com.br";  
            
            $para        = "rsnascim@davo.com.br";  
          

            $retornaProdConfCoord       =   $obj->retornaProdConfCoord($auditoria);
            $i  =   0;
            foreach ($retornaProdConfCoord  as  $cpsProd    =>  $valoresProd){
               if ($i == 0){
                $html = '<style type="text/css">
                                table{
                                border: 1px solid #000000;
                                border-collapse: collapse;
                                font-size: 10pt;
                                height: 20px;
                                margin: 0 0 4px;
                                padding: 0;
                                text-align: center;
                                width: 100%;}

                                th, td{
                                border: 1px solid #000000;
                                border-collapse: collapse;
                                }

                            </style>    
                            <table>
                            <thead>
                                <tr>
                                    <th colspan="12" align="left">Auditoria:'.$valoresProd["Auditoria"].' - Loja: '.$nomeLoja.'</th>
                                </tr>
                                <tr bgcolor="#333333">
                                                                <th><font color="#ffffff">Cod.RMS</font></th>
                                                                <th><font color="#ffffff">Descrição</font></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>';
               } $i++;
               
               $html   .= '<tr style="background-color:'.$corlinha.'">
                                                                <td>'.$valoresProd['CodRms'].'</td>
                                                                <td>'.$valoresProd['Descricao'].'</td>
                                                            </tr>';
            }
            
            }
            
            //mail($para, "Rupturas", $html, $headers);
            echo $html;
            
            
        
    }
    // echo "oi";
}
?>
