<?php
$server = "localhost";
$login = "root";
$psw = "";

try {
    $bdd = new PDO("mysql:host=$server; dbname=gestCom", $login, $psw);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!empty($_GET['idArticle'])) {
        $idArticle = $_GET['idArticle'];

        if (!empty($_POST['description']) && !empty($_POST['pu'])) {
            // Mise à jour de l'Article
            $res = $bdd->prepare("UPDATE Article SET description = :description, pu = :pu WHERE idArticle = :idArticle");
            $res->execute(["description" => $_POST["description"], "pu" => $_POST["pu"], "idArticle" => $idArticle]);

            // Gestion de l'image
            if (!empty($_FILES["img"]["size"]) && $_FILES["img"]["size"] < $_POST["MAXE-FILE-SIZE"]) {
                if (!is_dir("Images")) {
                    mkdir("Images");
                }
                $upload = move_uploaded_file($_FILES["img"]["tmp_name"], "Images/" . $_FILES["img"]["name"]);

                if ($upload) {
                    $descript = $_FILES["img"]["name"];
                    $chemin = "Images/" . $_FILES["img"]["name"];
                    $taille = $_FILES["img"]["size"];

                    // Vérifiez si une image existe pour cet article
                    $res2 = $bdd->prepare("SELECT * FROM Image WHERE idArticle = :idArticle");
                    $res2->bindParam(':idArticle', $idArticle, PDO::PARAM_INT);
                    $res2->execute();

                    if ($res2->rowCount() > 0) {
                        // Si une image existe, mettez à jour les données de l'image
                        $res2 = $bdd->prepare("UPDATE Image SET descript = :descript, chemin = :chemin, taille = :taille WHERE idArticle = :idArticle");
                    } else {
                        // Si aucune image n'existe, insérez une nouvelle entrée d'image
                        $res2 = $bdd->prepare("INSERT INTO Image (idArticle, descript, chemin, taille) VALUES (:idArticle, :descript, :chemin, :taille)");
                    }

                    $res2->execute(["descript" => $descript, "chemin" => $chemin, "taille" => $taille, "idArticle" => $idArticle]);
                } else {
                    echo 'Transfert non ok ' . $_FILES["error"]["name"];
                }
            }

            header('Location: articles.php');
        }

        $res = $bdd->prepare("SELECT * FROM Article WHERE idArticle = :idArticle");
        $res->bindParam(':idArticle', $idArticle, PDO::PARAM_INT);
        $res->execute();

        $row = $res->fetch();

        $res2 = $bdd->prepare("SELECT * FROM Image WHERE idArticle = :idArticle");
        $res2->bindParam(':idArticle', $idArticle, PDO::PARAM_INT);
        $res2->execute();
        $row2 = $res2->fetch();
    }

} catch (Exception $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Modification</title>
    <script src="JQUERY/jquery-3.3.1.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
</head>
<body>

<div class="container">

    <header class="page-header">
        Modifier l'article
    </header>

    <div class="ALL">

        <form action="" method="post" enctype="multipart/form-data">

            <input type="hidden" name="myId" value="<?php echo $row["idArticle"]; ?>">

            <div class="form-group">
                <label for="description">Description de l'article</label>
                <textarea id="description" name="description" class="form-control"><?php echo $row["description"]; ?></textarea>
            </div>

            <div class="form-group">
                <label for="pu">Prix unitaire de l'article</label>
                <input type="number" name="pu" id="pu" placeholder="Prix unitaire de l'article" class="form-control" value="<?php echo $row["pu"]; ?>"/>
            </div>

            <div class="form-group">
                <label for="img">Modifier votre image</label>
                <input type="hidden" name="MAXE-FILE-SIZE" value="1000000">
                <input type="file" name="img" id="img" placeholder="Prix unitaire de l'article" class="form-control" />
            </div>

            <div class="form-group">
                <?php if (!empty($row2)) { ?>
                    <img src="<?php echo $row2['chemin']; ?>" width="150" height="150" alt="<?php echo $row2['descript']; ?>">
                <?php } else { ?>
                    Aucune image disponible.
                <?php } ?>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <input type="submit" class="btn btn-default btn-lg btn-block btn-success" name="btn" id="btn" value="Modifier"/>
                </div>
            </div>

        </form>

    </div>

</div>

</body>
</html>
