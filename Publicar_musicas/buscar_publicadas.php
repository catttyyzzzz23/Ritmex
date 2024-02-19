<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" href="../Imagens/logo2.png">
    <title>Publicadas</title>
</head>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ritmex";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão com a base de dados: " . $conn->connect_error);
}

$id_Artista = $_SESSION['user_id'];

// Consulta SQL para obter todas as músicas do artista
$sql = "SELECT * FROM musica WHERE id_Artista = $id_Artista";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Exibir todas as músicas
    echo "<h1 style='color:white; text-align:center;'><a href='../Login/index_artistas.php' style='color:white; text-decoration: none;'>As Suas Músicas</a></h1>";
    while ($row = $result->fetch_assoc()) { 
        echo"<center style='color:white; font-size:18px;margin-top:30px;'>";
                echo " Título: " . $row["titulo"] . "<br>";
                echo " Duração: " . $row["duracao"] . "<br>";
                echo " Data de lançamento: " . $row["data_lancamento"] . "<br>";
                echo"</center>";
                // Consultar informações relacionadas às chaves estrangeiras
                $id_album = $row["id_Album"];
                $id_genero = $row["id_Genero"];

                // Obter nome do álbum
                $sql_album = "SELECT nome_album FROM albuns WHERE id_Album = $id_album";
                $result_album = $conn->query($sql_album);
                $album_row = $result_album->fetch_assoc();
                echo"<center style='color:white; font-size:18px;'>";
                echo " Álbum: " . $album_row["nome_album"] . "<br>";
                echo"</center>";

                // Obter nome do gênero
                $sql_genero = "SELECT nome_genero FROM generos WHERE id_Genero = $id_genero";
                $result_genero = $conn->query($sql_genero);
                $genero_row = $result_genero->fetch_assoc();
                echo"<center style='color:white; font-size:18px;'>";
                echo " Gênero: " . $genero_row["nome_genero"] . "<br>";
                echo"</center>";

                echo"<center style='margin-top:30px;'>";
                echo "<audio controls>";
                echo "<source src='../Imagens/{$row['caminho_mp3']}' type='audio/mp3'>";
                echo "Seu navegador não suporta o elemento de áudio.";
                echo "</audio>";
                echo"<hr>";
                echo"</center>";

    }
} else {
    echo "<center style='color:white;'>Nenhuma música encontrada.</center>";
}

$conn->close();
?>
