<?php   
$server = "localhost";
$login = "root";
$psw = "";

try {
    $bdd = new PDO("mysql:host=$server; dbname=gestCom", $login, $psw);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    if($_POST)
    {
      header("Location: index.php");
    }else{
    if(!empty($_GET['idCommande']))
    { 
           
              $req = "SELECT * FROM commande, client WHERE commande.idClient = client.idClient and idCommande = :idCommande";
              $stm = $bdd->prepare($req);
              $stm->execute(["idCommande" => $_GET["idCommande"]]);
              
              while($row = $stm->fetch(PDO::FETCH_ASSOC)){


                $reqView = "UPDATE commande SET view = :view WHERE idCommande = :idCommande";
                $stmReqView = $bdd->prepare($reqView);
                $stmReqView->execute(["idCommande" => $row["idCommande"], "view" => $row["view"]+1]);

                $reqView_select = "SELECT * FROM commande WHERE idCommande = :idCommande";
                $stmReqView_select = $bdd->prepare($reqView_select);
                $stmReqView_select->execute(["idCommande" => $row["idCommande"]]);

                $row_select = $stmReqView_select->fetch(PDO::FETCH_ASSOC);
      
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Details</title>
    <script src="JQUERY/jquery-3.3.1.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
</head>
<body>

<div class="container">

  <div style="float: right; color: blue">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
    </svg>
    <?php echo $row_select["view"]; ?>
  </div>

    <header class="page-header">
        Details commande
    </header>

    <div class="ALL">

        <form action="" method="post">

          <input type="hidden" name="myId" value="<?php echo $row["idCommande"]; ?>">


            <div class="form-group">
                <label for="idClient">ID client</label>
                <select name="idClient" required class="form-control" disabled>

                    <?php  
                    $res2 = $bdd->prepare("SELECT idClient FROM client");
                    $res2->execute();

                      while ($row2 = $res2->fetch()) { 
                        if($row["idClient"] == $row2["idClient"]){
                          $select = "selected";
                        }else{
                          $select = "";
                        }

                        echo "<option value=".$row["idClient"]. " " .$select. ">" .$row["idClient"]. "</option>";      
                      }
                    ?>

                </select>
              </div>

                
            


            <div class="form-group">
                <label for="date">Date commande</label>
                <input type="date" name="date" id="date" placeholder="Date Commande client" class="form-control" value="<?php echo $row["date"]; ?>" disabled/>
            </div>





<div class="form-group">
  <label for="qte">Quantite Commande</label>        
    <?php  
      $stm3 = $bdd->prepare("SELECT * FROM lignecommande WHERE idCommande = :idCommande");
      $stm3->execute(["idCommande" => $_GET["idCommande"]]);
      while($row3 = $stm3->fetch()){
    ?>
    <input type="text" name="qte" id="qte" placeholder="Quantite commande" class="form-control" value="<?php echo $row3["qte"]; ?>" disabled/>
     
  <?php 
  }
?>

</div>



<div class="form-group">
  <label for="nom">Nom client</label>        
    <input type="text" name="nom" id="nom" placeholder="Quantite commande" class="form-control" value="<?php echo $row["nom"]; ?>" disabled/>
</div>


<div class="form-group">
  <label for="telephone">Telephone client</label>        
    <input type="text" name="telephone" id="telephone" placeholder="Telephone client" class="form-control" value="<?php echo $row["telephone"]; ?>" disabled/>
</div>


<div class="form-group">
  <label for="ville">Ville client</label>        
    <input type="text" name="ville" id="ville" placeholder="Ville client" class="form-control" value="<?php echo $row["ville"]; ?>" disabled/>
</div>







<div class="form-group">
  <label for="idArticle">ID Article</label>
  <select name="idArticle" class="form-control">
    <?php  
      $stm4 = $bdd->prepare("SELECT DISTINCT idArticle FROM lignecommande");
      $stm4->execute();
      while($row4 = $stm4->fetch()) {
        $idArticle = $row4["idArticle"];
        $select = $_GET["idArticle"];
    ?>
    <option disabled value="<?php echo $idArticle; ?>"<?php if ($idArticle == $select) echo "selected"; ?>><?php echo $idArticle; ?></option>
    <?php 
      }
    ?>
  </select>
</div>


<?php } ?>



              <div class="row">
                <div class="col-lg-12">
                    <input type="submit" class="btn btn-default btn-lg btn-block btn-success" name="btn" id="btn" value="fermer"/>
                </div>
              </div>


        </form>

    </div>

</div>

</body>
</html>

  <?php 


  if(!empty($_POST))
      {
        $req = "UPDATE commande SET idClient=:idClient, date=:date WHERE idCommande = :idCommande";
        $stm3 = $bdd->prepare($req);
        $stm3->execute(["idClient" => $_POST["idClient"], "date" => $_POST["date"], "idCommande" => $_POST["myId"]]);
        header("Location:commandes.php");

        $req = "UPDATE lignecommande SET qte=:qte, idArticle=:idArticle WHERE idCommande = :idCommande";
        $stm3 = $bdd->prepare($req);
        $stm3->execute(["qte" => $_POST["qte"], "idArticle" => $_POST["idArticle"], "idCommande" => $_POST["myId"]]);
        header("Location:commandes.php");
      }

    }
    }

      } catch (Exception $e) {
      echo $e->getMessage();
    }
   ?>