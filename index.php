<?php
//Connexion à la base marmiton
$dsn = "mysql:host=localhost;dbname=marmiton";
$db = new PDO($dsn, "root", "");

//Récuperer les recettes de la table recipes
$query = $db->query("SELECT * FROM recipes");
//Le parametre PDO::FETCH_ASSOC permet de ne récupérer les résultats qu'au format associatif et non les deux
$recipes = $query->fetchAll(PDO::FETCH_ASSOC);

// Inclure le template header
include("templates/header.php");
?>
<h1>Nos recettes</h1>
<div class="recipes">
    <?php
    foreach ($recipes as $recipe) {
    ?>
        <div class="recipe">
            <img src="<?= $recipe["picture"] ?>" alt="">
            <h2>
                <a  href="recipe.php?id=<?= $recipe["id"] ?>"><?= $recipe["name"] ?></a>
            </h2>
            <p>Difficulté : <?= $recipe["difficulty"] ?></p>
        </div>
    <?php
    }
    ?>
</div>
<?php
// Inclure le template footer
include("templates/footer.php");
?>