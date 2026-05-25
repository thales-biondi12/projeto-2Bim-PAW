<?php

namespace Api\Middlewares\Eventos;

use Api\Http\ErrorResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class ValidateEventosBody implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): Response
    {
        $body = $request->getParsedBody();

        if (!is_array($body) || !isset($body['eventos']) || !is_array($body['eventos'])) {
            throw new ErrorResponse(
                400,
                'Body invalido',
                ['message' => 'O JSON deve conter o objeto eventos']
            );
        }

        $eventos = $body['eventos'];
        $requiredFields = ['titulo', 'descricao', 'dataEvento', 'localEvento', 'limiteVagas', 'statusEvento'];

        foreach ($requiredFields as $field) {
            if (empty(trim((string) ($eventos[$field] ?? '')))) {
                throw new ErrorResponse(
                    400,
                    'Campo obrigatorio',
                    ['message' => "O campo eventos.{$field} e obrigatorio"]
                );
            }
        }

        return $handler->handle($request);
    }
}
