<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\Application\Models\Task;

return function (App $app) {
    $app->get('/tarefas/lista', function (Request $request, Response $response) {
        $tarefas = Task::get();
        $jsonTarefas = json_encode($tarefas);
        $response->getBody()->write($jsonTarefas);
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->post('/tarefas/adiciona', function (Request $request, Response $response) {
        $dadosForm = $request->getParsedBody();

        $tarefa = Task::create($dadosForm);
        $jsonTarefa = json_encode($tarefa);
        $response->getBody()->write($jsonTarefa);
        return $response->withHeader('Content-Type', 'application/json');
    });

};
