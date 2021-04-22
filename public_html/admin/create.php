<?php

include_once('../rootdirectory.php');
include_once('../logged-bar.php');
include_once('connection.php');

// tratamento de sessão
if (isset($_SESSION)){
    if ($_SESSION['level'] != 1){
        header("Location: ".SITE_ROOT);
    }
}else{
    header('Location: '.SITE_ROOT);
}

?>
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
    <link rel="stylesheet" href="../includes/css/style.css">

    <!-- LOGGED-BAR STYLESHEET -->
    <link rel="stylesheet" href="../includes/css/logged-bar.css">

    <!--[if lt IE 9]>
    <![endif]-->

    <!--&lt;!&ndash; Go to www.addthis.com/dashboard to customize your tools &ndash;&gt; <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-527a74bb5779b67e"></script>-->

</head>

<body>
<?php

if (!empty($_POST)){
    if ($_POST){

        try {
            if (!($_FILES['userfile']['size'] == 0)) {

                $uploaddir = '../uploads/posts_images/';
                $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
                $imageFileType = pathinfo($uploadfile, PATHINFO_EXTENSION);

                echo '<pre>';

                if (file_exists($uploadfile)) {   // Check if file already exists
                    echo "Desculpe, arquivo já existe.";
                } else if ($_FILES["userfile"]["size"] > 2621440) {
                    echo "Sorry, your file is too large.";
                } else if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" // check file types
                    && $imageFileType != "gif"
                ) {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                } else {
                    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
                        echo "Arquivo válido e enviado com sucesso.\n";
                    } else {
                        echo "Possível ataque de upload de arquivo!\n";
                    }

                    // echo 'Aqui está mais informações de debug:';
                    //print_r($_FILES);
                }
                print "</pre>";
            }

        } catch (RuntimeException $e) {

            echo $e->getMessage();

        }

        try {
            $connection = new createConnection();
            $conn = $connection->connectToDatabase();
            $stmt = $conn->prepare("INSERT INTO posts (id, title, content, img_url, timestamp) VALUES (DEFAULT,:title, :content, :img_url ,DEFAULT)");
            $stmt->bindParam(':title', $_POST['title']);
            $stmt->bindParam(':content', $_POST['content']); //$stmt->debugDumpParams();
            $stmt->bindParam(':img_url', $_FILES['userfile']['name']);
            $return = $stmt->execute();
            $stmt1 = $conn->prepare("Select MAX(id) from posts");
            $stmt1->execute();
            $post_id = $stmt1->fetchColumn(0);
            if (isset($_POST['categories'])) {
                foreach ($_POST['categories'] as $cat) {
                    $stmt = $conn->prepare("INSERT INTO post_category (post_id, category_id, timestamp) VALUES (:post_id, $cat, DEFAULT)");
                    $stmt->bindParam(':post_id',$post_id);
                    $stmt->execute();
                }

            }
            echo "<pre>";
            if ($return) {
                echo "Adicionado com sucesso";
            }
            echo "</pre>";
            $conn = null;
        }catch (PDOException $e){
            echo "Error: ".$e->getMessage();
        }
    }
}

?>
<a href="#topo"><img id="anchor" src="../includes/media/anchor.png"/></a>

<div id="content">
    <div class="col-xs-12 col-md-7 col-md-offset-1 content div-border-effect">
        <h1 class="post-title">Adicionar um post</h1>
        <form method="post" enctype="multipart/form-data" action="/admin/create.php">
            <input type="hidden" name="MAX_FILE_SIZE" value="2621440" />
            <p><label for="title"> Title: &nbsp;<input type="text" name="title" required></label></p>

            <p><label for="content"> Corpo:</label><BR />
                <textarea name="content" cols="80" rows="20"></textarea></p>

            <p>
                <label for="categories"> Categorias:

                    <?php

                        $connection = new createConnection();
                        $conn = $connection->connectToDatabase();
                        $stmt = $conn->prepare("Select * from categories");
                        $stmt->execute();
                        foreach ($stmt->fetchAll() as $cat){
                            echo "<label>".UTF8_Encode($cat['name'])."</label><input type='checkbox' name='categories[]' value=".$cat['id'].">";
                        }

                    ?>

            </p>

            <p><label for="img">Imagem: <input type="file" name="userfile" id="userfile"></label></p>
            <button type="submit">Adicionar</button>
        </form>
    </div>
</div>

<footer class="col-md-12 col-xs-12">
    <div class="col-md-6 col-xs-12 col-md-offset-1"><blockquote>"O rentabilidade passiva foi criado para te ajudar a ganhar dinheiro enquanto você dorme. Este site reune informação útil para te ajudar a ganhar dinheiro.".</blockquote></div>
    <div class="col-md-5 col-xs-12"><img class="col-md-offset-4" id="footer-img" src="../includes/media/footer.png"/></div>
    <div class="row copyright"></div>
</footer>

<!-- JQUERY PARA O BOOSTRAP JAVASCRIPT FUNCIONAR -->
<script
    src="https://code.jquery.com/jquery-3.2.1.min.js"
    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
    crossorigin="anonymous"></script>
<!-- JAVASCRIPT DO BOOTSTRAp -->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/includes/jquery/slideshow/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>