<?php
session_start(); // Inicie a sessão

// Arquivo de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ritmex";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar dados do formulário
    $nome_playlist = $_POST["nome_playlist"];
    $descricao = $_POST["descricao"];

    // Verificar se o usuário está autenticado
    if (isset($_SESSION['user_id'])) {
        // Obtenha o ID do utilizador logado
        $id_utilizador = $_SESSION['user_id'];

        // Inserir dados na tabela Playlists
        $sql_playlist = "INSERT INTO Playlists (nome_playlist, descricao, id_Utilizador) VALUES ('$nome_playlist', '$descricao', '$id_utilizador')";
        $conn->query($sql_playlist);

        // Obter o ID da playlist recém-inserida
        $id_playlist = $conn->insert_id;

        // Inserir dados na tabela DetalhePlaylist para cada música selecionada
        if (!empty($_POST["musicas"])) {
            foreach ($_POST["musicas"] as $id_musica) {
                $sql_detalhe = "INSERT INTO DetalhesPlaylist (id_Playlist, id_Musica) VALUES ('$id_playlist', '$id_musica')";
                $conn->query($sql_detalhe);
            }
        }

        echo "Playlist criada com sucesso!";
        echo '<script>
        setTimeout(function() {
            window.location.href = "buscar_playlists.php";
        }, 3000);
      </script>';
    } else {
        echo "Utilizador não autenticado.";
    }
} else {
    echo "O formulário não foi enviado.";
}

// Fechar conexão
$conn->close();
?>
