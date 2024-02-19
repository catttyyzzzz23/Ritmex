<?php
// Iniciar a sessão
session_start();

// Arquivo de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ritmex";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter dados do formulário
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Consulta SQL para verificar a existência do usuário normal
    $sql_user = "SELECT * FROM utilizadores WHERE email = '$username' AND senha = '$password'";
    $result_user = $conn->query($sql_user);

    // Consulta SQL para verificar a existência do artista
    $sql_artist = "SELECT * FROM artistas WHERE email = '$username' AND senha = '$password'";
    $result_artist = $conn->query($sql_artist);

    // Verificar se é um usuário normal
    if ($result_user->num_rows > 0) {
        $row_user = $result_user->fetch_assoc();
        $_SESSION['username'] = $row_user['email'];
        $_SESSION['user_id'] = $row_user['id_Utilizador'];
        echo "Login bem-sucedido como utilizador normal!";
        header("Location: index_utilizadores.php");
        exit();
    } 
    // Verificar se é um artista
    elseif ($result_artist->num_rows > 0) {
        $row_artist = $result_artist->fetch_assoc();
        $_SESSION['username'] = $row_artist['email'];
        $_SESSION['user_id'] = $row_artist['id_Artista'];
        echo "Login bem-sucedido como artista!";
        // Redirecionar para a página do artista
        header("Location: index_artistas.php");
        exit();
    } else {
        // Se chegou até aqui, as credenciais são inválidas
        echo '<script>';
        echo 'alert("Credenciais inválidas. Tente novamente.");';
        echo '</script>';
        header("Location: login.html");
        exit();
    }
}

$conn->close();
?>

