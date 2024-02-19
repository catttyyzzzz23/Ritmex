<?php
session_start();

// Arquivo de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ritmex";

$conn = new mysqli($servername, $username, $password, $dbname);

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM utilizadores WHERE id_Utilizador = $user_id";
$result = $conn->query($sql);
// Consulta para obter as playlists do usuário
$sql_playlists = "SELECT id_Playlist, nome_playlist FROM Playlists WHERE id_Utilizador = $user_id";
$result_playlists = $conn->query($sql_playlists);

// Verificar se a consulta foi bem-sucedida e obter os dados do utilizador
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nome_utilizador = $row['nome_utilizador'];
    $email = $row['email'];
} else {
    // Se não encontrar o utilizador, faça algo aqui, como redirecionar para a página de login
    header("Location: ../Login/login.html");
    exit();
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Utilizador</title>
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
     <!-- Exibe as informações do utilizador -->
        <div class="perfil-info">
            <h1 style="color:white;" >Informações do Pefil</h1>
            <p style="color:white;" >Nome do Utilizador: <?php echo $nome_utilizador; ?></p>
            <p style="color:white;" >Email: <?php echo $email; ?></p>
        </div>
        <!-- Exibe as playlists do usuário -->
        <h1 style="color:white;">Suas Playlists</h1>
        <?php
        if ($result_playlists->num_rows > 0) {
            while ($row_playlist = $result_playlists->fetch_assoc()) {
                echo "<p style='color:white;'>Playlist: " . $row_playlist['nome_playlist'] . "</p>";
                // Você pode adicionar links para as páginas de detalhes da playlist, etc., conforme necessário
            }
        } else {
            echo "<p style='color:white;'>Você ainda não criou playlists.</p>";
        }
        ?>
    </center>
</body>
</html>
