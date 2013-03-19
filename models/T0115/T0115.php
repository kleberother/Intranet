<?php

///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 02/05/2012 por Roberta Schimidt                               
// * Descrição: Tela controle de cheques
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/
//
//
class models_T0115 extends models
{

    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
    }
    
    public function inserir($tabela,$campos)
    {
        
        $insere = $this->exec($this->insere($tabela, $campos));
        
//       if($insere)
//            $this->alerts('false', 'Alerta!', 'Incluido com Sucesso!');
//       else
//            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');
       
       return $insere;
    }      
   
    
    public function altera($tabela,$campos,$delim)
    {              
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));
       
//       if($altera)
//            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
//       else
//            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');          
       
      // echo $altera;
       return $altera;
    }   
    
    
    public function retornaComprador() {
        
        $sql    =   "SELECT  T111.T111_Nome         Nome
                            ,T111.T004_login        Login
                            ,T111.T111_comprador    CodComprador
                            ,T111.T111_email        Email
                        FROM    T111_detalhe_comprador T111";
                      
      //  echo $sql."<br>";
        return $this->query($sql);
        
    }
    
    
   
    
    public function retornaAuditorias() {
        
        $sql    =   "SELECT T093_codigo  Auditoria
                       FROM T093_auditoria t93
                      WHERE date_format(t93.T093_dt_inicio, '%d/%m/%Y') =
                                DATE_FORMAT(
                                  DATE_SUB(CONCAT(CURDATE()), INTERVAL 9 DAY),
                                   '%d/%m/%Y')
                                  AND T093_tipo = 'I'";
        
        return $this->query($sql);
        
    }
    
    public function retornaDadosAuditoria($fornecedor) {
        
        $sql = "SELECT  t94.T093_codigo         Auditoria,
                        t93.T006_codigo         Loja,
                        t94.T094_comprador_rms  Comprador,
                        t94.T094_fornecedor_rms Fornecedor,
                        t94.T094_EAN            Ean,
                        t94.T094_codigo_rms     CodRms,
                        t94.T094_descricao      Descricao,
                        t94.T094_embalagem      Embalagem,
                        MAX(IF(tle.T094_loja = '19', floor(round(tle.T094_qtd_estoque/t94.T094_embalagem)), NULL)) AS Estq1,
                        MAX(IF(tle.T094_loja = '27', floor(tle.T094_qtd_estoque/t94.T094_embalagem), NULL)) AS Estq2,
                        MAX(IF(tle.T094_loja = '35', floor(tle.T094_qtd_estoque/t94.T094_embalagem), NULL)) AS Estq3,
                        MAX(IF(tle.T094_loja = '43', floor(tle.T094_qtd_estoque/t94.T094_embalagem), NULL)) AS Estq4,
                        MAX(IF(tle.T094_loja = '51', floor(tle.T094_qtd_estoque/t94.T094_embalagem), NULL)) AS Estq5,
                        MAX(IF(tle.T094_loja = '60', floor(tle.T094_qtd_estoque/t94.T094_embalagem), NULL)) AS Estq6,
                        MAX(IF(tle.T094_loja = '78', floor(tle.T094_qtd_estoque/t94.T094_embalagem), NULL)) AS Estq7,
                        MAX(IF(tle.T094_loja = '124',floor(tle.T094_qtd_estoque/t94.T094_embalagem), NULL)) AS Estq12,
                        MAX(IF(tle.T094_loja = '132',floor(tle.T094_qtd_estoque/t94.T094_embalagem), NULL)) AS Estq13,
                        MAX(IF(tle.T094_loja = '19', tle.T094_loja, NULL))  AS Loja1,
                        MAX(IF(tle.T094_loja = '27', tle.T094_loja, NULL))  AS Loja2,
                        MAX(IF(tle.T094_loja = '35', tle.T094_loja, NULL))  AS Loja3,
                        MAX(IF(tle.T094_loja = '43', tle.T094_loja, NULL))  AS Loja4,
                        MAX(IF(tle.T094_loja = '51', tle.T094_loja, NULL))  AS Loja5,
                        MAX(IF(tle.T094_loja = '60', tle.T094_loja, NULL))  AS Loja6,
                        MAX(IF(tle.T094_loja = '78', tle.T094_loja, NULL))  AS Loja7,
                        MAX(IF(tle.T094_loja = '124', tle.T094_loja, NULL)) AS Loja12,
                        MAX(IF(tle.T094_loja = '132', tle.T094_loja, NULL)) AS Loja13
               FROM T094_auditoria_detalhes t94
               JOIN T112_auditoria_loja_est tle
                ON   t94.T094_EAN = tle.T094_EAN
                AND  t94.T093_codigo = tle.T093_codigo
                JOIN T093_auditoria t93
                ON tle.T093_codigo = t93.T093_codigo
              WHERE  date_format(t93.T093_dt_inicio, '%d/%m/%Y') =
          DATE_FORMAT(DATE_SUB(CONCAT(CURDATE()), INTERVAL 9 DAY),'%d/%m/%Y')
            AND t94.T094_fornecedor_rms = '$fornecedor'
                GROUP BY t94.T094_comprador_rms, t94.T094_fornecedor_rms, t94.T094_EAN, t94.T094_codigo_rms, t94.T094_descricao";
       echo $sql."<br>"; 
        return $this->query($sql);
        
    }
    
    public function retornaFornecedorAuditoria($comprador) {
        
        $sql = "SELECT  t94.T093_codigo     
                        ,t94.T094_fornecedor_rms    Fornecedor
                        ,t26.T026_rms_razao_social  DetFornecedor
                        ,t26.T026_rms_digito        Digito
                  FROM T094_auditoria_detalhes t94
                  JOIN T112_auditoria_loja_est tle
                    ON   t94.T094_EAN = tle.T094_EAN
                   AND  t94.T093_codigo = tle.T093_codigo
                  JOIN T093_auditoria t93
                    ON tle.T093_codigo = t93.T093_codigo
                  JOIN T026_fornecedor  t26
                    ON t26.T026_rms_codigo  =   t94.T094_fornecedor_rms
                 WHERE  date_format(t93.T093_dt_inicio, '%d/%m/%Y') =
                        DATE_FORMAT(DATE_SUB(CONCAT(CURDATE()), INTERVAL 9 DAY),'%d/%m/%Y')
                    AND t94.T094_comprador_rms    =   $comprador
                        GROUP BY  t94.T094_fornecedor_rms";
       echo $sql."<br>"; 
        return $this->query($sql);
        
    }


    
    public function enviaEmailRuptura() 
    {
            $i  =   0;     
            $retornaComprador    = $this->retornaComprador();
               
           foreach ($retornaComprador as $key => $value) 
           {
                    $n_comprador =   $value["Nome"];
                    $email       =   $value["Email"];
                   
                    $to = "rsnascim@davo.com.br"; 
                    $from = "web@davo.com.br"; 
                    $subject = "Email Auditoria"; 
                                       
                    $html = '
                            <style type="text/css">
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
                                    <th colspan="12" align="left">Comprador:'.$n_comprador.'</th>
                                </tr>
                            ';

                                $a = 0;  
                                $dados2 =   $this->retornaFornecedorAuditoria($value["CodComprador"]);
                                foreach($dados2 as $cps => $valForn){
                                    $a++;
                                    $html .= '<tr bgcolor="#333333">
                                                <td colspan="13" align="left"><font color="#ffffff"><b> Fornecedor: '.$valForn["DetFornecedor"].' - '.$valForn["Fornecedor"].'-'.$valForn["Digito"].'</b></font></td>
                                              </tr>';


                                    $dados3 = $this->retornaDadosAuditoria($valForn["Fornecedor"]);


                                    foreach($dados3 as $cps3    =>  $valores) {

                                        if($i   ==  0)
                                            {        
                                                $html   .= ' <tr bgcolor="#333333">
                                                                <th><font color="#ffffff">Cod.RMS</font></th>
                                                                <th><font color="#ffffff">Descrição</font></th>
                                                                <th><font color="#ffffff">Embalagem</font></th>
                                                                <th><font color="#ffffff">Estoque Itaquera</font></th>
                                                                <th><font color="#ffffff">Estoque Oratório</font></th>
                                                                <th><font color="#ffffff">Estoque Guaianazes</font></th>
                                                                <th><font color="#ffffff">Estoque S.Miguel</font></th>
                                                                <th><font color="#ffffff">Estoque Itaim</font></th>
                                                                <th><font color="#ffffff">Estoque Suzano</font></th>
                                                                <th><font color="#ffffff">Estoque Mogi</font></th>
                                                                <th><font color="#ffffff">Estoque SBC</font></th>
                                                                <th><font color="#ffffff">Estoque Taboão</font></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>';        } $i++;


                                                             if ($cor%2==0)
                                                                $corlinha   =   "#E8E8E8";
                                                             else
                                                                $corlinha   =   "";


                                                            if(($valores['Estq1'] == 0)&&($valores['Loja'] == $valores['Loja1'])){
                                                                $corCol1   ==  'red';
                                                            } else {
                                                                $corCol1   ==  $corlinha;
                                                            }
                                                            if(($valores['Estq2'] == 0)&&($valores['Loja'] == $valores['Loja2'])){
                                                                $corCol2   ==  'red';
                                                            } else {
                                                                $corCol2   ==  $corlinha;
                                                            }

                                                            if(($valores['Estq3'] == 0)&&($valores['Loja'] == $valores['Loja3'])){
                                                                $corCol3   ==  'red';
                                                            } else {
                                                                $corCol3   ==  $corlinha;
                                                            }
                                                            if(($valores['Estq4'] == 0)&&($valores['Loja'] == $valores['Loja4'])){
                                                                $corCol4   ==  'red';
                                                            } else {
                                                                $corCol4   ==  $corlinha;
                                                            }
                                                            if(($valores['Estq5'] == 0)&&($valores['Loja'] == $valores['Loja5'])){
                                                                $corCol5   ==  'red';
                                                            }else {
                                                                $corCol5   ==  $corlinha;
                                                            }
                                                            if(($valores['Estq6'] == 0)&&($valores['Loja'] == $valores['Loja6'])){
                                                                $corCol6   ==  'red';
                                                            }else {
                                                                $corCol6   ==  $corlinha;
                                                            }
                                                            if(($valores['Estq7'] == 0)&&($valores['Loja'] == $valores['Loja7'])){
                                                                $corCol7   ==  'red';
                                                            }else {
                                                                $corCol7   ==  $corlinha;
                                                            }
                                                            if(($valores['Estq12'] == 0)&&($valores['Loja'] == $valores['Loja12'])){
                                                                $corCol12   ==  'red';
                                                            }else {
                                                                $corCol12   ==  $corlinha;
                                                            }
                                                            if(($valores['Estq13'] == 0)&&($valores['Loja'] == $valores['Loja13'])){
                                                                $corCol13   ==  'red';
                                                            }else {
                                                                $corCol3   ==  $corlinha;
                                                            }


                                                $html  .='<tr style="background-color:'.$corlinha.'">
                                                                <td>'.$valores['CodRms'].'</td>
                                                                <td>'.$valores['Descricao'].'</td>
                                                                <td>'.$valores['Embalagem'].'</td>
                                                                <td style="background-color:'.$corCol1.'">'.$valores['Estq1'].'</td>
                                                                <td style="background-color:'.$corCol2.'">'.$valores['Estq2'].'</td>
                                                                <td style="background-color:'.$corCol3.'">'.$valores['Estq3'].'</td>
                                                                <td style="background-color:'.$corCol4.'">'.$valores['Estq4'].'</td>
                                                                <td style="background-color:'.$corCol5.'">'.$valores['Estq5'].'</td>
                                                                <td style="background-color:'.$corCol6.'">'.$valores['Estq6'].'</td>
                                                                <td style="background-color:'.$corCol7.'">'.$valores['Estq7'].'</td>
                                                                <td style="background-color:'.$corCol12.'">'.$valores['Estq12'].'</td>
                                                                <td style="background-color:'.$corCol13.'">'.$valores['Estq13'].'</td>
                                                            </tr>'; $cor++;  
                                                            if($i== 0)
                                                                {
                                                                    $html   .= '</tbody>
                                                                                    </table>';
                                                                } $i++; } } 

                                                 //end of message 
                                            $headers  = "From: $from\r\n"; 
                                            $headers .= "Content-type: text/html\r\n"; 

                                            //options to send to cc+bcc 
                                          //  $headers .= "Cc: vvieira@davo.com.br"; 
                                        //    $headers .= "Bcc: cnsilva@davo.com.br"; 

                                            // now lets send the email. 

                                            if($a > 0){
                                            mail($to, $subject, $html, $headers); 
                                            echo "E-mail enviado !"; 

                                            }



                                                   }
    }
    
    public function dadosIntra() {
        
        $sql = "SELECT T026_rms_codigo CodForn
                      ,T026_rms_digito Digito
                    FROM T026_fornecedor T26";
        
        return $this->query($sql);
        
    }
    
    public function checkRms($codRms) {
        
        $connORA = $this->consulta;
        
        $sql = "SELECT   TIP_RAZAO_SOCIAL   RAZAOSOCIAL
                        ,TIP_CODIGO         CODIGORMS
                        ,TIP_DIGITO         DIGITO
                        ,TIP_CGC_CPF        CNPJCPF
                        ,TIP_INSC_EST_IDENT RGINSEST
                        ,TIP_INSC_MUN       INSCMUN
                  FROM RMS.AA2CTIPO         FORN ";
        //echo $sql."<br>";
             $stid    = oci_parse($connORA, $sql);
                        oci_execute($stid);
                return($stid);
        
    }
    
    
     
}
 ?>
