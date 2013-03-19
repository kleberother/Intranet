<?php
class PDF extends FPDF
{
//Current column
var $col=0;
//Ordinate of column start
var $y0;

//Variáveis para dados
var $data;
var $nome;
var $cpf;
var $email;
var $fone;
var $num_cupom;
var $ecf;
var $loja;




function Header()
{
    //Page header
    global $title;
//    $endereco = utf8_decode("[Endereço da loja]");
//    $loja     = utf8_decode("[Nome da Loja]");
//    $telefone = utf8_decode("[Telefone da Loja]");
    
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

    //DADOS

    //Page footer
    $this->SetY(-20);

    // NOME DO APROVADOR
//    $this->SetFont("arial","",7);
//    $this->Cell(50,5, "Ger. Comercial","T",0,"L");
//    $this->Cell(20,5,"",0,0,"L");
//    $this->Cell(50,5,"Dir. Comercial","T",0,"L");
//    $this->Cell(20,5,"",0,0,"L");
//    $this->Cell(50,5,"Controladoria","T",1,"L");

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
    $titulo   = utf8_decode("PROTOCOLO DE SOLICITAÇÃO");

    $this->SetFont('Arial','',12);
    $this->SetFillColor(200,200,200);
    $this->Cell(0,6, $titulo,0,1,'L',true);

    $this->Ln(5);
    //Save ordinate
    $this->y0=$this->GetY();
}

function ChapterBody()
{

//Captura Dados
$this->data       = $_POST["data"];
$this->nome       = $_POST["nome"];
$this->cpf        = $_POST["cpf"];
$this->email      = $_POST["email"];
$this->fone       = $_POST["fone"];
$this->num_cupom  = $_POST["n_cupom"];
$this->ecf        = $_POST["ecf"];
$this->loja       = $_POST["loja"];

$this->Ln(2);

// TEXTOS
$this->SetFont("arial","B",10);
$this->Write(5,  utf8_decode("Solicito emissão de nota fiscal eletrônica conjugada referente ao cupom fiscal número $this->num_cupom, ECF $this->ecf no dia $this->data na unidade do $this->loja."));
$this->Ln(8);
$this->Write(5,  utf8_decode("Favor enviar arquivo eletrônico XML e DANFE associados a essa nota fiscal eletrônica para o endereço eletrônico $this->email."));
$this->Ln(10);

$this->Write(5,  utf8_decode("Cliente: $this->nome"));
$this->Ln(5);
$this->Write(5,  utf8_decode("CPF: $this->cpf"));
$this->Ln(5);
$this->Write(5,  utf8_decode("Telefone de Contato: $this->fone"));

$this->Ln(20);
$this->Cell(50,5,utf8_decode(""),"B",1,"L");
$this->Cell(50,5,utf8_decode("Assinatura"),0,1,"L");

// TERMINA PRIMEIRA PARTE
$this->Ln(10);
$this->Cell(190,5,utf8_decode(""),"B",1,"L");
$this->Ln(10);

// INICIO SEGUNDA PARTE
$this->Image('template/img/logo_davo.jpg',10,135,20);
$this->Ln(16);
//LINHA
$this->Cell(190,5,utf8_decode(""),"B",1,"L");
//ESPAÇP
$this->Ln(3);
$titulo2   = utf8_decode("PROTOCOLO DE SOLICITAÇÃO");

$this->SetFont('Arial','',12);
$this->SetFillColor(200,200,200);
$this->Cell(0,6, $titulo2,0,1,'L',true);
$this->Ln(10);

$this->SetFont("arial","B",10);
$this->Write(5,  utf8_decode("Solicito emissão de nota fiscal eletrônica conjugada referente ao cupom fiscal número $this->num_cupom, ECF $this->ecf no dia $this->data na unidade do $this->loja."));
$this->Ln(8);
$this->Write(5,  utf8_decode("Favor enviar arquivo eletrônico XML e DANFE associados a essa nota fiscal eletrônica para o endereço eletrônico $this->email."));
$this->Ln(10);

$this->Write(5,  utf8_decode("Cliente: $this->nome"));
$this->Ln(5);
$this->Write(5,  utf8_decode("CPF: $this->cpf"));
$this->Ln(5);
$this->Write(5,  utf8_decode("Telefone de Contato: $this->fone"));

$this->Ln(20);
$this->Cell(50,5,utf8_decode(""),"B",1,"L");
$this->Cell(50,5,utf8_decode("Assinatura"),0,1,"L");

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
$pdf->SetTitle("AUTORIZAÇÃO DE BAIXAS COMERCIAIS");
$pdf->PrintChapter(1,'AUTORIZAÇÃO DE BAIXAS COMERCIAIS','');
$pdf->Output();

?>