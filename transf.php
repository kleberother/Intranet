<?php

//Programa para transferir programas QAS para Produção
ini_set("display_errors",1); 
//Diretórios
$html           =   "/var/www/html/"            ;
$htmlQAS        =   "/var/www/html/Intranet/"            ;
$app            =   $htmlQAS."app/"        ;
$controllers    =   $htmlQAS."controllers/";
$models         =   $htmlQAS."models/"     ;
$template       =   $htmlQAS."template/"   ;
$views          =   $htmlQAS."views/"      ;
$js             =   "js/interno/"               ;

//Arquivos
$index          =   "/var/www/html/index.php"   ;
if (is_numeric($_POST['programa']))
    $programa       =   "T".str_pad($_POST['programa'], 4, "0", STR_PAD_LEFT);
else
    $programa       =   $_POST['programa'];

//Usuário
$user           =   "root"                      ;
$servidor       =   "oraas041"                  ;

//Comando
$scp            =   "scp -r"                    ;

if (!empty($_POST))
{

    echo $shellApp           =   "$scp $app                             $user@$servidor:$html"                  ;echo "<BR><BR>";
    echo $shellControllers   =   "$scp $controllers"."$programa         $user@$servidor:$html"."controllers/"   ;echo "<BR><BR>";
    echo $shellModels        =   "$scp $models"."$programa              $user@$servidor:$html"."models/"        ;echo "<BR><BR>";
    echo $shellJs            =   "$scp $template"."$js"."$programa      $user@$servidor:$html"."template/js/"   ;echo "<BR><BR>";
    echo $shellTemplate      =   "$scp $template                        $user@$servidor:$html"."template/*.php" ;echo "<BR><BR>";
    echo $shellsViews        =   "$scp $views"."$programa               $user@$servidor:$html"."views/"         ;echo "<BR><BR>";
    echo $shellIndex         =   "$scp $index                           $user@$servidor:$html"                  ;echo "<BR><BR>";

    
    
//    
    $output =   shell_exec('scp -r /var/www/html/app/ root@oraas041:/var/www/html/');
    
    if($output)
        echo "deu";
    else
        echo "não deu";
    
    echo "<pre>$output</pre>";
//    if(shell_exec("scp -r /var/www/html/controllers/T0115 root@oraas041:/var/www/html/controllers/"))
//        echo "foi Controllers";
//    else
//        echo "não foi";        
//    if(shell_exec("scp -r /var/www/html/models/T0115 root@oraas041:/var/www/html/models/"))   
//        echo "foi Models";
//    else
//        echo "não foi";        
//    if(shell_exec("scp -r /var/www/html/template/js/interno/T0115 root@oraas041:/var/www/html/template/js/"))       
//        echo "foi JS";
//    else
//        echo "não foi";        
//    if(shell_exec("scp -r /var/www/html/template/ root@oraas041:/var/www/html/template/*.php")) 
//        echo "foi Template";
//    else
//        echo "não foi";        
//    if(shell_exec("scp -r /var/www/html/views/T0115 root@oraas041:/var/www/html/views/"))   
//        echo "foi Views";
//    else
//        echo "não foi";        
//    if(shell_exec("scp -r /var/www/html/index.php root@oraas041:/var/www/html/"))    
//        echo "foi Index";
//    else
//        echo "não foi";
//    header("Location:http://intranet?router=$programa/home");
}



?>
<html>
    <head>
        <title>Mover para Produção:</title>
    </head>
    <body>
        <form action="" method="post">
            <label>Programa:</label>
            <input type="text" name="programa"/>
            <input type="submit" value="Enviar"/>
        </form>
    </body>
</html>