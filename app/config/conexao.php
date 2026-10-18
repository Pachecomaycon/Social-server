
<?php

$host = getenv('DB_HOST') ?: 'localhost';
$porta = getenv('DB_PORT') ?: '5432';
$banco = getenv('DB_NAME') ?: 'Social';
$usuario = getenv('DB_USER') ?: 'postgres';
$senha = getenv('DB_PASS') ?: '';

try {
    $pdo = new PDO(
            "pgsql:host=$host;port=$porta;dbname=$banco",
                    $usuario,
                            $senha,
                                    [
                                                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                                                                        PDO::ATTR_EMULATE_PREPARES => false
                                                                                ]
                                                                                    );
                                                                                    } catch (PDOException $e) {
                                                                                        error_log($e->getMessage());

                                                                                            http_response_code(500);
                                                                                                header('Content-Type: application/json; charset=utf-8');

                                                                                                    echo json_encode([
                                                                                                            'sucesso' => false,
                                                                                                                    'mensagem' => 'Erro de conexão com o banco de dados.'
                                                                                                                        ], JSON_UNESCAPED_UNICODE);

                                                                                                                            exit;
                                                                                                                            }