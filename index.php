<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Excepition\HttpNotFoundException;

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


$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});

$app->get('/tarefas', function (Request $request, Response $response, array $args)
{
    $tarefas = [
        ["id" =>1, "titulo" => "Ler a documentação do Slim", "concluido" => false],
        ["id" =>3, "titulo" => "Ler a documentação do composer", "concluido" => true],
        ["id" =>4, "titulo" => "Fazer um lanche", "concluido" => true],
        ["id" =>5, "titulo" => "Limpar o quarto", "concluido" => false],
    ];
    $response->getBody()->write(json_encode($tarefas));
    return $response->withHeader('Content-Type', 'application/json');

});

$app->post('/tarefas', function (Request $request, Response $response, array $args) {
    return $response->withStatus(201);
});

$app->delete('/tarefas/{id}', function (Request $request, Response $response, aray $args) {
    $id = $args['id'];
    return $response->withStatus (204); 
});

$app->put('/tarefas/{id}', function (Request $request, Response $response, aray $args) {
    $id = $args['id'];
    $dados_para_atualizar = (array) $request->getParsedBody();
    if(array_key_exists('titulo', $dados_para_atualizar) && empty($dados_para_atualizar['titulo'])){
        $response->getBody()->write(json_encode([
"mensagem" => "titulo é obrigatorio"
        ]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
    return $response->withStatus (201);  
});


$app->run();