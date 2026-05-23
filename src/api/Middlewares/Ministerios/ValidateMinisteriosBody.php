<?php

namespace Api\Middlewares\Ministerios;

use Api\Http\ErrorResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class ValidateMinisteriosBody implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): Response
    {
        $body = $request->getParsedBody();

        if (!is_array($body) || !isset($body['ministerios']) || !is_array($body['ministerios'])) {
            throw new ErrorResponse(
                400,
                'Body invalido',
                ['message' => 'O JSON deve conter o objeto ministerios']
            );
        }

        $ministerios = $body['ministerios'];

        if (empty(trim((string) ($ministerios['nome'] ?? '')))) {
            throw new ErrorResponse(
                400,
                'Nome obrigatorio',
                ['message' => 'O campo ministerios.nome e obrigatorio']
            );
        }


        return $handler->handle($request);
    }
}
