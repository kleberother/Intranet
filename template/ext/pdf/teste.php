    <?php
    /*
    Olá Amigos, hoje iremos aprender a gerar um arquivo PDF com nosso querido PHP
    para isso , utilizaremos a biblioteca fpdf que se encontra em - > http://www.fpdf.org/

    Objetivo : gerar um arquivo PDF apartir do PHP em formato de um artigo

    caso tenha alguma duvida faça o download do manual no site do fpdf
    já possui versões em portugues.
    os métodos aqui utilizados estao todos explicados no final do artigo !

    bom vamos ao trabalho !
    */
    //incluindo o arquivo do fpdf
    //defininfo a fonte !
    define('FPDF_FONTPATH','font/');
    //instancia a classe.. P=Retrato, mm =tipo de medida utilizada no casso milimetros, tipo de folha =A4
    $pdf= new FPDF("P","mm","A4");
    //define a fonte a ser usada
    $pdf->SetFont('arial','',10);
    //define o titulo
    $pdf->SetTitle("Testando PDF com PHP !");
    //assunto
    $pdf->SetSubject("assunto deste artigo!");
    // posicao vertical no caso -1.. e o limite da margem
    $pdf->SetY("-1");
    $titulo="Titulo do Artigo";
    //escreve no pdf largura,altura,conteudo,borda,quebra de linha,alinhamento
    $pdf->Cell(0,5,$titulo,0,0,'L');
    $pdf->Cell(0,5,'http://www.seusite.com.br',0,1,'R');
    $pdf->Cell(0,0,'',1,1,'L');
    $pdf->Ln(8);
    //hora do conteudo do artigo
    $pdf->SetFont('arial','',8);
    $novo="A Agência Nacional de Aviação Civil (Anac) informou, nesta segunda-feira (2), que vai investigar se as companhias áereas têm culpa pelos atrasos e cancelamentos registrados durante o fim de semana.
    No sábado (30), o percentual de vôos com mais de uma hora de atrasos chegou a 45,2%. No domingo (1º), até as 19h30, 36% dos vôos tiveram atrasos.
    ";
    //posiciona verticalmente 21mm
    $pdf->SetY("21");
    //posiciona horizontalmente 30mm
    $pdf->SetX("30");
    //escreve o conteudo de novo.. parametros posicao inicial,altura,conteudo(*texto),borda,quebra de linha,alinhamento
    $pdf->MultiCell(0,5,$novo,0,1,'J');

    $novo="
    Nesta segunda-feira, a situação começou a se normalizar, mas ainda há registro de problemas. Até as 10h, dos 623 vôos previstos nos 13 principais aeroportos brasileiros, 126 tiveram atrasos de mais de uma hora, segundo balanço divulgado pela Infraero, a estatal que administra os terminais aéreos. O número equivale a 20,2% do total. Quarenta e seis decolagens foram canceladas (7,3%).
    Os terminais que tiveram maiores percentuais de atrasos foram os do Recife (PE) e de Fortaleza (CE). Na Capital de Pernambuco, oito dos 24 vôos marcados até as 10h atrasaram mais de uma hora (33,3% do total). No terminal cearense, oito das 25 partidas ocorreram fora
    O terminal que registrou maior índice de cancelamentos foi o de Curitiba (PR). Das 22 decolagens programadas, quatro foram canceladas (18,1%).
    A assessoria de Infraero informa que os atrasos são conseqüência dos transtornos do fim de semana. Muitos vôos tiveram que ser remarcados para o início desta semana.
    Previsão - O presidente da Infraero, brigadeiro José Carlos Pereira, também foi prejudicado pela crise aérea. Ele tinha uma viagem marcada de Brasília para o Rio às 7h desta segunda, mas o avião só decolou às 9h59.
    Apesar do transtorno, ele disse que as operações estão ocorrendo normalmente nos principais aeroportos do país e a situação deve se normalizar até as 14h.
    ";
    //posiciona verticalmente 41mm
    $pdf->SetY("41");
    //posiciona horizontalmente 10mm
    $pdf->SetX("10");
    //escreve o conteudo de novo.. parametros posicao inicial,altura,conteudo(*texto),borda,quebra de linha,alinhamento
    $pdf->MultiCell(0,5,$novo,0,1,'J');

    //endereco da imagem,posicao X(horizontal),posicao Y(vertical), tamanho altura, tamanho largura
    $pdf->Image("teste.jpg", 8,20,20,20);
    /*******definindo o rodapé*************************/
    //posiciona verticalmente 270mm
    $pdf->SetY("270");
    //data atual
    $data=date("d/m/Y");
    $conteudo="criado em ".$data;
    $texto="por Alexandre Oliveira";

    //imprime uma celula... largura,altura, texto,borda,quebra de linha, alinhamento
    $pdf->Cell(0,0,'',1,1,'L');
    //imprime uma celula... largura,altura, texto,borda,quebra de linha, alinhamento
    $pdf->Cell(0,5,$texto,0,0,'L');
    //imprime uma celula... largura,altura, texto,borda,quebra de linha, alinhamento
    $pdf->Cell(0,5,$conteudo,0,1,'R');


    //imprime a saida do arquivo..
    $pdf->Output("arquivo","I");
    /*
    agora imaginem que estes dados viessem do banco de dados ?
    que maravilha hein ! seus artigos convertidos em pdf dinamicamente hein?
    ************************************************************************

    REFERENCIAS :
    FPDF - >Esta é o construtor da classe. Ele permite que seja definido o formato da página, a orientação e a unidade de medida usada em todos os métodos (exeto para tamanhos de fonte).
    utilizacao : FPDF([string orientation [, string unit [, mixed format]]])

    SetFont -> Define a fonte que será usada para imprimir os caracteres de texto. É obrigatória a chamada, ao menos uma vez, deste método antes de imprimir o texto ou o documento resultante não será válido.
    utilizacao : SetFont(string family [, string style [, float size]])

    SetTitle - >Define o título do documento.
    utilizacao : SetTitle(string title)

    SetSubject -> Define o assunto do documento
    utilizacao : SetSubject(string subject)

    SetX - >Define a abscissa da posição corrente. Se o valor passado for negativo, ele será relativo à margem direita da página.
    utilizacao : SetX(float x)

    SetY - > Move a abscissa atual de volta para margem esquerda e define a ordenada. Se o valor passado for negativo, ele será relativo a margem inferior da página.

    utilizacao : SetY(float y)

    Cell - > Imprime uma célula (área retangular) com bordas opcionais, cor de fundo e texto. O canto superior-esquerdo da célula corresponde à posição atual. O texto pode ser alinhado ou centralizado. Depois de chamada, a posição atual se move para a direita ou para a linha seguinte. É possível pôr um link no texto.
    Se a quebra de página automática está habilitada e a pilha for além do limite, uma quebra de página é feita antes da impressão.
    utilizacao - >Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, int fill [, mixed link]]]]]]])

    Ln - > Faz uma quebra de linha. A abscissa corrente volta para a margem esquerda e a ordenada é somada ao valor passado como parâmetro.
    utilizacao ->Ln([float h])

    MultiCell - > Este método permite imprimir um texto com quebras de linha. Podem ser automática (assim que o texto alcança a margem direita da célula) ou explícita (através do caracter \n). Serão geradas tantas células quantas forem necessárias, uma abaixo da outra.
    O texto pode ser alinhado, centralizado ou justificado. O bloco de células podem ter borda e um fundo colorido.
    utilizacao : MultiCell(float w, float h, string txt [, mixed border [, string align [, int fill]]])

    Image ->Coloca uma imagem na página - tipos suportados JPG PNG
    utilizacao : Image(string file, float x, float y [, float w [, float h [, string type [, mixed link]]]])


    Bom mais uma vez.. agradeço se for útil..
    qualquer dúvida: alexandre.etf@gmail.com !
    */
    ?>