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
                    // Inicie a sessão para acessar variáveis de sessão
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
    </header><br><br>
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

// Obtém o ID do usuário da sessão
$id_usuario = $_SESSION['user_id'];

// Obtém as avaliações feitas pelo usuário logado com informações sobre a música e o artista
$obter_avaliacoes_sql = "SELECT m.titulo AS titulo_musica, a.avaliacao, ar.nome_artista, a.id_Avaliacao
                        FROM avaliacoes a
                        JOIN Musica m ON a.id_Musica = m.id_Musica
                        JOIN artistas ar ON m.id_Artista = ar.id_Artista
                        WHERE a.id_Utilizador = '$id_usuario'";

$avaliacoes_result = $conn->query($obter_avaliacoes_sql);

if ($avaliacoes_result === FALSE) {
    echo "Erro ao recuperar as avaliações: " . $conn->error;
}

// Exibe as avaliações
while ($avaliacao = $avaliacoes_result->fetch_assoc()) {
   echo"<center style='color:white; font-size:18px;'> ";
   echo "Título da Música: " . $avaliacao["titulo_musica"] ."<br>". " Nome do Artista: " . $avaliacao["nome_artista"] . "<br>"." Avaliação: " . $avaliacao["avaliacao"] . "<br>";
   echo"</center> ";
            ?>
            <center>
            <form action="eliminar.php" method="post">
                <!-- Adicione um campo oculto para enviar o ID da avaliação -->
                <input type="hidden" name="avaliacao" value="<?php echo $avaliacao['id_Avaliacao']; ?>">
                <!-- Adicione um botão para confirmar a remoção da playlist -->
                <button type="submit" name="remover_avaliacao">Remover avaliação</button>
            </form>
            </center>
            <?php

}

$conn->close();
?>
