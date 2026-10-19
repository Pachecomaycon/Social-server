<?php
// Define cabeçalhos globais da API
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Trata automaticamente o preflight do CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
        exit;
        }

        /**
         * Garante que apenas o método HTTP correto acesse o endpoint.
          */
          function exigirMetodo(string $metodo): void {
              if ($_SERVER['REQUEST_METHOD'] !== strtoupper($metodo)) {
                      responder(405, [
                                  'sucesso' => false,
                                              'mensagem' => 'Método não permitido.'
                                                      ]);
                                                          }
                                                          }

                                                          /**
                                                           * Captura e decodifica o corpo JSON recebido no payload.
                                                            */
                                                            function receberJson(): array {
                                                                $json = file_get_contents('php://input');
                                                                    $dados = json_decode($json, true);
                                                                        return is_array($dados) ? $dados : [];
                                                                        }

                                                                        /**
                                                                         * Valida se o ID enviado via parâmetro de URL (?id=X) é válido.
                                                                          */
                                                                          function validarId(): int {
                                                                              $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                                                                                  if (!$id || $id <= 0) {
                                                                                          responder(400, [
                                                                                                      'sucesso' => false,
                                                                                                                  'mensagem' => 'ID inválido ou não fornecido.'
                                                                                                                          ]);
                                                                                                                              }
                                                                                                                                  return $id;
                                                                                                                                  }

                                                                                                                                  /**
                                                                                                                                   * Envia a resposta final em formato JSON e encerra o script de forma segura.
                                                                                                                                    */
                                                                                                                                    function responder(int $codigoStatus, array $dados): void {
                                                                                                                                        http_response_code($codigoStatus);
                                                                                                                                            echo json_encode($dados, JSON_UNESCAPED_UNICODE);
                                                                                                                                                exit;
                                                                                                                                                }
                                                                                                                                                