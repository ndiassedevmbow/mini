<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <title> Gestion articles </title>
    <script src="JQUERY/jquery-3.3.1.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
</head>

<body>

<div class="container">

    <header class="page-header">
        Ajouter des Articles
    </header>

    <div class="ALL">

        <form action="" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="description">Decription article</label>
                <textarea id="description" name="description" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="pu">Prix unitaire article</label>
                <input type="number" name="pu" id="pu" placeholder="Prix unitaire article" class="form-control" />
            </div>

            <div class="form-group">
                <label for="img">Charger vos Image</label>
                <input type="hidden" name="MAXE-FILE-SIZE" value="1000000">
                <input type="file" name="img" id="img" placeholder="Prix unitaire article" class="form-control" />
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <input type="submit" class="btn btn-default btn-lg btn-block btn-success" name="addArt" id="addArt" value="Ajouter"/>
                </div>
            </div>

        </form>

    </div>

</div>

</body>
</html>




<?php 
$server = "localhost";
$login = "root";
$psw = "";

try {
    $bdd = new PDO("mysql:host=$server; dbname=gestCom", $login, $psw);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    if(isset($_POST["addArt"]))
    {


        if(!empty($_FILES["img"]["size"]) && !empty($_POST["description"]) && !empty($_POST["pu"]) && $_FILES["img"]["size"] < $_POST["MAXE-FILE-SIZE"])
        {
            if(!is_dir("Images"))
            {
                mkdir("Images");
            }
            $upload = move_uploaded_file($_FILES["img"]["tmp_name"], "Images/" .$_FILES["img"]["name"]);

            if($upload)
            {
                $req = $bdd->prepare("INSERT INTO Article(description, pu) VALUES(:description, :pu)");
                $req->bindParam(":description", $description);
                $req->bindParam(":pu", $pu);

                $description = $_POST["description"];
                $pu = $_POST["pu"];
                $req->execute();

                $idArtLast = $bdd->lastInsertId();

                $req2 = $bdd->prepare("INSERT INTO Image(descript, chemin, taille, idArticle) VALUES(:descript, :chemin, :taille, :idArticle)");
                $req2->bindParam(":descript", $descript);
                $req2->bindParam(":chemin", $chemin);
                $req2->bindParam(":taille", $taille);
                $req2->bindParam(":idArticle", $idArticle);

                $descript = $_FILES["img"]["name"];
                $chemin = "Images/" .$_FILES["img"]["name"];
                // $chemin = time()."Images/" .$_FILES["img"]["name"];
                $taille = $_FILES["img"]["size"];
                $idArticle = $idArtLast;
                $req2->execute();

                header('Location:articles.php');
            }
            else{
                echo 'Transfert non ok' .$_FILES["error"]["name"];
            }
        }
        else{
            echo "Toutes les champs doivent etre rempli";
            
        }
    }

     
 } catch (Exception $e) {
    echo "Erreur : " .$e->getMessage();
 } 
?>


<?php  

include_once 'footer.php';

?>
