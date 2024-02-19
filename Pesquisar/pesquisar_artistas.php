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
<html>
<head>
    <title>Pesquisa de Utilizadores</title>
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
    </header>
</body>
</html>
<?php
function formatDuration($seconds) {
    $minutes = floor($seconds / 60);
    $seconds %= 60;
    return sprintf('%02d:%02d', $minutes, $seconds);
}
if(isset($_GET['searchTerm'])) {
    $searchTerm = $_GET['searchTerm'];
    

    // Consulta SQL para buscar os artistas que correspondem ao termo de pesquisa
    $sql_artistas = "SELECT * FROM artistas WHERE nome_artista LIKE '%$searchTerm%'";

    // Executar a consulta de artistas
    $result_artistas = $conn->query($sql_artistas);

    if ($result_artistas === false) {
        echo "Erro na consulta de artistas: " . $conn->error;
    } else {
        // Exibir resultados encontrados
        if ($result_artistas->num_rows > 0) {
            echo "<h2 style='color:white; font-size:30px; text-align: center;'>Resultados da pesquisa de artistas:</h2>";
            while ($row_artista = $result_artistas->fetch_assoc()) {
                echo"<center style='color:white; font-size:20px;'>";
                echo " Nome: " . $row_artista["nome_artista"] . "<br>";

                // Consulta SQL para buscar as músicas associadas a este artista
                $id_artista = $row_artista["id_Artista"];
                $sql_musicas = "SELECT * FROM musica WHERE id_Artista = '$id_artista'";
                $result_musicas = $conn->query($sql_musicas);

                // Exibir as músicas associadas ao artista
                if ($result_musicas === false) {
                    echo "Erro na consulta de músicas: " . $conn->error;
                } else {
                    while ($row_musica = $result_musicas->fetch_assoc()) {
                        $formattedDuration = formatDuration($row_musica['duracao']);
                        echo"<center style='color:white;'>";
                        echo"<br>";
                        echo " Música: " . $row_musica["titulo"] . "<br>";
                        echo " Duração: " . $formattedDuration . "<br>";
                        echo " Data de Lançamento: " . $row_musica["data_lancamento"] . "<br>";
                        echo"</center>";
                    }
                }
            }
        } else {
            echo "Nenhum resultado encontrado para artistas.";
        }
    }
} else {
    echo "Nenhum termo de pesquisa recebido.";
}
// Fechar a conexão com o banco de dados
$conn->close();

?>

