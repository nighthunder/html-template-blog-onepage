<?php include_once('../rootdirectory.php'); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Rentabilidade Passiva - O site feito para te ajudar a ganhar dinheiro.</title>
    <!-- Boatstrap proper mobile options -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="The HTML5 Herald">
    <meta name="author" content="SitePoint">
    <!-- BOOSTRAP -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- FOLHA DE ESTILOS PRINCIPAL -->
    <link rel="stylesheet" href="includes/css/main.scss"/>

    <!--[if lt IE 9]>
    <![endif]-->

    <!--&lt;!&ndash; Go to www.addthis.com/dashboard to customize your tools &ndash;&gt; <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-527a74bb5779b67e"></script>-->

</head>

<body>
<?php

include_once("connection.php");

echo "<header class=\"navbar-static-top col-md-12 col-xs-12\">";
if (isset($_POST)) {
    if ($_POST){
        $connection = new createConnection();
        $conn = $connection->connectToDatabase();
        $stmt = $conn->prepare("Select * from users where email = :email");
        $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->fetchColumn()== 0) {
            echo "<p class='user-msg'>! Usuário inexistente !</p>";
        }else{
            $stmt = $conn->prepare("Select * from users where email = :email and passwd = MD5(:passwd)");
            $stmt->bindParam(':passwd', $_POST['passwd'], PDO::PARAM_STR);
            $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
            $stmt->execute();
            $num_rows = 1;
            $user_data = $stmt->fetchAll();
            if ($stmt->rowCount() == 0) {
                echo "<p class='user-msg'>! Senha incorreta !</p>";
            }else{
                session_start();
                $_SESSION['user'] = $user_data[0]['id'];
                $_SESSION['nick'] = $user_data[0]['nick'];
                $_SESSION['level'] = $user_data[0]['level'];
                $_SESSION['email'] = $user_data[0]['email'];
                print_r($_SESSION);
                header('Location: '.SITE_ROOT);
            }
            $conn = null;
        }
    }
}
echo "</header>";
?>
<div class="form">

    <ul class="tab-group">
        <li class="tab" id="login-link"><a href="#login">Quero logar</a></li>
    </ul>

    <div class="tab-content">

        <div id="login">
            <h1>Rentabilidade Passiva</h1>

            <form action="index.php" method="post" id="login-form">

                <div class="field-wrap">
                    <label>
                        Email Address<span class="req">*</span>
                    </label>
                    <input type="email"required autocomplete="off" value="" name="email"/>
                </div>

                <div class="field-wrap">
                    <label>
                        Password<span class="req">*</span>
                    </label>
                    <input type="password"required autocomplete="off" name="passwd"/>
                </div>

                <p class="forgot"><a href="#">Forgot Password?</a></p>

                <button type="submit" class="button button-block"/>Log In</button>

            </form>

        </div>

    </div><!-- tab-content -->

</div> <!-- /form -->

<!-- JQUERY PARA O BOOSTRAP JAVASCRIPT FUNCIONAR -->
<script
    src="https://code.jquery.com/jquery-3.2.1.min.js"
    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
    crossorigin="anonymous"></script>
<!-- JAVASCRIPT DO BOOTSTRAp -->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/includes/jquery/slideshow/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="includes/js/main.js"></script>
</body>
</html>