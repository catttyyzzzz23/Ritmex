<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Playlist</title>
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
                    <i class="fas fa-list-music"></i>
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
    </header>
    <center>
    <h2 style="color:white;" >Criar Playlist</h2>
    
    <form action="processar.php" method="post">
        <label style="color:white;margin-bottom:20px" for="nome_playlist">Nome da Playlist:</label>
        <input style="color:black;margin-bottom:20px"type="text" name="nome_playlist" required><br>

        <label style="color:white;margin-bottom:20px" for="descricao">Descrição:</label>
        <input style="color:black; margin-bottom:20px"type="text" name="descricao"><br>

        <!-- Radio buttons para selecionar músicas -->
<label style="color:white;">Selecione as músicas para a playlist:<br></label>
<?php
    // Arquivo de conexão com o banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ritmex";

   // Criar conexão
   $conn = new mysqli($servername, $username, $password, $dbname);

   // Verificar a conexão
   if ($conn->connect_error) {
       die("Conexão falhou: " . $conn->connect_error);
   }

   // Consultar todas as músicas da tabela Musicas
   $sql_musicas = "SELECT id_Musica, titulo FROM Musica";
   $result_musicas = $conn->query($sql_musicas);


   // Verificar se há algum erro na consulta SQL
   if (!$result_musicas) {
       die("Erro na consulta SQL: " . $conn->error);
   }

   // Exibir radio buttons para cada música
   if ($result_musicas->num_rows > 0) {
       while ($row = $result_musicas->fetch_assoc()) {
           echo "<input type='checkbox' name='musicas[]' value='" . $row["id_Musica"] . "'>";
           echo "<label>" . $row["titulo"] . "</label><br>";
       }
   }

   // Fechar conexão
   $conn->close();
?>

        <input style="display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    border: 2px solid grey;
    border-radius: 5px;
    color: black;
    background-color: white;
    transition: background-color 0.3s, color 0.3s;" type="submit" value="Criar Playlist">
    </form>
    </center>
</body>
</html>

