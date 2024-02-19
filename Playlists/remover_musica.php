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
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remover_musica'])) {
        $id_musica_remover = $_POST['remover_musica'];

        // Consulta SQL para remover a música da playlist
        $remove_music_sql = "DELETE FROM DetalhesPlaylist WHERE id_Playlist=$id_playlist AND id_Musica=$id_musica_remover";
        $conn->query($remove_music_sql);

        header("Location: playlist.php?id_playlist=" . $id_playlist);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remover Música da Playlist</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" href="../Imagens/logo2.png">
</head>
<body>
<header>
        <span>
            <img src="../Imagens/logo.png" alt="Logo" width="100px" height="100px">
        </span>
        <nav class="menu" id="nav">
            <span class="nav-item active">
    
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

<form action="" method="post">
    <!-- Dropdown para remover música da playlist -->
    <center>
        <br>
    <label for="remover_musica" style="color:white; font-size: 20px;">Remover Música:</label><br><br>
    <select name="remover_musica">
        <option value="">Nenhuma</option>
        <?php
        // Consulta SQL para obter as músicas associadas a esta playlist
        $musicas_playlist_sql = "SELECT m.id_Musica, m.titulo
                                FROM Musica m
                                INNER JOIN DetalhesPlaylist dp ON m.id_Musica = dp.id_Musica
                                WHERE dp.id_Playlist = $id_playlist";

        $musicas_playlist_result = $conn->query($musicas_playlist_sql);

        while ($musica_playlist = $musicas_playlist_result->fetch_assoc()) {
            echo "<option value='" . $musica_playlist['id_Musica'] . "'>" . $musica_playlist['titulo'] . "</option>";
        }
        ?>
    </select>
    <br><br>
    <button type="submit" name="remover">Remover</button>

    <br><br>
    <input type="submit" value="Salvar Alterações"></center>
</form>

</body>
</html>
