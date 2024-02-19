<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $terms = isset($_POST["terms"]) ? 1 : 0;

    // Validações básicas (você pode adicionar mais validações conforme necessário)
    if ($password != $confirm_password) {
        die("As senhas não coincidem.");
    }

    // Verificar qual radio button foi selecionado
    if (isset($_POST['user_type']) && $_POST['user_type'] == 'normal_user') {
        // Consulta SQL para inserir o usuário na tabela 'utilizadores'
        $sql = "INSERT INTO utilizadores (nome_utilizador, email, senha, termos) VALUES ('$name', '$email', '$password', $terms)";
    } elseif (isset($_POST['user_type']) && $_POST['user_type'] == 'artist') {
        // Consulta SQL para inserir o usuário na tabela 'artistas'
        $sql = "INSERT INTO artistas (nome_artista, email, senha, termos) VALUES ('$name', '$email', '$password', $terms)";
    } else {
        // Se nenhum radio button estiver selecionado, faça algo, se necessário
        die("Tipo de usuário não selecionado.");
    }

    if ($conn->query($sql) === TRUE) {
        echo "Registro bem-sucedido!";
        header("Location: ../Login/login.html");
        exit();
    } else {
        echo "Erro no registro: " . $conn->error;
    }
}

$conn->close();
?>

