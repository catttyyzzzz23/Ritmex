<?php
session_start();

// Arquivo de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ritmex";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Obtém o nome do utilizador da sessão
$username = $_SESSION['username'];

// Consulta SQL para obter informações do utilizador
$sql = "SELECT nome_utilizador, email FROM utilizadores WHERE nome_utilizador = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);

$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

// Exibe as informações do utilizador
echo "Nome do Utilizador: " . $userData['nome_utilizador'] . "<br>";
echo "Email: " . $userData['email'] . "<br>";

$conn->close();
?>
