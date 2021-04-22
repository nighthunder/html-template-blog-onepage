<?php
/**
 * Created by PhpStorm.
 * User: Mayara
 * Date: 27/07/2017
 * Time: 10:29
 */

session_start();
if (!empty($_SESSION)){
    echo "<div id='logged-bar' class='col-md-12 col-xs-12'>";
    echo "<p class='logged-msg col-md-6'> Bem-vindo(a) " . $_SESSION['nick'] . " </p>";
    echo "<ul class='col-md-6'>";
    echo  "<li><a href=".SITE_ROOT.">Início</a></li>";
    if ($_SESSION['level'] == "1") {
        echo  "<li><a href=".SITE_ROOT."/admin/create.php>Criar postagem</a></li>";
    }else{
    }
    echo "<li><a href=".SITE_ROOT."/loggout.php>Sair</a></li>";
    echo "</ul>";
    echo "</div>";
}