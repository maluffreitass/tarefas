<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Exception\HttpNotFoundException;
use MariaFreitas4\Tarefas\Service\TarefasService;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setErrorHandler(HttpNotFoundException::class, function (
    Request $request,
    Throwable $exception,
    bool $displayerrorDetails,
    bool $logErrors,
    bool $logErrorDetails
) use ($app) {
    $response = $app->getResponseFactory()->createResponse();
    $response->getBody()->write('{"error": "Recurso não foi encontrado"}');
    return $response->withHeader('Content-Type', 'application/json')
        ->withStatus(404);
});

$app->get('/tarefas', function (Request $request, Response $response, array $args) {
    $tarefas_service = new TarefasService();
    $tarefas = $tarefas_service->getAllTarefas();
    $response->getBody()->write(json_encode($tarefas));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/tarefas', function (Request $request, Response $response, array $args) {
   $parametros = (array) $request->getParsedBody();
   if(!array_key_exists('titulo', $parametros) || empty($parametros['titulo'])){
    $response->getBody()->write(json_encode([
      "mensagem" => "titulo é obrigatorio"
    ]));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
   }
   $tarefas = array_merge(['titulo' => '', 'concluido' => false], $parametros);
   $tarefas_service = new TarefasService();
   $tarefas_service->createTarefa($tarefas);

   return $response->withStatus(201);
});

$app->delete('/tarefas/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    return $response->withStatus(204);
});

$app->put('/tarefas/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $dados_para_atualizar = (array) $request->getParsedBody();
    if (array_key_exists('titulo', $dados_para_atualizar) && empty($dados_para_atualizar['titulo'])) {
        $response->getBody()->write(json_encode([
            "mensagem" => "titulo é obrigatorio"
        ]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
    return $response->withStatus(201);
});


$app->run();
