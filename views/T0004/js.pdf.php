<?php 
class PDF extends FPDF
{
//Current column
var $col=0;
//Ordinate of column start
var $y0;

function Header()
{
    //Page header
    global $title;
    $endereco = utf8_decode("[Endereço da loja]");
    $loja     = utf8_decode("[Nome da Loja]");
    $telefone = utf8_decode("[Telefone da Loja]");
    
    //Logo -> variaveis (CAMINHO,POSIÇÃO X, POSIÇÃO Y, TAMANHO)
    $this->Image('template/img/logo_davo.jpg',10,5,20);
    //Arial bold 15
    $this->SetFont('Arial','B',15);
    //Move to the right
    $this->Cell(150);
    //Title
    $this->Cell(0, 0, $loja , 0, "R", 0);
    $this->SetFont('Arial','',12);
    $this->Cell(0, 15, $endereco , 0, "R", 0);
    $this->SetFont('Arial','',10);
    $this->Cell(0, 30, $telefone , 0, "R", 0);

    //Line
    $this->Line(10, 32, 200, 32);
    //Line break
    $this->Ln(25);

}

function Footer()
{
    //Page footer
    $pag = utf8_decode("Página ");
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->SetTextColor(128);
    $this->Cell(0,10,$pag.$this->PageNo(),0,0,'C');
}

function SetCol($col)
{
    //Set position at a given column
    $this->col=$col;
    $x=10+$col*65;
    $this->SetLeftMargin($x);
    $this->SetX($x);
}

function AcceptPageBreak()
{
    //Method accepting or not automatic page break
    if($this->col<2)
    {
        //Go to next column
        $this->SetCol($this->col+1);
        //Set ordinate to top
        $this->SetY($this->y0);
        //Keep on page
        return false;
    }
    else
    {
        //Go back to first column
        $this->SetCol(0);
        //Page break
        return true;
    }
}

function ChapterTitle()
{
    //Title
    $titulo   = utf8_decode("Aprovação de Pagamento");
    $num      = utf8_decode("N° 100");
    $this->SetFont('Arial','',12);
    $this->SetFillColor(200,200,200);
    $this->Cell(0,6, $titulo,0,1,'L',true);
    $this->Cell(0,-6, $num,0,1,'R',false);
    $this->Ln(5);
    //Save ordinate
    $this->y0=$this->GetY();
}

function ChapterBody()
{
$tit_for = utf8_decode("FORNECEDOR:");
$tit_cod = utf8_decode("CÓDIGO RMS:");
$tit_ser = utf8_decode("SÉRIE:");
$tit_dte = utf8_decode("DATA DE EMISSÃO:");
$tit_vli = utf8_decode("VALOR LIQUÍDO:");
$tit_car = utf8_decode("CARACTERÍSTICA DA DESPESA:");
$tit_des = utf8_decode("DETALHES (DETALHAMENTOS DO SERVIÇO CONTRATADO, COMPETÊNCIA OU PERIODO DE EXECUÇÃO, MENCIONAR ANEXOS QUE SEGUEM, E DEMAIS CONTEÚDOS):");
$tit_jus = utf8_decode("JUSTIFICATIVAS/CONSIDERAÇÕES RELEVANTES A CONTRATAÇÃO:");
$tit_ins = utf8_decode("INSTRUÇÕES P/ CONTROLADORIA/FINANCEIRO:");
$tit_con = utf8_decode("ESPAÇO RESERVADO A CONTROLADORIA (AGENDA, NÚMERO, SÉRIE, DATA DE AGENDA, CONTA CONTABÍL, CONTROLES INTERNOS, ETC.):");

$this->Ln(2);

//FORNECEDOR NOME E COD RMS
$this->SetFont('arial','B',10);
$this->Cell(155,5,$tit_for,"TLR",0,"L");
$this->Cell(35,5,$tit_cod,"TLR",1,"L");


//LINHAS PARA FORNECEDOR E COD RMS
$this->SetFont('arial','',10);
$this->Cell(155,5,"BATTISTTELA DIST IND PECAS EQU".$i,"BLR",0,"L");
$this->Cell(35,5,"10206-7","BLR",1,"L");

$this->Ln(2);

// CNPJ IE E IM
$this->SetFont('arial','B',10);
$this->Cell(64,5,'CNPJ:',"TLR",0,"L");
$this->Cell(63,5,'I.E.:',"TLR",0,"L");
$this->Cell(63,5,'I.M.:',"TLR",1,"L");


// LINHAS PARA CNPJ IE E IM
$this->SetFont("arial","",10);
$this->Cell(64,5,"05.198.319/0001-97","BLR",0,"L");
$this->Cell(63,5,"116828500112","BLR",0,"L");
$this->Cell(63,5,"","BLR",1,"L");

$this->Ln(2);

// CNPJ NOTA FISCAL, SÉRIE E DATAS
$this->SetFont("arial","B",10);
$this->Cell(30,5,"NOTA FISCAL:","TLR",0,"L");
$this->Cell(20,5,$tit_ser,"TLR",0,"L");
$this->Cell(40,5,$tit_dte,"TLR",0,"L");
$this->Cell(50,5,"DATA DE RECEBIMENTO:","TLR",0,"L");
$this->Cell(50,5,"DATA DE VENCIMENTO:","TLR",1,"L");

// LINHAS PARA NOTA FISCAL, SÉRIE E DATAS
$this->SetFont("arial","",10);
$this->Cell(30,5,"35470","BLR",0,"L");
$this->Cell(20,5,"U","BLR",0,"L");
$this->Cell(40,5,"06/04/2011","BLR",0,"L");
$this->Cell(50,5,"23/04/2011","BLR",0,"L");
$this->Cell(50,5,"06/05/2011","BLR",1,"L");

$this->Ln(2);

// VALOR BRUTO, LIQUIDO E CONDIÇÃO DO PAGAMENTO
$this->SetFont('arial','B',10);
$this->Cell(40,5,'VALOR BRUTO:',"TLR",0,"L");
$this->Cell(40,5,$tit_vli,"TLR",0,"L");
$this->Cell(110,5,'COND. E FORMA DE PAGAMENTO:',"TLR",1,"L");


// LINHAS PARA VALOR BRUTO, LIQUIDO E CONDIÇÃO DO PAGAMENTO
$this->SetFont("arial","",10);
$this->Cell(40,5,"R$ 550,00","BLR",0,"L");
$this->Cell(40,5,"R$ 550,00","BLR",0,"L");
$this->Cell(110,5,"BOLETO","BLR",1,"L");

$this->Ln(2);

// VALOR BRUTO, LIQUIDO E CONDIÇÃO DO PAGAMENTO
$this->SetFont("arial","B",10);
$this->Cell(60,5,"LOJA FATURADA:","TLR",0,"L");
$this->Cell(90,5,$tit_car,"TLR",0,"L");
$this->Cell(40,5,"NUM. CONTRATO","TLR",1,"L");


// LINHAS PARA VALOR BRUTO, LIQUIDO E CONDIÇÃO DO PAGAMENTO
$this->SetFont("arial","",10);
$this->Cell(60,5,"27-DAVO ORATORIO","BLR",0,"L");
$this->Cell(90,5,"REGULAR","BLR",0,"L");
$this->Cell(40,5,"","BLR",1,"L");

$this->Ln(5);

// TEXTOS
$this->SetFont("arial","B",8);
$this->Write(5,$tit_des);
$this->Ln(8);

$this->SetFont("arial","",8);
$this->Write(5,"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut risus magna, id tristique sapien. Duis cursus, enim elementum commodo dictum, metus ligula sodales dolor, et luctus neque tortor tincidunt neque. Aliquam mollis lectus nec elit commodo cursus. Praesent molestie risus et ligula tristique interdum. Proin id iaculis metus. Vestibulum volutpat, nisl eu adipiscing congue, nibh quam ullamcorper tellus, nec sollicitudin nulla lectus et sed.");
$this->Ln(8);

$this->SetFont("arial","B",8);
$this->Write(5,$tit_jus);
$this->Ln(8);

$this->SetFont("arial","",8);
$this->Write(5,"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut risus magna, id tristique sapien. Duis cursus, enim elementum commodo dictum, metus ligula sodales dolor, et luctus neque tortor tincidunt neque. Aliquam mollis lectus nec elit commodo cursus. Praesent molestie risus et ligula tristique interdum. Proin id iaculis metus. Vestibulum volutpat, nisl eu adipiscing congue, nibh quam ullamcorper tellus, nec sollicitudin nulla lectus et sed.");
$this->Ln(8);

$this->SetFont("arial","B",8);
$this->Write(5,$tit_ins);
$this->Ln(8);

$this->SetFont("arial","",8);
$this->Write(5,"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut risus magna, id tristique sapien. Duis cursus, enim elementum commodo dictum, metus ligula sodales dolor, et luctus neque tortor tincidunt neque. Aliquam mollis lectus nec elit commodo cursus. Praesent molestie risus et ligula tristique interdum. Proin id iaculis metus. Vestibulum volutpat, nisl eu adipiscing congue, nibh quam ullamcorper tellus, nec sollicitudin nulla lectus et sed.");
$this->Ln(8);

$this->SetFont("arial","B",8);
$this->Write(5,$tit_con);
$this->Ln(8);

$this->SetFont("arial","",8);
$this->Write(5,"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut risus magna, id tristique sapien. Duis cursus, enim elementum commodo dictum, metus ligula sodales dolor, et luctus neque tortor tincidunt neque. Aliquam mollis lectus nec elit commodo cursus. Praesent molestie risus et ligula tristique interdum. Proin id iaculis metus. Vestibulum volutpat, nisl eu adipiscing congue, nibh quam ullamcorper tellus, nec sollicitudin nulla lectus et sed.");
$this->Ln(10);

// CNPJ NOTA FISCAL, SÉRIE E DATAS
$this->SetFont("arial","B",7);
$this->Cell(47,35,"",1,0,"L");
$this->Cell(47,35,"",1,0,"L");
$this->Cell(47,35,"",1,0,"L");
$this->Cell(48,35,"",1,1,"L");

// LINHAS PARA NOTA FISCAL, SÉRIE E DATAS
$this->SetFont("arial","",7);
$this->Cell(47,5,"NOME","TLR",0,"C");
$this->Cell(47,5,"APROVACAO","TLR",0,"C");
$this->Cell(47,5,"CONTROLADORIA (LANCAMENTO)","TLR",0,"C");
$this->Cell(48,5,"FINANCEIRO","TLR",1,"C");
// LINHAS PARA NOTA FISCAL, SÉRIE E DATAS
$this->SetFont("arial","",7);
$this->Cell(47,5,"25/04/2011","BLR",0,"C");
$this->Cell(47,5,"25/04/2011","BLR",0,"C");
$this->Cell(47,5,"25/04/2011","BLR",0,"C");
$this->Cell(48,5,"25/04/2011","BLR",1,"C");



}

function PrintChapter($num,$title,$file)
{
    //Add chapter
    $this->AddPage();
    $this->ChapterTitle($num,$title);
    $this->ChapterBody();
}
}

$pdf      = new PDF();
$pdf->SetTitle("Aprovação de Pagamento");
$pdf->PrintChapter(1,'Aprovação de Pagamento','');
$pdf->Output();

?>