<?php

    // Prepara email para envio de dados do usuário e senha
    

    $para       =   "ralfieri@davo.com.br";
    
    $assunto    =   "Seu pedido foi registrado com sucesso!";
    
    $mensagem   =   "<p>Seu pedido será encaminhado imediatamente para a entrega após a confirmação de pagamento. Se você tiver alguma dúvida, entre em contato com nossa Central de Relacionamento.</p>";
    $mensagem   .=  "<h2>Informações Pedido Nº 280116924</h2>";
    $mensagem   .=  "<table>
                        <tr>
                            <td><b>Endereço de Entrega</b></td>
                            <td><b>Forma de Pagamento</b></td>
                        </tr>
                        <tr>
                            <td>Rodrigo Alfieri</td>
                            <td>Cartão de Crédito</td>
                        </tr>
                        <tr>
                            <td>Av. do Oratório, 4500</td>
                            <td>3 x R$ 193,00</td>
                        </tr>
                        <tr>
                            <td>Vila Industrial</td>
                            <td>Sem Juros</td>
                        </tr>
                        <tr>
                            <td>São Paulo - SP</td>
                        </tr>
                        <tr>
                            <td>03220-200, Brasil</td>
                        </tr>
                     </table>";
    
    $mensagem .=    "<hr/>";
    
    $mensagem .=    "<table>
                        <tr>
                            <td>Produtos</td>
                            <td>Qtd.</td>
                            <td>Valor Unitário</td>
                            <td>Subtotal</td>
                        </tr>
                        <tr>
                            <td>iPod nano 8 GB - Pink</td>
                            <td>1</td>
                            <td>R$ 579,00</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><img src='http://www.davo.com.br/ipod_nano.png' alt=''/></td>
                        </tr>
                     </table>";
    
    $mensagem   .= "<h1>CLIQUE EM BAIXAR IMAGENS EM SEU OUTLOOK</h1>";
    
    $mensagem = utf8_decode($mensagem);
    
 
    $cabecalho =  "From: Apple Store <store@apple.com>.br\r\n";
    $cabecalho .= "Bcc: tloureir@davo.com.br";    
    $cabecalho .= "MIME-Version: 1.0\r\n"; 
    $cabecalho .= "Content-type: text/html; charset=iso-8859-1\n";
    $cabecalho .= "Content-Transfer-Encoding: 8bit";     
    
    $email      =   mail($para, $assunto, $mensagem, $cabecalho);
     
    


?>
