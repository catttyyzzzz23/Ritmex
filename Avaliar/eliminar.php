
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

// Verificar se o formulário foi enviado e se há um ID de avaliacao válido
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remover_avaliacao'])) {
    // Certifique-se de validar e escapar os dados do formulário para evitar SQL injection
    $id_avaliacao = $_POST['avaliacao'];

    // Verifique se $id_avaliacao é um número inteiro válido
    if (!is_numeric($id_avaliacao)) {
        echo "ID da avaliação inválido.";
    } else {
        // Consulta SQL para remover a avaliacao
        $remove_avaliacao = "DELETE FROM avaliacoes WHERE id_Avaliacao=$id_avaliacao";
        
        if ($conn->query($remove_avaliacao) === TRUE) {
            // Redirecionar de volta à página de avaliacoes
            header("Location: avaliacoes.php");
            exit();
        } else {
            echo "Erro ao remover a avaliação: " . $conn->error;
        }
    }
} else {
    echo "ID da avaliacao inválido ou formulário não enviado.";
}

$conn->close();
?>
