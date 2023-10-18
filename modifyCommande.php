<?php   
$server = "localhost";
$login = "root";
$psw = "";

try {
    $bdd = new PDO("mysql:host=$server; dbname=gestCom", $login, $psw);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    if(!empty($_GET['idCommande']))
    {
      
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
        Ajouter Modifications
    </header>

    <div class="ALL">

        <form action="" method="post">

          <?php    
           
              $req = "SELECT * FROM commande WHERE idCommande = :idCommande";
              $stm = $bdd->prepare($req);
              $stm->execute(["idCommande" => $_GET["idCommande"]]);
              
              while($row = $stm->fetch(PDO::FETCH_ASSOC)){
          ?>

          <input type="hidden" name="myId" value="<?php echo $row["idCommande"]; ?>">


            <div class="form-group">
                <label for="idClient">ID client</label>
                <select name="idClient" required class="form-control">

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
                <input type="date" name="date" id="date" placeholder="Date Commande client" class="form-control" value="<?php echo $row["date"]; ?>" />
            </div>

<?php } ?>



<div class="form-group">
  <label for="qte">Quantite Commande</label>        
    <?php  
      $stm3 = $bdd->prepare("SELECT * FROM lignecommande WHERE idCommande = :idCommande");
      $stm3->execute(["idCommande" => $_GET["idCommande"]]);
      while($row3 = $stm3->fetch()){
    ?>
    <input type="text" name="qte" id="qte" placeholder="Quantite commande" class="form-control" value="<?php echo $row3["qte"]; ?>" />
     
  <?php 
  }
?>

</div>




<div class="form-group">
  <label for="idArticle">ID Article</label>
  <select name="idArticle" class="form-control">
    <option value="-----------"></option>
    <?php  
      $stm4 = $bdd->prepare("SELECT DISTINCT idArticle FROM lignecommande");
      $stm4->execute();
      while($row4 = $stm4->fetch()) {
    ?>
    <option value="<?php echo $row4["idArticle"]; ?>"><?php echo $row4["idArticle"]; ?></option>
    <?php 
      }
    ?>
  </select>
</div>

</select>
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

      } catch (Exception $e) {
      echo $e->getMessage();
    }
   ?>