<?php

require_once __DIR__ . '/../config/resposta.php';
exigirMetodo('POST');

require_once __DIR__ . '/../config/conexao.php';

$dados = receberJson();

$nome = trim($dados['nome'] ?? '');
$email = trim($dados['email'] ?? '');

if (
    $nome === '' ||
        strlen($nome) > 120 ||
            strlen($email) > 190 ||
                !filter_var($email, FILTER_VALIDATE_EMAIL)
                ) {
                    responder(422, [
                            'sucesso' => false,
                                    'mensagem' => 'Nome ou e-mail inválido.'
                                        ]);
                                        }

                                        try {
                                            $stmt = $pdo->prepare(
                                                    'INSERT INTO usuarios (nome, email) 
                                                             VALUES (:nome, :email) 
                                                                      RETURNING id'
                                                                          );

                                                                              $stmt->execute([
                                                                                      ':nome' => $nome,
                                                                                              ':email' => $email
                                                                                                  ]);

                                                                                                      $id = $stmt->fetchColumn();

                                                                                                          responder(201, [
                                                                                                                  'sucesso' => true,
                                                                                                                          'mensagem' => 'Usuário criado com sucesso.',
                                                                                                                                  'id' => (int) $id
                                                                                                                                      ]);

                                                                                                                                      } catch (PDOException $e) {
                                                                                                                                          // Código de erro 23505 é a restrição de chave única (Unique Constraint Violation) no PostgreSQL
                                                                                                                                              if ($e->getCode() === '23505') {
                                                                                                                                                      responder(409, [
                                                                                                                                                                  'sucesso' => false,
                                                                                                                                                                              'mensagem' => 'Este e-mail já está cadastrado.'
                                                                                                                                                                                      ]);
                                                                                                                                                                                          }

                                                                                                                                                                                              error_log($e->getMessage());

                                                                                                                                                                                                  responder(500, [
                                                                                                                                                                                                          'sucesso' => false,
                                                                                                                                                                                                                  'mensagem' => 'Erro ao cadastrar usuário.'
                                                                                                                                                                                                                      ]);
                                                                                                                                                                                                                      }
                                                                                                                                                                                                                      