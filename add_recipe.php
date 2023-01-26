<?php
if (!empty($_POST)) {
    //Le formulaire est envoyé
    //Utilisation de la fonction strip_tags pour supprimer d'éventuelles balises HTML qui se seraient glissées dans le champ input et palier à la faille XXS
    //Utilisation de la fonction trim pour supprimer d'éventuels espaces en debut et fin de chaine
    $name = trim(strip_tags($_POST["name"]));
    $picture = trim(strip_tags($_POST["picture"]));
    $description = trim(strip_tags($_POST["description"]));
    $ingredients = trim(strip_tags($_POST["ingredients"]));
    $difficulty = trim(strip_tags($_POST["difficulty"]));
    $prepare_time = trim(strip_tags($_POST["prepare_time"]));
    $cooking_time = trim(strip_tags($_POST["cooking_time"]));
    $wait_time = trim(strip_tags($_POST["wait_time"]));

    $errors = [];

    //Valider que le champ name est bien renseigné
    if (empty($name)) {
        $errors["name"] = "Le nom de la recette est obligatoire";
    }

    //Validation de l'url de l'image de la recette
    if (!filter_var($picture, FILTER_VALIDATE_URL)) {
        $errors["picture"] = "L'url de l'image est invalide";
    }

    if ($prepare_time < 0) {
        $errors["prepare_time"] = "Le temps ne peut etre inferieur à 0";
    }

    // Requête d'insertion en BDD de la recette s'il n'y a aucune erreur
    if (empty($errors)) {
        //Connexion à la base marmiton
        $dsn = "mysql:host=localhost;dbname=marmiton";
        $db = new PDO($dsn, "root", "");
        
        //La valeur attendue pour les durées est en seconde et non en minute
        $prepare_time_second = $prepare_time * 60;
        $cooking_time_second = $cooking_time * 60;
        $wait_time_second = $wait_time * 60;

        $query = $db->prepare("INSERT INTO recipes (name, description, picture, ingredients, prepare_time, cooking_time, wait_time,difficulty) VALUES (:name, :description, :picture, :ingredients, :prepare_time, :cooking_time, :wait_time, :difficulty)");
        $query->bindPAram(":name", $name);
        $query->bindPAram(":description", $description);
        $query->bindPAram(":picture", $picture);
        $query->bindPAram(":difficulty", $difficulty);
        $query->bindPAram(":ingredients", $ingredients);
        $query->bindPAram(":prepare_time", $prepare_time_second,PDO::PARAM_INT);
        $query->bindPAram(":cooking_time", $cooking_time_second,PDO::PARAM_INT);
        $query->bindPAram(":wait_time", $wait_time_second,PDO::PARAM_INT);

        if($query->execute()){
            //La requête s'est bien déroulée donc on redirige l'utilisateur vers la page d'accueil
            header("Location: index.php");
        }
    }
}

include("templates/header.php");
?>
<h1>Ajouter une recette</h1>
<!-- Lorsque l'attribut action est vide les données du formulaire sont envoyées à la meme page -->
<form action="" method="post">
    <div class="form-group">
        <label for="inputName">Nom de la recette</label>
        <input id="inputName" type="text" name="name" value="<?= isset($name) ? $name : "" ?> ">
        <?php
        if (isset($errors["name"])) {
        ?>
            <span class="info-error"><?= $errors["name"] ?></span>
        <?php
        }
        ?>
    </div>

    <div class="form-group">
        <label for="inputPicture">Photo de la recette</label>
        <input id="inputPicture" type="text" name="picture" value="<?= isset($picture) ? $picture : "" ?> ">
        <?php
        if (isset($errors["picture"])) {
        ?>
            <span class="info-error"><?= $errors["picture"] ?></span>
        <?php
        }
        ?>
    </div>

    <div class="form-group">
        <label for="textareaDescription">Description :</label>
        <textarea id="textareaDescription" name="description" cols="30" rows="10"><?= isset($description) ? $description : "" ?></textarea>
    </div>

    <div class="form-group">
        <label for="textareaIngredients">Ingrédients :</label>
        <textarea id="textareaIngredients" name="ingredients" cols="30" rows="10"><?= isset($ingredients) ? $ingredients : "" ?></textarea>
    </div>

    <div class="form-group">
        <label for="selectDifficulty">Choisissez la difficulté :</label>
        <select name="difficulty" id="selectDifficulty">
            <option <?= isset($difficulty) && $difficulty === "facile" ? "selected" : "" ?> value="facile">Facile</option>

            <option <?= isset($difficulty) && $difficulty === "moyen" ? "selected" : "" ?> value="moyen">Moyen</option>

            <option <?= isset($difficulty) && $difficulty === "difficile" ? "selected" : "" ?> value="difficile">Difficile</option>
        </select>
    </div>

    <div class="form-group">
        <label for="inputPrepareTime">Temps de preparation :</label>
        <input type="number" name="prepare_time" id="inputPrepareTime" value="<?= isset($prepare_time) ? $prepare_time : 0 ?>" min="0">
        <?php
        if (isset($errors["prepare_time"])) {
        ?>
            <span class="info-error"><?= $errors["prepare_time"] ?></span>
        <?php
        }
        ?>
    </div>

    <div class="form-group">
        <label for="inputCookingTime">Temps de cuisson :</label>
        <input type="number" name="cooking_time" id="inputCookingTime" value="<?= isset($cooking_time) ? $cooking_time : 0 ?>" min="0">
    </div>
    <div class="form-group">
        <label for="inputWaitTime">Temps d'attente :</label>
        <input type="number" name="wait_time" id="inputWaitTime" value="<?= isset($wait_time) ? $wait_time : 0 ?>" min="0">
    </div>


    <input type="submit" value="Ajouter la recette" class="btn-marmiton">
</form>

<?php
include("templates/footer.php");
?>