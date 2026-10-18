
<?php

header('Content-Type: application/json; charset=utf-8');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Trata requisições CORS de verificação prévia
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
        exit;
        }

        /**
         * Retorna uma resposta JSON e encerra a execução.
          */
          function responder(int $status, array $dados): void
          {
              http_response_code($status);

                  echo json_encode(
                          $dados,
                                  JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                                      );

                                          exit;
                                          }

                                          /**
                                           * Verifica se o método HTTP é permitido.
                                            */
                                            function exigirMetodo(string $metodo): void
                                            {
                                                if ($_SERVER['REQUEST_METHOD'] !== strtoupper($metodo)) {
                                                        header('Allow: ' . strtoupper($metodo) . ', OPTIONS');

                                                                responder(405, [
                                                                            'sucesso' => false,
                                                                                        'mensagem' => 'Método HTTP não permitido.'
                                                                                                ]);
                                                                                                    }
                                                                                                    }

                                                                                                    /**
                                                                                                     * Recebe e valida o JSON enviado na requisição.
                                                                                                      */
                                                                                                      function receberJson(): array
                                                                                                      {
                                                                                                          $conteudo = file_get_contents('php://input');

                                                                                                              if ($conteudo === false || trim($conteudo) === '') {
                                                                                                                      responder(400, [
                                                                                                                                  'sucesso' => false,
                                                                                                                                              'mensagem' => 'O corpo da requisição está vazio.'
                                                                                                                                                      ]);
                                                                                                                                                          }

                                                                                                                                                              $dados = json_decode($conteudo, true);

                                                                                                                                                                  if (json_last_error() !== JSON_ERROR_NONE || !is_array($dados)) {
                                                                                                                                                                          responder(400, [
                                                                                                                                                                                      'sucesso' => false,
                                                                                                                                                                                                  'mensagem' => 'JSON inválido.'
                                                                                                                                                                                                          ]);
                                                                                                                                                                                                              }

                                                                                                                                                                                                                  return $dados;
                                                                                                                                                                                                                  }

                                                                                                                                                                                                                  /**
                                                                                                                                                                                                                   * Valida o ID recebido pela URL.
                                                                                                                                                                                                                    */
                                                                                                                                                                                                                    function validarId(): int
                                                                                                                                                                                                                    {
                                                                                                                                                                                                                        $id = filter_var(
                                                                                                                                                                                                                                $_GET['id'] ?? null,
                                                                                                                                                                                                                                        FILTER_VALIDATE_INT,
                                                                                                                                                                                                                                                ['options' => ['min_range' => 1]]
                                                                                                                                                                                                                                                    );

                                                                                                                                                                                                                                                        if ($id === false) {
                                                                                                                                                                                                                                                                responder(400, [
                                                                                                                                                                                                                                                                            'sucesso' => false,
                                                                                                                                                                                                                                                                                        'mensagem' => 'Informe um ID válido na URL.'
                                                                                                                                                                                                                                                                                                ]);
                                                                                                                                                                                                                                                                                                    }

                                                                                                                                                                                                                                                                                                        return $id;
                                                                                                                                                                                                                                                                                                        }