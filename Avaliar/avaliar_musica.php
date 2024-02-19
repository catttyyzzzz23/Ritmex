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

// Obtém a lista de músicas disponíveis para avaliação
$obter_musicas_sql = "SELECT id_musica, titulo FROM musica";
$musicas_result = $conn->query($obter_musicas_sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Certifique-se de validar e escapar os dados do formulário para evitar SQL injection
    
    $id_musica = $_POST["id_musica"];
    $avaliacao = $_POST["avaliacao"];
    
    // Obtenha o ID do usuário a partir da sessão (ajuste conforme necessário)
    $id_utilizador = $_SESSION['user_id'];

    // Inserir a avaliação na tabela avaliacoes
    $inserir_avaliacao_sql = "INSERT INTO avaliacoes (id_Musica, avaliacao, id_Utilizador) VALUES ('$id_musica', '$avaliacao', '$id_utilizador')";

    if ($conn->query($inserir_avaliacao_sql) === TRUE) {
        echo '<script>
        alert("Avaliação registada com sucesso!");
        window.location.href = "avaliacoes.php";
      </script>';
    } else {
        echo "Erro ao registrar avaliação: " . $conn->error;
}
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Musicas favoritas</title>
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
    </header><br><br>
 

<!-- No formulário adicionar_musica.php ou em qualquer página onde o usuário vá avaliar a música -->
<center>
<form method="post">
    <label style="color:white; font-size: 20px;" for="id_musica">Selecione a música para avaliar:</label><br><br>
    <select style="font-size: 16px;" name="id_musica" required>
        <?php
        // Exibe as opções do menu suspenso com as músicas disponíveis
        while ($musica = $musicas_result->fetch_assoc()) {
            echo "<option value='" . $musica["id_musica"] . "'>" . $musica["titulo"] . "</option>";
        }
        ?>
    </select>

    <br>
    <br>
    
    <label style="color:white; font-size: 20px;" for="avaliacao">Avaliar (de 1 a 5 estrelas): </label>
    <br><br>
    <select style="font-size: 16px;" name="avaliacao" required>
        <option value="1">1 estrela</option>
        <option value="2">2 estrelas</option>
        <option value="3">3 estrelas</option>
        <option value="4">4 estrelas</option>
        <option value="5">5 estrelas</option>
    </select>
    <br><br>
    
    <button type="submit">Enviar Avaliação</button>
</form>
    </center>
</body>
</html>