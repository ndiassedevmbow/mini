<?php
$server = "localhost";
$login = "root";
$psw = "";

try {
    $bdd = new PDO("mysql:host=$server; dbname=gestCom", $login, $psw);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



    $stm = $bdd->prepare("SELECT idClient FROM client");
    $stm->execute();

    $stm2 = $bdd->prepare("SELECT idArticle FROM article");
    $stm2->execute();

    if (isset($_POST['btn'])) {
        if (empty($_POST['idClient']) || empty($_POST['dateC'])) {
            echo "Tous les champs doivent être remplis";
        } else {
            $idClient = htmlspecialchars($_POST['idClient']);
            $dateC = htmlspecialchars($_POST['dateC']);
            $req = $bdd->prepare("INSERT INTO commande(idClient, date) VALUES(:idClient, :dateC)");
            $req->bindParam(':idClient', $idClient);
            $req->bindParam(':dateC', $dateC);
            $req->execute();

            $idCommande = $bdd->lastInsertId();
            if (empty($_POST['idArticle']) || empty($_POST['qte'])) {
                echo "Tous les champs doivent être remplis";
            } else {
                $idArticle = htmlspecialchars($_POST['idArticle']);
                $qte = htmlspecialchars($_POST['qte']);
                $req2 = $bdd->prepare("INSERT INTO lignecommande(idArticle, idCommande, qte) VALUES(:idArticle, :idCommande, :qte)");
                $req2->bindParam(':idArticle', $idArticle);
                $req2->bindParam(':idCommande', $idCommande);
                $req2->bindParam(':qte', $qte);
                $req2->execute();
                header('Location: commandes.php');
            }
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Gestion commande</title>
    <script src="JQUERY/jquery-3.3.1.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
</head>
<body>

<div class="container">

    <header class="page-header">
        Ajouter des commandes
    </header>

    <div class="ALL">

        <form action="" method="post">

            <div class="form-group">
                <label for="idClient">ID client</label>
                <select name="idClient" required class="form-control">
                    <?php
                    foreach ($stm->fetchAll(PDO::FETCH_NUM) as $tabValues) {
                        foreach ($tabValues as $tabEl) {
                            echo "<option value=" . $tabEl . ">" . $tabEl . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="dateC">Date commande</label>
                <input type="date" name="dateC" id="dateC" placeholder="Date de commande" class="form-control" />
            </div>

            <div class="form-group">
                <label for="idArticle">ID Article</label>
                <select name="idArticle" required class="form-control">
                    <?php
                    foreach ($stm2->fetchAll(PDO::FETCH_NUM) as $tabValues) {
                        foreach ($tabValues as $tabEl) {
                            echo "<option value=" . $tabEl . ">" . $tabEl . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="qte">Quantite commande</label>
                <input type="number" name="qte" id="qte" placeholder="Quantité commande" class="form-control" />
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <input type="submit" class="btn btn-default btn-lg btn-block btn-success" name="btn" id="btn" value="Ajouter" />
                </div>
            </div>

        </form>

    </div>

</div>

</body>
</html>


<?php  
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>