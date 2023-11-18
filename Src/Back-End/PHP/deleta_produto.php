<?php
session_start();

if (!isset($_SESSION['id_funcionario'])) {
    header("Location: ../../Front-End/HTML/Sign_And_Login/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['produto_id'])) {
    require '../../Back-End/PHP/conectaBD.php'; // Caminho para o arquivo de conexão com o banco de dados

    $conn = mysqli_connect($servername, $username, $password, $database);

    if (!$conn) {
        die("Falha na conexão com o Banco de Dados: " . mysqli_connect_error());
    }

    $produto_id = $_GET['produto_id'];

    // Exclua os registros correspondentes na tabela lotes relacionados ao produto
    $delete_lotes = "DELETE FROM lotes WHERE fk_Produto_id_produto = $produto_id";

    if (mysqli_query($conn, $delete_lotes)) {
        // Em seguida, exclua o produto
        $delete_produto = "DELETE FROM Produtos WHERE id_produto = $produto_id";

        if (mysqli_query($conn, $delete_produto)) {
            echo "Produto excluído com sucesso!";
        } else {
            echo "Erro ao excluir produto: " . mysqli_error($conn);
        }
    } else {
        echo "Erro ao excluir registros relacionados na tabela lotes: " . mysqli_error($conn);
    }

    mysqli_close($conn);

    // Redireciona de volta para a página de catálogo de produtos após mostrar a mensagem
    header("refresh:5; url=catalogo_produtos_funcionario.php");
    exit();
} else {
    header("Location: ../../Front-End/HTML/Sign_And_Login/login.php");
    exit();
}
?>
