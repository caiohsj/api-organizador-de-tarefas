<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\Application\Models\Task;

return function (App $app) {
    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });

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

    //Rota para deletar uma tarefa
    $app->delete('/tarefas/{id}/remove', function (Request $request, Response $response) {
        $id = intval($request->getAttribute('id'));
        $tarefa = Task::findOrFail($id);
        $tarefa->delete();
        $jsonTarefa = json_encode($tarefa);
        $response->getBody()->write($jsonTarefa);
        return $response->withHeader('Content-Type', 'application/json');
    });

    //Rota para pesquisar uma tarefa pelo titulo
    $app->get('/tarefas/busca/titulo/{titulo}', function (Request $request, Response $response) {

        $titulo = $request->getAttribute('titulo');

        $titulo = '%'.$titulo.'%';

        $tarefas = Task::where('titulo', 'like', $titulo)->get();
        $jsonTarefas = json_encode($tarefas);
        $response->getBody()->write($jsonTarefas);
        return $response->withHeader('Content-Type', 'application/json');
    });

    //Rota para pesquisar uma tarefa pela descrição
    $app->get('/tarefas/busca/descricao/{descricao}', function (Request $request, Response $response) {

        $descricao = $request->getAttribute('descricao');

        $descricao = '%'.$descricao.'%';

        $tarefas = Task::where('descricao', 'like', $descricao)->get();
        $jsonTarefas = json_encode($tarefas);
        $response->getBody()->write($jsonTarefas);
        return $response->withHeader('Content-Type', 'application/json');
    });

    //Última rota
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });

};
