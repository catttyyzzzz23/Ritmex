<?php
session_start();

// Seu código de conexão ao banco de dados aqui
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ritmex";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão com a base de dados: " . $conn->connect_error);
}

// Verificar se o usuário está logado
if (isset($_SESSION['user_id'])) {
    $id_Utilizador = $_SESSION['user_id'];
    
    // Obter o id_Musica do formulário
    if (isset($_POST['id_musica'])) {
        $id_Musica = $_POST['id_musica'];

        // Verificar se a música já está nos favoritos do usuário
        $checkSql = "SELECT * FROM favoritos WHERE id_Utilizador = $id_Utilizador AND id_Musica = $id_Musica";
        $result = $conn->query($checkSql);

        if ($result->num_rows > 0) {
            echo "Erro: Música já está nos favoritos.";
        } else {
            // Inserir a música favorita na tabela 'favoritos'
            $insertSql = "INSERT INTO favoritos (id_Utilizador, id_Musica) VALUES ($id_Utilizador, $id_Musica)";
            $conn->query($insertSql);

            echo "Música favoritada com sucesso!";
            echo '<script>
        setTimeout(function() {
            window.location.href = "favoritas.php";
        }, 3000);
      </script>';
        }
    } else {
        echo "Erro: ID da música não recebido.";
    }
} else {
    echo "Erro: Usuário não autenticado.";
}

$conn->close();
?>

