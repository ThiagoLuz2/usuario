<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->addBodyParsingMiddleware(); 
$usuarios = [
    ['id' => 1, 'login' => 'user1', 'senha' => '123', 'nome' => 'João', 'perfil' => 'admin'],
    ['id' => 2, 'login' => 'user2', 'senha' => '456', 'nome' => 'Maria', 'perfil' => 'user'],

];

$app->post('/usuarios', function (Request $request, Response $response, array $args) use (&$usuarios) {
    $dados = $request->getParsedBody();

    if (empty($dados['login']) || empty($dados['senha'])) {
        $response->getBody()->write(json_encode(['erro' => 'Login e senha são obrigatórios!']));
        return $response->withStatus(400);
    }

    $novoUsuario = [
        'id' => count($usuarios) + 1,
        'login' => $dados['login'],
        'senha' => $dados['senha'],
        'nome' => $dados['nome'] ?? null,
        'perfil' => $dados['perfil'] ?? null
    ];

    $usuarios[] = $novoUsuario;
    $response->getBody()->write(json_encode($novoUsuario));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
});

$app->get('/usuarios', function (Request $request, Response $response, array $args) use ($usuarios) {
    $response->getBody()->write(json_encode(array_slice($usuarios, 0, 5)));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->delete('/usuarios/{id}', function (Request $request, Response $response, array $args) use (&$usuarios) {
    $id = $args['id'];
    $usuarios = array_filter($usuarios, fn($user) => $user['id'] != $id);
    return $response->withStatus(204);
});

$app->put('/usuarios/{id}', function (Request $request, Response $response, array $args) use (&$usuarios) {
    $id = $args['id'];
    $dados = $request->getParsedBody();

    foreach ($usuarios as &$user) {
        if ($user['id'] == $id) {
            $user['login'] = $dados['login'] ?? $user['login'];
            $user['senha'] = $dados['senha'] ?? $user['senha'];
            $user['nome'] = $dados['nome'] ?? $user['nome'];
            $user['perfil'] = $dados['perfil'] ?? $user['perfil'];
            return $response->withJson($user);
        }
    }

    return $response->withStatus(404)->withJson(['erro' => 'Usuário não encontrado']);
});

$app->run();