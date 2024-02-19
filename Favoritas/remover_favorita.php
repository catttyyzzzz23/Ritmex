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

// Obter dados do formulário
$id_Utilizador = $_POST['id_Utilizador'];
$id_Musica = $_POST['id_Musica'];

// Remover a música dos favoritos
$sql = "DELETE FROM favoritos WHERE id_Utilizador = $id_Utilizador AND id_Musica = $id_Musica";
$conn->query($sql);

$conn->close();

// Redirecionar de volta à página anterior ou para onde desejar
header("Location: favoritas.php");
exit();
?>
