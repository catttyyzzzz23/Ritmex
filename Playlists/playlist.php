<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ritmex</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" href="../Imagens/logo2.png">
    <script src="https://kit.fontawesome.com/c9a361dd57.js" crossorigin="anonymous"></script>
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
                <a href="../Login/index_utilizadores.php">Home</a>
            </span>
            <span class="nav-item">
                <span class="icon">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <a href="../Pesquisar/pesquisar.php">Pesquisar</a>
            </span>
            <span class="nav-item">
                <span class="icon">
                    <i class="fa-solid fa-star"></i>
                </span>
                <a href="../Favoritas/favoritas.php">Favoritos</a>
            </span>
            <span class="nav-item">
                <span class="icon">
                    <i class="fa fa-check" aria-hidden="true"></i>
                </span>
                <a href="../Avaliar/avaliar_musica.php">Avaliar</a>
            </span>
            <span class="nav-item">
                <span class="icon">
                <i class="fa-solid fa-music"></i>
                </span>
                <a href="../Playlists/buscar_playlists.php">Playlists</a>
            </span>
            <span class="nav-item">
                <span class="icon">
                    <i class="fa-solid fa-user"></i>
                </span>

                <?php
                session_start();
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
</body>
</html>

<?php

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

    // Consulta SQL para obter as informações da playlist com base no id_playlist
    $playlist_sql = "SELECT nome_playlist, descricao
                     FROM playlists
                     WHERE id_Playlist = $id_playlist";

    $playlist_result = $conn->query($playlist_sql);

    if ($playlist_result->num_rows > 0) {
        $playlist_row = $playlist_result->fetch_assoc();
        echo"<center>";
        // Exibir informações da playlist
        echo "<p style='color:white; font-size:20px;'>Nome da Playlist: " . $playlist_row["nome_playlist"] . "<br></p>";
        echo "<p style='color:white; font-size:20px;'>Descrição: " . ($playlist_row["descricao"] ? $playlist_row["descricao"] : "Nenhuma descrição disponível") . "<br></p>";

        // Consulta SQL para obter as músicas associadas a esta playlist
        $musicas_sql = "SELECT m.titulo
                        FROM Musica m
                        INNER JOIN DetalhesPlaylist dp ON m.id_Musica = dp.id_Musica
                        WHERE dp.id_Playlist = $id_playlist";

        $musicas_result = $conn->query($musicas_sql);

        if ($musicas_result->num_rows > 0) {
            // Exibir as músicas associadas
            echo "<p style='color:white; font-size:20px;'>Músicas: <br></p>";
            while ($musica_row = $musicas_result->fetch_assoc()) {
                echo '<p style="color:white; font-size:20px;">' . $musica_row["titulo"] . '</p>';

            }
            echo "<br>";
        } else {
            echo "Nenhuma música associada a esta playlist.<br>";
        }

        echo "<br>";
        echo"</center>";
        // Adicionar botão de edição
        ?>
        <center>
        <!-- Botão 1 -->
        <form action="editar_playlist_perfil.php" method="get">
        <input type="hidden" name="id_playlist" value="<?php echo $id_playlist; ?>">
        <button type="submit">Editar perfil da Playlist</button>
        </form>

        <!-- Botão 2 -->
        <form action="adicionar_musica.php" method="get">
        <input type="hidden" name="id_playlist" value="<?php echo $id_playlist; ?>">
        <button type="submit">Adicionar músicas</button>
        </form>

        <!-- Botão 3 -->
        <form action="remover_musica.php" method="get">
        <input type="hidden" name="id_playlist" value="<?php echo $id_playlist; ?>">
        <button type="submit">Eliminar músicas</button>
        </form>
        </center>
        <?php

    } else {
        echo "Playlist não encontrada.";
    }
} else {
    echo "ID da playlist não fornecido na URL.";
}

$conn->close();
?>
