<?php 


    // muda fonte e coloca em negrito
$pdf->SetFont('Arial', 'B', 7);

// largura padrão das colunas
$largura = 40;
// altura padrão das linhas das colunas
$altura = 6;

// criando os cabeçalhos para 5 colunas
$pdf->Cell($largura, $altura, 'Codigo', 1, 0, 'L');
$pdf->Cell($largura, $altura, 'Nome', 1, 0, 'L');
$pdf->Cell($largura, $altura, 'E-mail', 1, 0, 'L');
$pdf->Cell($largura, $altura, 'Telefone', 1, 0, 'L');
$pdf->Cell($largura, $altura, 'Ativo', 1, 0, 'C');

// pulando a linha
$pdf->Ln($altura);

// tirando o negrito
$pdf->SetFont('Arial', '', 7);

// montando a tabela com os dados (presumindo que a consulta já foi feita)



// exibindo o PDF
$pdf->Output();
   
?>