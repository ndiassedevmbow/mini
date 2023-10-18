<?php  
    $index = true;
    include_once 'header.php';
?>

<main class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5">Index</h1>
        <?php 
            $server = "localhost";
            $login = "root";
            $psw = "";

            try {
                $bdd = new PDO("mysql:host=$server;dbname=gestCom", $login, $psw);
                $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $res = $bdd->prepare("
                    SELECT CL.nom, CL.telephone, CL.ville, C.date, C.idCommande, A.description, A.pu, A.idArticle, LC.qte
                    FROM client as CL, commande as C, article as A, lignecommande as LC 
                    WHERE 
                        CL.idClient = C.idClient AND
                        LC.idCommande = C.idCommande AND
                        LC.idArticle = A.idArticle
                ");
                $res->execute();

                if($res->rowCount() > 0)
                {
        ?>
        <table id="myTable" class="display">
            <thead>
                <tr>
                    <th></th>
                    <th>NOM</th>
                    <th>TELEPHONE</th>
                    <th>VILLE</th>
                    <th>DATE</th>
                    <th>DESCRIPTION</th>
                    <th>PRIX UNITAIRE</th>
                    <th>QUANTITE</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    // CIBLE UN ARTICLE SPECIFIQUE
                    $count = 0;
                    while ($row = $res->fetch()) {  
                        $count++;
                ?>
                    <tr>
                        <td>
                            <a href="details.php?idCommande=<?php echo $row["idCommande"]; ?>&idArticle=<?php echo $row["idArticle"]; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                </svg>
                            </a>
                        </td>
                        <td><?php echo $row["nom"]; ?></td>
                        <td><?php echo $row["telephone"]; ?></td>
                        <td><?php echo $row["ville"]; ?></td>
                        <td><?php echo $row["date"]; ?></td>
                        <td><?php echo $row["description"]; ?></td>
                        <td><?php echo $row["pu"]; ?></td>
                        <td><?php echo $row["qte"]; ?></td>
                    </tr>
                <?php 
                    } 
                } 
                ?>
            </tbody>
        </table>
    </div>
</main>
<?php  
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    } 
    include_once 'footer.php';
?>
