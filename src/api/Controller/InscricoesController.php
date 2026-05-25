<?php

namespace Api\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Api\Services\InscricoesService;

/**
 * Classe InscricoesController
 *
 * Responsável pelos endpoints REST da entidade Inscrição.
 *
 * PADRÃO:
 * - Assinaturas em uma linha
 * - JSON convertido para stdClass
 * - Controller delega regras para Service
 */
class InscricoesController
{
    /**
     * Serviço da entidade Evento.
     *
     * @var InscricoesService
     */
    private InscricoesService $InscricoesService;

    /**
     * Injeção de dependência.
     *
     * @param InscricoesService $InscricoesServiceDependency
     */
    public function __construct(InscricoesService $InscricoesServiceDependency)
    {
        error_log("⬆️ InscricoesController::__construct()");
        $this->InscricoesService = $InscricoesServiceDependency;
    }

    /**
     * Cria nova inscrição.
     *
     * Endpoint:
     * POST /inscricoes
     *
     * JSON esperado:
     * {
     *   "inscricoes": {
     *      "usuarioId": 1,
     *      "eventoId": 1,
     *      "dataInscricao": "2026-01-01",
     *      "presenca": "CONFIRMADA"
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
        error_log("🔵 InscricoesController::createController()");

        $objPHP = json_decode(json_encode($request->getParsedBody()));

        $novoInscricao = $this->InscricoesService->createService($objPHP);

        $resposta = [
            'success' => true,
            'message' => 'Cadastro realizado com sucesso',
            'data' => [
                'inscricoes' => [
                    [
                        'idInscricoes' => $novoInscricao->getIdInscricoes(),
                        'usuarioId' => $novoInscricao->getUsuarioId(),
                        'eventoId' => $novoInscricao->getEventoId(),
                        'dataInscricao' => $novoInscricao->getDataInscricao(),
                        'presenca' => $novoInscricao->getPresenca()
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
        error_log("🔵 InscricoesController::findAllController()");

        $inscricoes = $this->InscricoesService->findAllService();

        $resposta = [
            'success' => true,
            'message' => 'Busca realizada com sucesso',
            'data' => [
                'inscricoes' => $inscricoes
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function updateController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 InscricoesController::updateController()");

        $objPHP = json_decode(json_encode($request->getParsedBody()));

        $idInscricao = (int)$args['idInscricoes'];
        $inscricaoAtualizada = $this->InscricoesService->updateService($idInscricao, $objPHP);

        if ($inscricaoAtualizada) {
            $resposta = [
                'success' => true,
                'message' => 'Atualização realizada com sucesso',
                'data' => [
                    'inscricoes' => [
                        [
                            'idInscricoes' => $inscricaoAtualizada->getIdInscricoes(),
                            'usuarioId' => $inscricaoAtualizada->getUsuarioId(),
                            'eventoId' => $inscricaoAtualizada->getEventoId(),
                            'dataInscricao' => $inscricaoAtualizada->getDataInscricao(),
                            'presenca' => $inscricaoAtualizada->getPresenca()
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
                'message' => 'Inscrição não encontrada'
            ];

            $response->getBody()->write(json_encode($resposta));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }
    }

    public function deleteController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 InscricoesController::deleteController()");

        $idInscricao = (int)$args['idInscricoes'];
        $deletado = $this->InscricoesService->deleteService($idInscricao);

        if ($deletado) {
            $resposta = [
                'success' => true,
                'message' => 'Inscrição deletada com sucesso'
            ];

            $response->getBody()->write(json_encode($resposta));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        } else {
            $resposta = [
                'success' => false,
                'message' => 'Inscrição não encontrada'
            ];

            $response->getBody()->write(json_encode($resposta));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }
    }

    public function countController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 InscricoesController::countController()");

        $total = $this->InscricoesService->countService();

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