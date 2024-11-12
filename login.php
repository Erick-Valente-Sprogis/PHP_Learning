<?php
// Configuração do banco de dados
$servername = "localhost";
$username = "root"; // Seu usuário do MySQL
$password = ""; // Sua senha do MySQL
$dbname = "meu_banco"; // Nome do seu banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obter os dados do formulário de login
$email = $_POST['email'];
$plainPassword = $_POST['password'];

// Buscar o usuário pelo email
$sql = "SELECT * FROM logins WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Usuário não encontrado.']);
    exit();
}

// Verificar a senha
$user = $result->fetch_assoc();
if (password_verify($plainPassword, $user['password'])) {
    // Buscar o nome do usuário na tabela `users`
    $userSql = "SELECT username FROM users WHERE email = ?";
    $userStmt = $conn->prepare($userSql);
    $userStmt->bind_param("s", $email);
    $userStmt->execute();
    $userResult = $userStmt->get_result();
    $userData = $userResult->fetch_assoc();

    echo json_encode(['success' => true, 'username' => $userData['username']]); // Retornar o nome do usuário
} else {
    echo json_encode(['success' => false, 'message' => 'Senha incorreta.']);
}

$conn->close();
