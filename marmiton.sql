CREATE DATABASE marmiton;

USE marmiton;

CREATE TABLE recipes(
    id SMALLINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(250) NOT NULL, 
    description TEXT,
    prepare_time SMALLINT,
    cooking_time SMALLINT,
    wait_time SMALLINT,
    picture VARCHAR(255),
    ingredients TEXT,
    difficulty VARCHAR(20)
);

INSERT INTO recipes
(name, description, prepare_time,cooking_time,wait_time,picture,ingredients, difficulty)
VALUES
("Gaspacho tomates et figues","Préférez la tomate \"coeur de boeuf\", plus charnue. N'hésitez pas à essayer la recette avec divers types de pain (campagne, céréales...)",900,0,0,"https://assets.afcdn.com/recipe/20160707/2744_w2048h1536c1cx1500cy1000.webp","200 g de tomate, 250 g de figue, 50 poivrons, 25 g de pain, 1 dl d'huile d'olive, Sel, Piment d'Espelette","facile"),
("Tourte potiron courgette", "La courgette rend la texture de la garniture très onctueuse",1200,1800,0,"https://assets.afcdn.com/recipe/20171031/74136_w2048h1536c1cx2016cy3024cxt0cyt0cxb4032cyb6048.webp","2 pâtes feuilletées, 500 g de potiron cuit à la vapeur, 1 courgette râpée, 1 oignon, Persil, Poivre, Sel","moyenne");

