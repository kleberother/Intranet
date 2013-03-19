<?php
//Classe para Usuarios
$obj  = new models_T0054();
$user = $_SESSION['user'];
?>
<style type="text/css">
    ul.displayMenu{
        width: 200px;
        margin: 30px auto;
    }

    ul.displayMenu li{
        margin: 20px 0;
    }

    ul.displayMenu li a{
        padding: 5px 0;
        display: block;
        border: 1px solid #000;
        text-align: center;
    }
    
    
</style>

<ul class="displayMenu">
    <li><a href='?router=T0054/js.display-01'>Display 01</a></li>
    <li><a href='?router=T0054/js.display-02'>Display 02</a></li>
    <li><a href='?router=T0054/js.display-03'>Display 03</a></li>
    <li><a href='?router=T0054/js.display-04'>Display 04</a></li>
    <li><a href='?router=T0054/js.display-05'>Display 05</a></li>
    <li><a href='?router=T0054/js.display-06'>Display 06</a></li>
</ul>