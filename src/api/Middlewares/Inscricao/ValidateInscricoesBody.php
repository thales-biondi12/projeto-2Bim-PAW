<?php

namespace Api\Middlewares\Inscricao;

use Api\Http\ErrorResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class ValidateInscricoesBody implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): Response
    {
        $body = $request->getParsedBody();

        if (!is_array($body) || !isset($body['inscricoes']) || !is_array($body['inscricoes'])) {
            throw new ErrorResponse(
                400,
                'Body invalido',
                ['message' => 'O JSON deve conter o objeto inscricoes']
            );
        }

        $insc = $body['inscricoes'];
        $requiredFields = ['usuarioId', 'eventoId', 'dataInscricao', 'presenca'];

        foreach ($requiredFields as $field) {
            if (empty(trim((string) ($insc[$field] ?? '')))) {
                throw new ErrorResponse(
                    400,
                    'Campo obrigatorio',
                    ['message' => "O campo inscricoes.{$field} e obrigatorio"]
                );
            }
        }

        return $handler->handle($request);
    }
}
