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

// Verificar se o formulário foi enviado e se há um ID de playlist válido
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remover_playlist'])) {
    $id_playlist = $_POST['id_playlist'];

    // Consulta SQL para remover a playlist e suas associações
    $remove_details_sql = "DELETE FROM DetalhesPlaylist WHERE id_Playlist=$id_playlist";
    $remove_playlist_sql = "DELETE FROM Playlists WHERE id_Playlist=$id_playlist";
    
    $conn->query($remove_details_sql);
    $conn->query($remove_playlist_sql);

    // Redirecionar de volta à página de busca de playlists
    header("Location: buscar_playlists.php");
    exit();
} else {
    echo "ID da playlist inválido ou formulário não enviado.";
}

$conn->close();
?>

