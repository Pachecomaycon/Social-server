<?php

require_once __DIR__ . '/../config/resposta.php';
exigirMetodo('GET');

$id = validarId();

require_once __DIR__ . '/../config/conexao.php';

try {
    $stmt = $pdo->prepare(
            'SELECT id, nome, email, criado_em 
                     FROM usuarios 
                              WHERE id = :id'
                                  );

                                      $stmt->execute([':id' => $id]);
                                          $usuario = $stmt->fetch();

                                              if (!$usuario) {
                                                      responder(404, [
                                                                  'sucesso' => false,
                                                                              'mensagem' => 'Usuário não encontrado.'
                                                                                      ]);
                                                                                          }

                                                                                              responder(200, [
                                                                                                      'sucesso' => true,
                                                                                                              'dados' => $usuario
                                                                                                                  ]);

                                                                                                                  } catch (PDOException $e) {
                                                                                                                      error_log($e->getMessage());
                                                                                                                          
                                                                                                                              responder(500, [
                                                                                                                                      'sucesso' => false,
                                                                                                                                              'mensagem' => 'Erro ao buscar dados do usuário.'
                                                                                                                                                  ]);
                                                                                                                                                  }
                                                                                                                                                  