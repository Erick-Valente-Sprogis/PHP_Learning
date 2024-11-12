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

// Obter os dados do formulário
$userName = $_POST['username'];
$email = $_POST['email'];
$plainPassword = $_POST['password'];

// Validar se o e-mail já existe
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Email já registrado.']);
    exit();
}

// Criar senha hash para segurança
$passwordHash = password_hash($plainPassword, PASSWORD_BCRYPT);

// Inserir o usuário na tabela `users`
$sql = "INSERT INTO users (username, email, full_name) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $userName, $email, $userName); // Use o username como nome completo aqui ou outro campo conforme necessidade

if ($stmt->execute()) {
    // Inserir dados de login na tabela `logins`
    $loginSql = "INSERT INTO logins (email, password) VALUES (?, ?)";
    $loginStmt = $conn->prepare($loginSql);
    $loginStmt->bind_param("ss", $email, $passwordHash);
    $loginStmt->execute();

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao cadastrar o usuário.']);
}

$conn->close();
