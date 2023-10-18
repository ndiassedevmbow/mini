<?php  
include_once 'header.php';
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Demo</title>
    <script src="JQUERY/jquery-3.3.1.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
</head>
<body>


<?php  
try {
	$bdd = new PDO("mysql:host=localhost; dbname=gestCom", "root", "");
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


	$req = $bdd->prepare("SELECT CLIENT.nom FROM CLIENT limit 100");
	$req->execute();

	if($req->rowCount() > 0)
	{
?>

<h1 class="jumbotron">
	Liste de tout les clients
</h1>
<table class="table table-bordered">
	<tr>
		<th>
			Nom
		</th>
	</tr>
	<?php 
	while($res = $req->fetch())
	{ 
	?>
	<tr>
		<td>
			<?php echo $res["nom"]; ?>	
		</td>
	</tr>
<?php
	}
	}
?>
</table>





<?php  
	$req = $bdd->prepare("SELECT * FROM CLIENT WHERE CLIENT.VILLE = 'kaolack'");
	$req->execute();

	if($req->rowCount() > 0)
	{
?>

<h1 class="jumbotron">
	Liste de tout les clients de kaolack
</h1>
<table class="table table-bordered">
	<tr>
		<th>
			Nom
		</th>
		<th>
			Ville
		</th>
		<th>
			Telephone
		</th>
	</tr>
	<?php 
	while($res = $req->fetch())
	{ 
	?>
	<tr>
		<td>
			<?php echo $res["nom"]; ?>	
		</td>
		<td>
			<?php echo $res["ville"]; ?>		
		</td>
		<td>
			<?php echo $res["telephone"]; ?>	
		</td>
	</tr>
<?php
	}
	}
?>
</table>





<?php  
	$marque = "lenovo"; 
	$req = $bdd->prepare("SELECT * FROM CLIENT AS CL, COMMANDE AS CM, LIGNECOMMANDE AS LC, ARTICLE AS ART WHERE CL.idClient = CM.idClient AND LC.idArticle = ART.idArticle AND LC.idCommande = CM.idCommande AND ART.description = 'crayon couleur'");

	$req->execute();

	if($req->rowCount() > 0)
	{
?>

<h1 class="jumbotron">
	Liste des clients qui ont commande un crayon couleur
</h1>
<table class="table table-bordered">
	<tr>
		<th>
			Nom
		</th>
		<th>
			Ville
		</th>
		<th>
			Telephone
		</th>
	</tr>
	<?php 
	while($res = $req->fetch())
	{ 
	?>
	<tr>
		<td>
			<?php echo $res["nom"]; ?>	
		</td>
		<td>
			<?php echo $res["ville"]; ?>		
		</td>
		<td>
			<?php echo $res["telephone"]; ?>	
		</td>
	</tr>
<?php
	}
	}
?>
</table>








<?php  
	$ville = "thies"; 
	$req = $bdd->prepare("SELECT * FROM CLIENT WHERE client.ville != '.$ville.'");
	$req->execute();

	if($req->rowCount() > 0)
	{
?>

<h1 class="jumbotron">
	Liste des noms des clients qui ne sont pas de thies
</h1>
<table class="table table-bordered">
	<tr>
		<th>
			Nom
		</th>
		<th>
			Ville
		</th>
		<th>
			Telephone
		</th>
	</tr>
	<?php 
	while($res = $req->fetch())
	{ 
	?>
	<tr>
		<td>
			<?php echo $res["nom"]; ?>	
		</td>
		<td>
			<?php echo $res["ville"]; ?>		
		</td>
		<td>
			<?php echo $res["telephone"]; ?>	
		</td>
	</tr>
<?php
	}
	}
?>
</table>







<?php  
	$req = $bdd->prepare("SELECT * FROM CLIENT WHERE client.ville IN ('kaolack', 'kolda')");
	$req->execute();

	if($req->rowCount() > 0)
	{
?>

<h1 class="jumbotron">
	Liste des noms des clients qui sont de kaolack et kolda
</h1>
<table class="table table-bordered">
	<tr>
		<th>
			Nom
		</th>
		<th>
			Ville
		</th>
		<th>
			Telephone
		</th>
	</tr>
	<?php 
	while($res = $req->fetch())
	{ 
	?>
	<tr>
		<td>
			<?php echo $res["nom"]; ?>	
		</td>
		<td>
			<?php echo $res["ville"]; ?>		
		</td>
		<td>
			<?php echo $res["telephone"]; ?>	
		</td>
	</tr>
<?php
	}
	}
?>
</table>






<?php  
	$req = $bdd->prepare("SELECT description FROM ARTICLE AS ART, COMMANDE AS CM, LIGNECOMMANDE AS LC WHERE LC.idArticle = ART.idArticle AND LC.idCommande = CM.idCommande AND (ART.description = 'crayon couleur' AND LC.qte < 15) || (LC.qte > 2000) ");
	$req->execute();

	if($req->rowCount() > 0)
	{
?>

<h1 class="jumbotron">
	ARTICLE si crayon couleur et qte < 15 sinon > 2000
</h1>
<table class="table table-bordered">
	<tr>
		<th>
			Description
		</th>
	</tr>
	<?php 
	while($res = $req->fetch())
	{ 
	?>
	<tr>
		<td>
			<?php echo $res["description"]; ?>	
		</td>
	</tr>
<?php
	}
	}
?>
</table>





<?php  
	$req = $bdd->prepare("SELECT * FROM CLIENT AS CL NATURAL JOIN COMMANDE AS CM WHERE CL.idClient = CM.idClient AND CM.date = '1000-01-01'");
	$req->execute();

	if($req->rowCount() > 0)
	{
?>

<h1 class="jumbotron">
	les clients qui ont passe une commande le '1000-01-01'
</h1>
<table class="table table-bordered">
	<tr>
		<th>
			nom
		</th>
		<th>
			ville
		</th>
		<th>
			telephone
		</th>
	</tr>
	<?php 
	while($res = $req->fetch())
	{ 
	?>
	<tr>
		<td>
			<?php echo $res["nom"]; ?>	
		</td>
		<td>
			<?php echo $res["ville"]; ?>	
		</td>
		<td>
			<?php echo $res["telephone"]; ?>	
		</td>
	</tr>
<?php
	}
	}
?>
</table>







<?php  
	$req = $bdd->prepare("SELECT DISTINCT CL.*  FROM CLIENT AS CL, COMMANDE AS CM, LIGNECOMMANDE AS LC, ARTICLE AS ART WHERE CL.idClient = CM.idClient AND LC.idArticle = ART.idArticle AND LC.idCommande = CM.idCommande AND LC.qte >= 1999");
	$req->execute();

	if($req->rowCount() > 0)
	{
?>

<h1 class="jumbotron">
	les clients qui ont passe une commande > 1999
</h1>
<table class="table table-bordered">
	<tr>
		<th>
			nom
		</th>
		<th>
			ville
		</th>
		<th>
			telephone
		</th>
	</tr>
	<?php 
	while($res = $req->fetch())
	{ 
	?>
	<tr>
		<td>
			<?php echo $res["nom"]; ?>	
		</td>
		<td>
			<?php echo $res["ville"]; ?>	
		</td>
		<td>
			<?php echo $res["telephone"]; ?>	
		</td>
	</tr>
<?php
	}
	}
?>
</table>





<?php  
	$req = $bdd->prepare("SELECT CL.*  FROM CLIENT AS CL LEFT JOIN COMMANDE AS CM ON CL.idClient = CM.idClient WHERE CM.idClient IS NULL");
	$req->execute();

	if($req->rowCount() > 0)
	{
?>

<h1 class="jumbotron">
	les clients qui n'ont pas passe de commande
</h1>
<table class="table table-bordered">
	<tr>
		<th>
			nom
		</th>
		<th>
			ville
		</th>
		<th>
			telephone
		</th>
	</tr>
	<?php 
	while($res = $req->fetch())
	{ 
	?>
	<tr>
		<td>
			<?php echo $res["nom"]; ?>	
		</td>
		<td>
			<?php echo $res["ville"]; ?>	
		</td>
		<td>
			<?php echo $res["telephone"]; ?>	
		</td>
	</tr>
<?php
	}
	}
?>
</table>





<?php  
	$req = $bdd->prepare("
	SELECT c.* FROM client AS c WHERE NOT EXISTS (
	SELECT art.idArticle FROM article AS art WHERE NOT EXISTS (
	SELECT lc.idArticle FROM lignecommande AS lc WHERE lc.idCommande IN (
	SELECT co.idCommande FROM commande AS co WHERE co.idClient = c.idClient) AND lc.idArticle = art.idArticle)
										        );
");
	$req->execute();

	if($req->rowCount() > 0)
	{
?>

<h1 class="jumbotron">
	les clients qui n'ont pas passe de commande
</h1>
<table class="table table-bordered">
	<tr>
		<th>
			nom
		</th>
		<th>
			ville
		</th>
		<th>
			telephone
		</th>
	</tr>
	<?php 
	while($res = $req->fetch())
	{ 
	?>
	<tr>
		<td>
			<?php echo $res["nom"]; ?>	
		</td>
		<td>
			<?php echo $res["ville"]; ?>	
		</td>
		<td>
			<?php echo $res["telephone"]; ?>	
		</td>
	</tr>
<?php
	}
	}
?>
</table>






<?php
} catch (Exception $e) {
	echo "Erreur de connexion" .$e->getMessage();
}
?>
</body>
</html>

<?php  
include_once 'footer.php';
?>