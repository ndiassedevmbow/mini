<?php  

$server = "localhost";
$login = "root";
$psw = "";

try {
    $bdd = new PDO("mysql:host=$server; dbname=gestCom", $login, $psw);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if (isset($_GET['idClient']) AND !empty($_GET['idClient'])) {
    $getIdClient = $_GET['idClient'];
    $recup = $bdd->prepare('SELECT * FROM client where idClient = ?');
    $recup->execute(array($getIdClient));

      if($recup->rowCount() > 0){
        $ban = $bdd->prepare('DELETE FROM client where idClient = ?');
        $ban->execute(array($getIdClient));
        header('Location: clients.php');
      }
  }



  if (isset($_GET['idArticle']) AND !empty($_GET['idArticle'])) {
    $getIdArt = $_GET['idArticle'];
    $recup = $bdd->prepare('SELECT * FROM article where idArticle = ?');
    $recup->execute(array($getIdArt));

      if($recup->rowCount() > 0){
        $ban = $bdd->prepare('DELETE FROM article where idArticle = ?');
        $ban->execute(array($getIdArt));
        header('Location: articles.php');
      }
  }

  if (isset($_GET['idCommande']) AND !empty($_GET['idCommande'])) {
    $getIdCom = $_GET['idCommande'];
    $recup = $bdd->prepare('SELECT * FROM commande where idCommande = ?');
    $recup->execute(array($getIdCom));

      if($recup->rowCount() > 0){
        $ban = $bdd->prepare('DELETE FROM commande where idCommande = ?');
        $ban->execute(array($getIdCom));
        header('Location: commandes.php');
      }
  }








if (!empty($_POST["idCommande"])) {
    $idCommande = $_POST["idCommande"];

 // Supprimer la commande elle-même
    $queryDeleteCommande = "DELETE FROM commande WHERE idCommande = :idCommande";
    $stmDeleteCommande = $bdd->prepare($queryDeleteCommande);
    $stmDeleteCommande->execute(["idCommande" => $idCommande]);


    
    // Supprimer les lignes de commande associées à cette commande
    $queryDeleteLigneCommande = "DELETE FROM lignecommande WHERE idCommande = :idCommande";
    $stmDeleteLigneCommande = $bdd->prepare($queryDeleteLigneCommande);
    $stmDeleteLigneCommande->execute(["idCommande" => $idCommande]);


    header('Location: commandes.php');
}

   } catch (Exception $e) {
      echo $e->getMessage();
    }
    
?>

<?php 
// if(in_array($ligne["idCommande"], $list)) echo "disabled"; 
?>