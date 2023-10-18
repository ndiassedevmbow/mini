<?php   
$server = "localhost";
$login = "root";
$psw = "";

try {
    $bdd = new PDO("mysql:host=$server; dbname=gestCom", $login, $psw);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 
    
    if(!empty($_GET['idClient']))
    {
      $req = "SELECT * FROM CLIENT WHERE idClient = :idClient";
      $stm = $bdd->prepare($req);
      $stm->execute(["idClient" => $_GET["idClient"]]);

      while($row = $stm->fetch(PDO::FETCH_ASSOC)):
  
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Modification</title>
    <script src="JQUERY/jquery-3.3.1.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>

    <style type="text/css">
        a{
            text-align: center;
            text-decoration: none;
        }
        a:hover{
            text-align: center;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">

    <header class="page-header">
        Ajouter Modifications
    </header>

    <div class="ALL">

        <form action="" method="post">

          <input type="hidden" name="myId" value="<?php echo $row["idClient"]; ?>">

            <div class="form-group">
                <label for="nom">Nom client</label>
                <input type="text" name="nom" id="nom" placeholder="Nom employe" class="form-control" value="<?php echo $row["nom"]; ?>" />
            </div>

            <div class="form-group">
                <label for="ville">Ville client</label>
                <input type="text" name="ville" id="ville" placeholder="Ville client" class="form-control" value="<?php echo $row["ville"]; ?>" />
            </div>

            <div class="form-group">
                <label for="telephone">Telephone client</label>
                <input type="number" name="telephone" id="telephone" placeholder="Telephone client" class="form-control" value="<?php echo $row["telephone"]; ?>" />
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

  <?php 
    endwhile;
    }

      } catch (Exception $e) {
      echo $e->getMessage();
    }
   ?>



<?php 
if(!empty($_POST))
    {
      $req = "UPDATE CLIENT SET nom=:nom, ville=:ville, telephone=:telephone WHERE idClient = :idClient";
      $stm = $bdd->prepare($req);
      $stm->execute(["nom" => $_POST["nom"], "ville" => $_POST["ville"], "telephone" => $_POST["telephone"], "idClient" => $_POST["myId"]]);
      header("Location:clients.php");
    }
?>