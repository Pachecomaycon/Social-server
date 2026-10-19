<?php

// Lendo as variáveis de ambiente (ideal para quando estiver em produção)
// Caso não existam no sistema, o código usará automaticamente as credenciais do seu Railway informadas abaixo:
$host = getenv('DB_HOST') ?: 'shinkansen.proxy.rlwy.net';
$porta = getenv('DB_PORT') ?: '24139';
$banco = getenv('DB_NAME') ?: 'Social'; // Certifique-se de que a renomeação para Social deu certo
$usuario = getenv('DB_USER') ?: 'postgres';
$senha = getenv('DB_PASS') ?: 'xasMrKHzNkNPyFljLHgEELZCHaFBCkXZ';

try {
    // Montando a string de conexão (DSN) incluindo obrigatoriamente o sslmode=require
        $dsn = "pgsql:host=$host;port=$porta;dbname=$banco;sslmode=require";

            $pdo = new PDO(
                    $dsn,
                            $usuario,
                                    $senha,
                                            [
                                                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Transforma erros em exceções tratáveis
                                                                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Retorna os dados como arrays associativos
                                                                                PDO::ATTR_EMULATE_PREPARES => false // Usa prepared statements nativos do PostgreSQL por segurança
                                                                                        ]
                                                                                            );

                                                                                                // Opcional: Se quiser testar a conexão na tela tirando o comentário da linha abaixo:
                                                                                                    // echo "Conectado com sucesso ao banco Social!";

                                                                                                    } catch (PDOException $e) {
                                                                                                        // Registra o erro real detalhado internamente no log do servidor (com segurança para não expor a senha na web)
                                                                                                            error_log("Erro de Conexão Postgres: " . $e->getMessage());

                                                                                                                // Retorna um cabeçalho HTTP de erro interno do servidor
                                                                                                                    http_response_code(500);
                                                                                                                        header('Content-Type: application/json; charset=utf-8');

                                                                                                                            // Resposta amigável em formato JSON para a sua aplicação ou frontend
                                                                                                                                echo json_encode([
                                                                                                                                        'sucesso' => false,
                                                                                                                                                'mensagem' => 'Erro de conexão com o banco de dados.'
                                                                                                                                                    ], JSON_UNESCAPED_UNICODE);

                                                                                                                                                        exit;
                                                                                                                                                        }
                                                                                                                                                        