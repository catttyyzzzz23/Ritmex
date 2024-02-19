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

// Verificar se o parâmetro id_playlist está presente na URL
if (isset($_GET['id_playlist'])) {
    $id_playlist = $_GET['id_playlist'];

    // Verificar se o formulário foi enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obter os dados do formulário
        $novo_nome_playlist = $_POST['novo_nome_playlist'];
        $nova_descricao = $_POST['nova_descricao'];

        // Atualizar o nome e a descrição da playlist
        $update_playlist_sql = "UPDATE Playlists SET nome_playlist='$novo_nome_playlist', descricao='$nova_descricao' WHERE id_Playlist=$id_playlist";
        $conn->query($update_playlist_sql);

        header("Location: playlist.php?id_playlist=" . $id_playlist);
        exit();
    }

    // Restante do código de consulta e exibição do formulário HTML...
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Playlist</title>
    <link rel="icon" href="../Imagens/logo2.png">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<header>
        <span>
            <img src="../Imagens/logo.png" alt="Logo" width="100px" height="100px">
        </span>
        <nav class="menu" id="nav">
            <span class="nav-item active">
                <span class="icon">
                    <i class="fa-solid fa-house"></i>
                </span>
                <a href="../index_utilizadores.php">Home</a>
            </span>
            <span class="nav-item">
                <span class="icon">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <a href="../Fase_3/Pesquisar/pesquisar.php">Pesquisar</a>
            </span>
            <span class="nav-item">
                <span class="icon">
                    <i class="fa-solid fa-star"></i>
                </span>
                <a href="../Fase_3/Favoritas/favoritas.php">Favoritos</a>
            </span>
            <span class="nav-item">
                <span class="icon">
                    <i class="fa fa-check" aria-hidden="true"></i>
                </span>
                <a href="../Fase_3/Avaliar/avaliar_musica.php">Avaliar</a>
            </span>
            <span class="nav-item">
                <span class="icon">
                    <i class="fas fa-list-music"></i>
                </span>
                <a href="../Playlists/playlist.php">Playlists</a>
            </span>
            <span class="nav-item">
                <span class="icon">
                    <i class="fa-solid fa-user"></i>
                </span>

                <?php
                    // Verifique se o usuário está autenticado
                    if (isset($_SESSION['username'])) {
                        // Usuário autenticado - exiba o dropdown do perfil
                        echo '<div class="dropdown">';
                        echo '<a href="Perfis/perfil_utilizador.php">Perfil</a>';
                        echo '<div class="dropdown-child">';
                        echo '<a href="../Perfis/perfil_utilizador.php">Editar Perfil</a>';  // Adicione um link de logout ou outras opções
                        echo '<a href="../Logout/logout.php">Logout</a>';  // Adicione um link de logout ou outras opções
                        echo '</div>';
                        echo '</div>';
                    } else {
                        // Usuário não autenticado - exiba links de login/registrar
                        echo '<div class="dropdown">';
                        echo' <a href="#">Your Profile</a>';
                        echo '<div class="dropdown-child">';
                            echo '<a href="../Login/login.html" id="loginLink">Login</a>';
                            echo'<a href="../Registar/registar.html" id="signupLink">Sign Up</a>';
                        echo'</div>';
                        echo'</div>';
                    }
                ?>
            </span>
        </nav>
    </header>
    <center>
    <h1 style="color:white;"> Edição de playlist</h1>
    <form action="" method="post">
        <label style='text-decoration:none; color:white; font-size:20px;' for="novo_nome_playlist">Novo Nome da Playlist:</label>
        <input type="text" name="novo_nome_playlist" required><br>

        <label style='text-decoration:none; color:white; font-size:20px;'for="nova_descricao">Nova Descrição:</label>
        <input type="text" name="nova_descricao"><br>

        <input style="display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    margin-top:30px;
    border: 2px solid grey;
    border-radius: 5px;
    color: black;
    background-color: white;
    transition: background-color 0.3s, color 0.3s;"type="submit" value="Salvar Alterações">
    </form>
</body>
</html>

<?php
$conn->close();
?>
