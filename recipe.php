<?php
function convertSecondsToMinutes($seconds)
{
    return $seconds / 60;
}

$find = false;
$data = array("name" => "Recette introuvable");
if (isset($_GET["id"])) {
    // on sait qu'il y a un paramètre id dans l'url
    // MAIS pour autant ça ne garantit pas que l'id de la recette existe réellement

    //Connexion à la base marmiton
    $dsn = "mysql:host=localhost;dbname=marmiton";
    $db = new PDO($dsn, "root", "");

    //Requete pour tenter de retrouver cette recette

    // 1/On prépare la requete SQL avec des paramètres
    $query = $db->prepare("SELECT * FROM recipes WHERE id=  :id");

    // 2/ On donne des valeurs à nos parametres
    $query->bindParam(":id", $_GET["id"], PDO::PARAM_INT);
    //la valeur sur laquelle on veut agir - la valeur quon va donner- optionnel le type de la valeur donnée par défaut string
    
    // 3/ On execute notre requête préalablement préparée
    $query->execute();
    $recipe = $query->fetch();// retourne un tableau associatif de la recette concernée ou false si pas de correspondance

    if($recipe) {
            // nous avons trouvé la recette \o/
            $find = true;

            $recipe["prepare_time"] = convertSecondsToMinutes($recipe["prepare_time"]);
            $recipe["cooking_time"] = convertSecondsToMinutes($recipe["cooking_time"]);
            $recipe["wait_time"] = convertSecondsToMinutes($recipe["wait_time"]);

            $data = $recipe;
        }
}


// Inclure le template header
include("templates/header.php");
?>
<h1><?= $data["name"] ?></h1>
<?php
if ($find) {
?>
    <img src="<?= $data["picture"] ?>" alt="" class="recipe-picture">
    <p><?= $data["description"] ?></p>
    <p><?= $data["ingredients"] ?></p>
    <p>Préparation : <?= $data["prepare_time"] ?> minutes</p>
    <p>Cuisson : <?= $data["cooking_time"] ?> minutes</p>
    <p>Attente : <?= $data["wait_time"] ?> minutes</p>
<?php
}

// Inclure le template footer
include("templates/footer.php");
?>