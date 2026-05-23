<?php

namespace Api\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Api\Services\MinisteriosService;

/**
 * Classe MinisteriosController
 *
 * Responsável pelos endpoints REST da entidade Ministério.
 *
 * PADRÃO:
 * - Assinaturas em uma linha
 * - JSON convertido para stdClass
 * - Controller delega regras para Service
 */
class MinisteriosController
{
    /**
     * Serviço da entidade Usuario.
     *
     * @var MinisteriosService
     */
    private MinisteriosService $ministeriosService;

    /**
     * Injeção de dependência.
     *
     * @param MinisteriosService $ministeriosServiceDependency
     */
    public function __construct(MinisteriosService $ministeriosServiceDependency)
    {
        error_log("⬆️ MinisteriosController::__construct()");
        $this->ministeriosService = $ministeriosServiceDependency;
    }

    /**
     * Cria novo ministério.
     *
     * Endpoint:
     * POST /ministerios
     *
     * JSON esperado:
     * {
     *   "ministerios": {
     *      "nome": "Música"
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
        error_log("🔵 MinisteriosController::createController()");

        $objPHP = json_decode(json_encode($request->getParsedBody()));

        $novoMinisterio = $this->ministeriosService->createService($objPHP);

        $resposta = [
            'success' => true,
            'message' => 'Cadastro realizado com sucesso',
            'data' => [
                'ministerios' => [
                    [
                        'idMinisterios' => $novoMinisterio->getIdMinisterios(),
                        'nome' => $novoMinisterio->getNome(),
                        'descricao' => $novoMinisterio->getDescricao(),
                        'diaReuniao' => $novoMinisterio->getDiaReuniao(),
                        'idCoordenador' => $novoMinisterio->getIdCoordenador()
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
        error_log("🔵 MinisteriosController::findAllController()");

        $ministerios = $this->ministeriosService->findAllService();

        $resposta = [
            'success' => true,
            'message' => 'Busca realizada com sucesso',
            'data' => [
                'ministerios' => $ministerios
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function findByIdController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 MinisteriosController::findByIdController()");

        $idMinisterio = (int)$args['idMinisterios'];
        $ministerio = $this->ministeriosService->findByIdService($idMinisterio);

        if ($ministerio) {
            $resposta = [
                'success' => true,
                'message' => 'Busca realizada com sucesso',
                'data' => [
                    'ministerios' => [
                        [
                            'idMinisterios' => $ministerio->getIdMinisterios(),
                            'nome' => $ministerio->getNome(),
                            'descricao' => $ministerio->getDescricao(),
                            'diaReuniao' => $ministerio->getDiaReuniao(),
                            'idCoordenador' => $ministerio->getIdCoordenador()
                        ]
                    ]
                ]
            ];
            $status = 200;
        } else {
            $resposta = [
                'success' => false,
                'message' => 'Ministério não encontrado'
            ];
            $status = 404;
        }

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }

    public function updateController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 MinisteriosController::updateController()");

        $objPHP = json_decode(json_encode($request->getParsedBody()));

        $idMinisterio = (int)$args['idMinisterios'];
        $ministerioAtualizado = $this->ministeriosService->updateService($idMinisterio, $objPHP);

        if ($ministerioAtualizado) {
            $resposta = [
                'success' => true,
                'message' => 'Atualização realizada com sucesso',
                'data' => [
                    'ministerios' => [
                        [
                            'idMinisterios' => $ministerioAtualizado->getIdMinisterios(),
                            'nome' => $ministerioAtualizado->getNome(),
                            'descricao' => $ministerioAtualizado->getDescricao(),
                            'diaReuniao' => $ministerioAtualizado->getDiaReuniao(),
                            'idCoordenador' => $ministerioAtualizado->getIdCoordenador()
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
                'message' => 'Ministério não encontrado'
            ];

            $response->getBody()->write(json_encode($resposta));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }
    }

    public function deleteController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 MinisteriosController::deleteController()");

        $idMinisterio = (int)$args['idMinisterios'];
        $deletado = $this->ministeriosService->deleteService($idMinisterio);

        if ($deletado) {
            $resposta = [
                'success' => true,
                'message' => 'Ministério deletado com sucesso'
            ];

            $response->getBody()->write(json_encode($resposta));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        } else {
            $resposta = [
                'success' => false,
                'message' => 'Ministério não encontrado'
            ];

            $response->getBody()->write(json_encode($resposta));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }
    }

    public function countController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 MinisteriosController::countController()");

        $total = $this->ministeriosService->countService();

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