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
        <nav class="menu" id="nav">
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
                        echo '<a href="#">Perfil</a>';
                        echo '<div class="dropdown-child">';
                        echo '<a href="../Perfis/perfil_utilizador.php">Editar Perfil</a>';  // Adicione um link de logout ou outras opções
                        echo '<a href="../Logout/logout.php">Logout</a>';  // Adicione um link de logout ou outras opções
                        echo '</div>';
                        echo '</div>';
                    } else {
                        // Usuário não autenticado - exiba links de login/registrar
                        echo '<div class="dropdown">';
                        echo' <a href="#">Perfil</a>';
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
    <h1 style="color:white;">Playlists Criadas</h1>
                
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

// Obter o id_Utilizador da sessão (supondo que você já tenha armazenado na sessão durante o login)
$id_Utilizador = $_SESSION['user_id'];

// Consulta SQL para obter as playlists e suas músicas associadas
$sql = "SELECT p.id_Playlist, p.nome_playlist, p.descricao, m.titulo
        FROM Playlists p
        LEFT JOIN DetalhesPlaylist dp ON p.id_Playlist = dp.id_Playlist
        LEFT JOIN Musica m ON dp.id_Musica = m.id_Musica
        WHERE p.id_Utilizador = $id_Utilizador";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // Array para armazenar IDs das playlists já exibidas
    $playlistsExibidas = array();

    // Exibir todas as playlists e suas músicas
    
    while ($row = $result->fetch_assoc()) {
        // Verificar se a playlist já foi exibida
        if (!in_array($row["id_Playlist"], $playlistsExibidas)) {
            // Adicionar o ID da playlist ao array de playlists exibidas
            $playlistsExibidas[] = $row["id_Playlist"];

            // Exibir o nome da playlist como um link
            echo "<a style='text-decoration:none; color:white; font-size:25px;' href='../Playlists/playlist.php?id_playlist=" . $row["id_Playlist"] . "'>" . $row["nome_playlist"] . "</a><br>";
            
            ?>
            <form action="../Playlists/eliminar.php" method="post">
                <!-- Adicione um campo oculto para enviar o ID da playlist -->
                <input type="hidden" name="id_playlist" value="<?php echo $row['id_Playlist']; ?>">
                <!-- Adicione um botão para confirmar a remoção da playlist -->
                <button style="margin-top: 40px;" class="botao"type="submit" name="remover_playlist">Remover Playlist</button>
            </form>
            <?php
        }

        echo "<br>";
    }
} else {
    echo "Nenhuma playlist encontrada.";
}

$conn->close();
?>
 <form action="../Playlists/criar.php" method="get">
        <button type="submit">+</button>
</center>
</body>
</html>