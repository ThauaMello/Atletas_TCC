<?php
include_once("../conexao.php");

$nome = $_POST['nome'] ?? '';
$usuario = $_POST['usuario'] ?? '';
$senha = password_hash($_POST['senha'] ?? '', PASSWORD_DEFAULT);
$cpf = $_POST['cpf'] ?? null;
$tipo = $_POST['tipo'] ?? '';
$modalidade = $_POST['modalidade'] ?? null;     
$especialidade = $_POST['especialidade'] ?? null; 
$foto = null; 

if ($nome && $usuario && $senha && $tipo) {

    // Verificar se o usuário já existe
    $verifica = $conn->prepare("SELECT id_pessoa FROM pessoas WHERE usuario = ?");
    $verifica->bind_param("s", $usuario);
    $verifica->execute();
    $verifica->store_result();

    if ($verifica->num_rows > 0) {
        echo "❌ Este nome de usuário já está em uso. <a href='usuario.php?tipo=$tipo'>Voltar</a>";
        exit;
    }

    $verifica->close();

    // Inserir na tabela pessoas
    $sql = "INSERT INTO pessoas (nome, usuario, senha, tipo, cpf) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nome, $usuario, $senha, $tipo, $cpf);

    if ($stmt->execute()) {
        $id_pessoa = $stmt->insert_id;

        // Inserir na tabela específica
        if ($tipo === 'atleta') {
            $sqlAtleta = "INSERT INTO atleta (id_pessoa, modalidade, foto) VALUES (?, ?, ?)";
            $stmtAtleta = $conn->prepare($sqlAtleta);
            $stmtAtleta->bind_param("iss", $id_pessoa, $modalidade, $foto);
            $stmtAtleta->execute();
            $stmtAtleta->close();
        } elseif ($tipo === 'tecnico') {
            $sqlTec = "INSERT INTO tecnico (id_pessoa, especialidade, foto) VALUES (?, ?, ?)";
            $stmtTec = $conn->prepare($sqlTec);
            $stmtTec->bind_param("iss", $id_pessoa, $especialidade, $foto);
            $stmtTec->execute();
            $stmtTec->close();
        }

        // Mensagem de sucesso com redirecionamento
        echo "
        <html>
            <head>
                <meta charset='UTF-8'>
                <title>Cadastro</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f0f0f0;
                        text-align: center;
                        padding-top: 100px;
                    }
                    .msg {
                        background-color: #d4edda;
                        color: #155724;
                        border: 1px solid #c3e6cb;
                        display: inline-block;
                        padding: 20px;
                        border-radius: 10px;
                        font-size: 18px;
                    }
                </style>
                <script>
                    setTimeout(function(){
                        window.location.href = 'usuario.php?tipo=$tipo';
                    }, 3000);
                </script>
            </head>
            <body>
                <div class='msg'>Cadastro realizado com sucesso!<br>Redirecionando...</div>
            </body>
        </html>";
    } else {
        echo "❌ Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "⚠️ Preencha todos os campos.";
}
$conn->close();
