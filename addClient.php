<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Gestion client</title>
    <script src="JQUERY/jquery-3.3.1.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
</head>
<body>

<div class="container">

    <header class="page-header">
        Ajouter des client
    </header>

    <div class="ALL">

        <form action="" method="post">

            <div class="form-group">
                <label for="nom">Nom client</label>
                <input type="text" name="nom" id="nom" placeholder="Nom employe" class="form-control" />
            </div>

            <div class="form-group">
                <label for="ville">Ville client</label>
                <input type="text" name="ville" id="ville" placeholder="Ville client" class="form-control" />
            </div>

            <div class="form-group">
                <label for="tel">Telephone client</label>
                <input type="number" name="tel" id="tel" placeholder="Telephone client" class="form-control" />
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <input type="submit" class="btn btn-default btn-lg btn-block btn-success" name="add" id="add" value="Ajouter"/>
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

    if(isset($_POST['add']))
    {
        if(empty($_POST['nom']) && empty($_POST['ville']) && empty($_POST['tel'])){
            echo "Toutes les champs doivent etre rempli";
        }
        else{
            $req = $bdd->prepare("INSERT INTO client(nom, ville, telephone) VALUES(:nom, :ville, :tel)");

            $req->bindParam(':nom', $nom);
            $req->bindParam(':ville', $ville);
            $req->bindParam(':tel', $tel);

            $nom = htmlspecialchars($_POST['nom']);
            $ville = htmlspecialchars($_POST['ville']);
            $tel = htmlspecialchars($_POST['tel']);

            $req->execute();
            header('Location:clients.php');
        }

    }

     
 } catch (Exception $e) {
    echo "Erreur : " .$e->getMessage();
 } 
?>