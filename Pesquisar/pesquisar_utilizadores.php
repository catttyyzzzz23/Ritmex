<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ritmex";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Verificar se o usuário está autenticado
if (isset($_SESSION['username'])) {
    // Obtendo o ID do usuário da sessão
    $username = $_SESSION['username'];

    // Verificar se o ID do usuário está na tabela 'utilizadores'
    $sql_check_utilizador = "SELECT email FROM utilizadores WHERE email = '$username'";
    $result_check_utilizador = $conn->query($sql_check_utilizador);

    // Verificar se o ID do usuário está na tabela 'artistas'
    $sql_check_artista = "SELECT email FROM artistas WHERE email = '$username'";
    $result_check_artista = $conn->query($sql_check_artista);

    if ($result_check_utilizador->num_rows > 0) {
        // Usuário encontrado na tabela 'utilizadores'
        $home_link = "../Login/index_utilizadores.php";
    } elseif ($result_check_artista->num_rows > 0) {
        // Usuário encontrado na tabela 'artistas'
        $home_link = "../Login/index_artistas.php";
    } else {
        // Se o ID do usuário não for encontrado em ambas as tabelas, você pode lidar com isso da maneira que preferir
        // Por exemplo, redirecionar para algum lugar genérico ou exibir uma mensagem de erro.
        $home_link = "../Musicas/musicas.php";
    }
} else {
    // Usuário não autenticado - redirecionar para a página de login
    $home_link = "../Login/login.html";
}
?>
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
                <a href="<?php echo $home_link; ?>">Home</a>
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
    </header><br><br>
</body>
</html>
<?php
// Receber o termo de pesquisa da página HTML
if (isset($_GET['searchTerm'])) {
    $searchTerm = $_GET['searchTerm'];

    // Consulta SQL para buscar os utilizadores que correspondem ao termo de pesquisa
    $sql = "SELECT * FROM utilizadores WHERE nome_utilizador LIKE '%$searchTerm%'";
    

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Exibir resultados encontrados
        while ($row = $result->fetch_assoc()) {
            echo"<center>";
            echo "<p style='color:white; font-size:20px;'>Nome: " . $row["nome_utilizador"] ."<br></p>";
            echo"</center>";
        }
    } else {
        echo "Nenhum resultado encontrado.";
        
    }
    // Consulta SQL para buscar as playlists do utilizador pesquisado
    $sql_playlist = "SELECT playlists.nome_playlist, playlists.descricao FROM playlists
    JOIN utilizadores ON playlists.id_utilizador = utilizadores.id_Utilizador
    WHERE utilizadores.nome_utilizador = '$searchTerm'";
    $playlist_result = $conn->query($sql_playlist);

    if ($playlist_result->num_rows > 0) {
        echo "<h2 style='color:white; font-size:30px; text-align: center;'>Playlists do Utilizador:</h2>";
        while ($playlist_row = $playlist_result->fetch_assoc()) {
            echo "<center>";
            // Exibir informações da playlist
            echo "<p style='color:white; font-size:20px;'>Nome da Playlist: " . $playlist_row["nome_playlist"] . "<br></p>";
            echo "<p style='color:white; font-size:20px;'>Descrição: " . ($playlist_row["descricao"] ? $playlist_row["descricao"] : "Nenhuma descrição disponível") . "<br></p>";
            echo "</center>";
        }
    }
    } else {
    echo "Nenhum termo de pesquisa recebido.";
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
