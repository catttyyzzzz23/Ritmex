<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ritmex";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão com a base de dados: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $music_name = $_POST["titulo"];
    $artist_name = $_POST["artista"];
    $duration_str = $_POST["duracao"];
    $album_name = $_POST["album"];
    $genre_name = $_POST["genero"];
    $release_date = $_POST["data_lancamento"];

    // Obter o caminho temporário do arquivo enviado
    $newFileName = basename($_FILES["caminho_mp3"]["name"]);
    // Inserir o gênero na tabela 'generos' se não existir
    $sql = "INSERT INTO generos (nome_genero) VALUES ('$genre_name')";
    $conn->query($sql);
    $genre_id = $conn->insert_id; // Obtém o ID do gênero inserido ou existente

    // Inserir o álbum na tabela 'albuns' se não existir
    $sql = "INSERT INTO albuns (nome_album) VALUES ('$album_name')";
    $conn->query($sql);
    $album_id = $conn->insert_id; // Obtém o ID do álbum inserido ou existente

    // Inserir detalhes do álbum na tabela 'detalhesalbum'
    $sql = "INSERT INTO detalhesalbum (id_Album, id_Genero) VALUES ($album_id, $genre_id)";
    $conn->query($sql);

    // Obter o id_Artista da sessão (supondo que você já tenha armazenado na sessão durante o login)
    $id_Artista = $_SESSION['user_id'];

    // Converter o formato "4:15" para segundos
    list($minutes, $seconds) = explode(':', $duration_str);
    $duration_seconds = ($minutes * 60) + $seconds;

    // Inserir a música na tabela 'musicas'
    $sql = "INSERT INTO musica (titulo, id_Artista, duracao, id_Album, id_Genero, data_lancamento, caminho_mp3)
            VALUES ('$music_name', $id_Artista, $duration_seconds, $album_id, $genre_id, '$release_date', '$newFileName')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Música inserida com sucesso!";
        header("Location: publicadas.php");
        exit();
    } else {
        echo "Erro ao inserir música: " . $conn->error;
    } 
}

$conn->close();
?>