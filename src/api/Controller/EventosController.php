<?php

namespace Api\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Api\Services\EventosService;

/**
 * Classe EventosController
 *
 * Responsável pelos endpoints REST da entidade Evento.
 *
 * PADRÃO:
 * - Assinaturas em uma linha
 * - JSON convertido para stdClass
 * - Controller delega regras para Service
 */
class EventosController
{
    /**
     * Serviço da entidade Evento.
     *
     * @var EventosService
     */
    private EventosService $EventosService;

    /**
     * Injeção de dependência.
     *
     * @param EventosService $EventosServiceDependency
     */
    public function __construct(EventosService $EventosServiceDependency)
    {
        error_log("⬆️ EventosController::__construct()");
        $this->EventosService = $EventosServiceDependency;
    }

    /**
     * Cria novo evento.
     *
     * Endpoint:
     * POST /eventos
     *
     * JSON esperado:
     * {
     *   "eventos": {
     *      "titulo": "Retiro",
     *      "descricao": "Desc",
     *      "dataEvento": "2026-07-01",
     *      "localEvento": "Sítio",
     *      "limiteVagas": 50,
     *      "statusEvento": "ABERTO"
     *   }
     * }
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */

    public function createController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 EventosController::createController()");

        $objPHP = json_decode(json_encode($request->getParsedBody()));

        $novoEvento = $this->EventosService->createService($objPHP);

        $resposta = [
            'success' => true,
            'message' => 'Cadastro realizado com sucesso',
            'data' => [
                'eventos' => [
                    [
                        'idEvento' => $novoEvento->getIdEvento(),
                        'titulo' => $novoEvento->getTitulo(),
                        'descricao' => $novoEvento->getDescricao(),
                        'dataEvento' => $novoEvento->getDataEvento(),
                        'localEvento' => $novoEvento->getLocalEvento(),
                        'limiteVagas' => $novoEvento->getLimiteVagas(),
                        'statusEvento' => $novoEvento->getStatusEvento()
                    ]
                ]
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }

    public function findAllController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 EventosController::findAllController()");

        $eventos = $this->EventosService->findAllService();

        $resposta = [
            'success' => true,
            'message' => 'Busca realizada com sucesso',
            'data' => [
                'eventos' => $eventos
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function updateController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 EventosController::updateController()");

        $objPHP = json_decode(json_encode($request->getParsedBody()));

        $idEvento = (int)$args['idEvento'];
        $eventoAtualizado = $this->EventosService->updateService($idEvento, $objPHP);

        if ($eventoAtualizado) {
            $resposta = [
                'success' => true,
                'message' => 'Atualização realizada com sucesso',
                'data' => [
                    'eventos' => [
                        [
                            'idEvento' => $eventoAtualizado->getIdEvento(),
                            'titulo' => $eventoAtualizado->getTitulo(),
                            'descricao' => $eventoAtualizado->getDescricao(),
                            'dataEvento' => $eventoAtualizado->getDataEvento(),
                            'localEvento' => $eventoAtualizado->getLocalEvento(),
                            'limiteVagas' => $eventoAtualizado->getLimiteVagas(),
                            'statusEvento' => $eventoAtualizado->getStatusEvento()
                        ]
                    ]
                ]
            ];

            $response->getBody()->write(json_encode($resposta));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        } else {
            $resposta = [
                'success' => false,
                'message' => 'Evento não encontrado'
            ];

            $response->getBody()->write(json_encode($resposta));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }
    }

    public function deleteController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 EventosController::deleteController()");

        $idEvento = (int)$args['idEvento'];
        $deletado = $this->EventosService->deleteService($idEvento);

        if ($deletado) {
            $resposta = [
                'success' => true,
                'message' => 'Evento deletado com sucesso'
            ];

            $response->getBody()->write(json_encode($resposta));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        } else {
            $resposta = [
                'success' => false,
                'message' => 'Evento não encontrado'
            ];

            $response->getBody()->write(json_encode($resposta));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }
    }

    public function countController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 EventosController::countController()");

        $total = $this->EventosService->countService();

        $resposta = [
            'success' => true,
            'message' => 'Executado com sucesso',
            'data' => [
                'count' => $total
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }


}