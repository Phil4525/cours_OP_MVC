<?php
function getPosts()
{
    // We connect to the database

    $database = dbConnect();

    // We retrieve the 5 last posts
    $statemant = $database->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS
     date_creation_fr FROM posts ORDER BY creation_date DESC LIMIT 0, 5');

    $posts = [];
    while (($row = $statemant->fetch())) {
        $post = [
            'title' => $row['title'],
            'french_creation_date' => $row['date_creation_fr'],
            'content' => $row['content'],
            'identifier' => $row['id'],
        ];
        $posts[] = $post;
    }

    return $posts;
}

function getPost($identifier)
{

    $database = dbConnect();

    $statement = $database->prepare(
        "SELECT id, title, content, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM posts WHERE id = ?"
    );
    $statement->execute([$identifier]);

    $row = $statement->fetch();
    $post = [
        'title' => $row['title'],
        'french_creation_date' => $row['french_creation_date'],
        'content' => $row['content'],
        'identifier' => $row['id'],
    ];

    return $post;
}

// Nouvelle fonction qui nous permet d'éviter de répéter du code
function dbConnect()
{
    $database = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
    return $database;
}
