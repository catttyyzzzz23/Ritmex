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
    <center>
    <h2 style="color:white;">Pesquisar</h2>
    <form method="GET">
        <label style="color:white;"for="searchTerm">Pesquisa:</label><br>
        <input type="text" id="searchTerm" name="searchTerm"><br><br>

        <input type="radio" id="tipoUtilizadores" name="searchType" value="utilizadores" onclick="this.form.action='pesquisar_utilizadores.php'">
        <label style="color:white;"for="tipoUtilizadores">Utilizadores</label><br>

        <input type="radio" id="tipoArtistas" name="searchType" value="artistas" onclick="this.form.action='pesquisar_artistas.php'">
        <label style="color:white;"for="tipoArtistas">Artistas</label><br>

        <input type="radio" id="tipoMusicas" name="searchType" value="musicas" onclick="this.form.action='pesquisar_musicas.php'">
        <label style="color:white;"for="tipoMusicas">Musicas</label><br><br>

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
    transition: background-color 0.3s, color 0.3s;"type="submit" value="Pesquisar">
    </form>
    </center>
</body>
</html>
