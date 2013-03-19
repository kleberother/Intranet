<?php 
class PDF extends FPDF
{
//Current column
var $col=0;
//Ordinate of column start
var $y0;

//$cod = $_GET["cod"];

var $cod;
var $user;

//function select()
//{
// $objAP = new models_T0016();
// $this->cod = $_GET["cod"];
// $ap = $objAP->selecionaAPDF($this->cod);
// return $ap;
//}
//
//function selectUser()
//{
// $this->user  = $_SESSION['user'];
// $objAP = new models_T0016();
// $nuser = $objAP->selecionaUser($this->user);
// return $nuser;
//}

function Header()
{
    //Page header
    global $title;
    $endereco   =   utf8_decode("Av. Waldemar Tietz, 538, Cohab - Itaquera, São Paulo - SP, CEP 03589-000");utf8_decode("D´avó Supermercados Ltda.");
    $loja       =   utf8_decode("D´avó Supermercados Ltda.");
    $telefone   =   utf8_decode("Tel.: (011) 2551-4500  Fax.: (011) 2551-4520");
    $cnpjie     =   utf8_decode("CGC: 52.130.481/0001-53  I.E: 112.874.270.112");
    
    //Logo -> variaveis (CAMINHO,POSIÇÃO X, POSIÇÃO Y, TAMANHO)
    $this->Image('template/img/logo_davo.jpg',10,5,20);
    //Arial bold 15
    $this->SetFont('Arial','B',15);
    //Move to the right
    $this->Cell(150);
    //Title
    $this->Cell(0, 0, $loja , 0, "R", 0);
    $this->SetFont('Arial','',10);
    $this->Cell(0, 12, $endereco , 0, "R", 0);
    $this->SetFont('Arial','',10);
    $this->Cell(0, 24, $telefone , 0, "R", 0);
    $this->SetFont('Arial','',10);
    $this->Cell(0, 36, $cnpjie , 0, "R", 0);    

    //Line
    $this->Line(10, 32, 200, 32);
    //Line break
    $this->Ln(25);

}

function Footer()
{

    //DADOS
//    $dados  = $this->select();
//    $dados2 = $this->selectUser();
    $data_atual        = date("d/m/Y");
//    //Captura Login para inserção
//
//    foreach($dados as $campos=>$valores)
//    {
        //Page footer
        $this->SetY(-65);
        // CNPJ CAIXAS DE ASSINATURA
        $this->SetFont("arial","B",7);
        $this->Cell(47,35,"",1,0,"L");
        $this->Cell(47,35,"",1,1,"L");

        // NOME DO APROVADOR
        $this->SetFont("arial","",6);
        $this->Cell(47,5,"Elaborada por: ","TLR",0,"C");
        $this->Cell(47,5,utf8_decode("Aprovação"),"TLR",1,"C");

        foreach ($dados2 as $campos=>$valores2)
        {
        // DATA DA APROVAÇÃO
        $this->SetFont("arial","",6);
        $this->Cell(47,5,"Conferida por: ","LR",0,"C");
        $this->Cell(47,5,"","LR",1,"C");
        }

        // DATA DA APROVAÇÃO
        $this->SetFont("arial","",6);
        $this->Cell(47,5,"Em: ".$data_atual,"BLR",0,"C");
        $this->Cell(47,5,"","BLR",1,"C");
    //}
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
    $this->cod  = $_GET["cod"];
    $titulo     = utf8_decode("Nota de Débito");
    $this->SetFont('Arial','',12);
    $this->SetFillColor(200,200,200);
    $this->Cell(0,6, $titulo,0,1,'L',true);
    $this->Cell(0,-6, $num ,0,1,'R',false);
    $this->Ln(5);
    //Save ordinate
    $this->y0=$this->GetY();
}

function ChapterBody()
{

$this->Ln(5);

$this->SetFont('arial','B',10);
$this->Cell(160,6,"T&T COM, ATACAD. I E PESC. FR. MAR","TL",0,"L");
$this->Cell(30,6,utf8_decode("CÓDIGO RMS"),"TR",1,"L");

$this->SetFont('arial','',10);

$this->Cell(160,6,utf8_decode("09.479.420/0001-17"),"LB",0,"L");
$this->Cell(30,6,utf8_decode("102083"),"RB",1,"L");


$this->Ln(5);

$this->SetFont('arial','B',10);

$this->Cell(20,6,utf8_decode("CRF")         ,"TLB"  ,0,"C");
$this->Cell(90,6,utf8_decode("DESCRIÇÃO")   ,"TLB"  ,0,"C");
$this->Cell(40,6,utf8_decode("VALOR")       ,"TLB"  ,0,"C");
$this->Cell(40,6,utf8_decode("PAGTO")       ,"TLRB" ,1,"C");

$this->SetFont('arial','',10);

for ($i = 1 ; $i <= 20; $i++)
{
$this->Cell(20,6,utf8_decode("XXXX")        ,"L"  ,0,"R");    
$this->Cell(90,6,utf8_decode("Produto")     ,"L"  ,0,"L");
$this->Cell(40,6,utf8_decode("R$ 10.000,00"),"L"  ,0,"R");
$this->Cell(40,6,utf8_decode("")            ,"LR" ,1,"R");
}

$this->SetFont('arial','B',10);

$this->Cell(110,6,utf8_decode("TOTAL GERAL")    ,"TLB"  ,0,"C");
$this->Cell(80,6,utf8_decode("R$ 10.000,00")    ,"TRB"  ,1,"R");

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