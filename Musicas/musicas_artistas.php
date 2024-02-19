<?php
// Seu código de conexão ao banco de dados aqui
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ritmex";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão com a base de dados: " . $conn->connect_error);
}

// Função para converter segundos em formato 'mm:ss'
function formatDuration($seconds) {
    $minutes = floor($seconds / 60);
    $seconds %= 60;
    return sprintf('%02d:%02d', $minutes, $seconds);
}

// Consulta SQL para obter todas as músicas com o nome do artista
$sql = "SELECT musica.*, artistas.nome_artista 
        FROM musica 
        JOIN artistas ON musica.id_Artista = artistas.id_Artista";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../Imagens/logo2.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ritmex</title>
    <style>
        body {
            color: white; /* Definir a cor do texto como branco para o corpo da página */
        }

        /* Adicione um estilo CSS para alinhar o botão ao lado do texto */
        .music-info p {
            display: inline-block;
            margin-right: 10px;
        }

        .favorite-form {
            display: inline-block;
            color: pink;
        }
    </style>
</head>
<body>
    <center>
    <section>
        <h2>All Songs</h2><hr>

        <?php
        // Exibir as músicas com o nome do artista e a duração formatada
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $formattedDuration = formatDuration($row['duracao']);
                
                // Removendo o link no título da música
                echo "<div class='music-info' style='margin-top:30px;'>";
                echo " Titulo: " . $row["titulo"] . "<br>";
                echo " Nome: " . $row["nome_artista"] . "<br>";
                echo " Duração: " . $formattedDuration . "<br>";
                echo " Data de Lançamento: " . $row["data_lancamento"] . "<br>";
                echo "</div>";
             // Consultar informações relacionadas às chaves estrangeiras
             $id_album = $row["id_Album"];
             $id_genero = $row["id_Genero"];

             // Obter nome do álbum
             $sql_album = "SELECT nome_album FROM albuns WHERE id_Album = $id_album";
             $result_album = $conn->query($sql_album);
             $album_row = $result_album->fetch_assoc();
             echo"<center style='color:white;'>";
             echo " Álbum: " . $album_row["nome_album"] . "<br>";
             echo"</center>";
             
                // Obter nome do gênero
                $sql_genero = "SELECT nome_genero FROM generos WHERE id_Genero = $id_genero";
                $result_genero = $conn->query($sql_genero);
                $genero_row = $result_genero->fetch_assoc();
                echo"<center style='color:white; margin-bottom:30px;'>";
                echo " Gênero: " . $genero_row["nome_genero"] . "<br>";
                echo"</center>";
                echo "<audio controls>";
                echo "<source src='../Imagens/{$row['caminho_mp3']}' type='audio/mp3'>";
                echo "Seu navegador não suporta o elemento de áudio.";
                echo "</audio>";
                echo"<hr>";
            }
        }
        
        else {
            echo "<p>No songs found.</p>";
        }
        ?>
    </section>
    </center>
</body>
</html>