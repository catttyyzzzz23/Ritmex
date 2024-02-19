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
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['adicionar_musica'])) {
        $id_musica = $_POST['adicionar_musica'];

        // Consulta SQL para adicionar a música à playlist
        $add_music_sql = "INSERT INTO DetalhesPlaylist (id_Playlist, id_Musica) VALUES ($id_playlist, $id_musica)";
        $conn->query($add_music_sql);

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
    <title>Adicionar Música à Playlist</title>
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
                <span class="icon">
                    <i class="fa-solid fa-house"></i>
                </span>
                <a href="../Login/index_utilizadores.php">Home</a>
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
<form action="" method="post">
    <!-- Dropdown para adicionar música à playlist -->
    <center>
        <br><br>
    <label style='text-decoration:none; color:white; font-size:20px;' for="adicionar_musica">Adicionar Música:</label><br><br>
    <select name="adicionar_musica">
        <option value="">Nenhuma</option>
        <?php
        // Consulta SQL para obter todas as músicas disponíveis
        $musicas_disponiveis_sql = "SELECT id_Musica, titulo FROM Musica";
        $musicas_disponiveis_result = $conn->query($musicas_disponiveis_sql);

        while ($musica_disponivel = $musicas_disponiveis_result->fetch_assoc()) {
            echo "<option value='" . $musica_disponivel['id_Musica'] . "'>" . $musica_disponivel['titulo'] . "</option>";
        }
        ?>
    </select><br><br>
    <button type="submit" name="adicionar">Adicionar</button>

    <br>
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
    </center>

</body>
</html>