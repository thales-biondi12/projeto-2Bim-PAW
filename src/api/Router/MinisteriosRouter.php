<?php

namespace Api\Router;

use Slim\App;
use Api\Controller\MinisteriosController;
use Api\Middlewares\Ministerios\ValidateMinisteriosBody;
use Api\Middlewares\Ministerios\ValidateMinisteriosId;

/**
 * Classe responsável por registrar as rotas do recurso Ministérios.
 *
 * Endpoints disponíveis:
 * - POST   /ministerios
 * - GET    /ministerios
 * - GET    /ministerios/count
 * - GET    /ministerios/{idMinisterios}
 * - PUT    /ministerios/{idMinisterios}
 * - DELETE /ministerios/{idMinisterios}
 */
class MinisteriosRouter
{
    /**
     * Instância da aplicação Slim.
     *
     * @var App
     */
    private App $app;

    /**
     * Recebe a instância principal da aplicação.
     *
     * @param App $app Aplicação Slim.
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Registra todas as rotas relacionadas ao recurso Ministério.
     *
     * Estrutura esperada do JSON:
     *
     * {
     *   "ministerios": {
     *     "nome": "Musica"
     *   }
     * }
     *
     * @return void
     */
    public function setupRoutes(): void
    {
        /**
         * =========================================================
         * POST /ministerios
         * =========================================================
         */
        $this->app->post(
            '/ministerios',
            [MinisteriosController::class, 'createController']
        )
            ->add(ValidateMinisteriosBody::class);

        /**
         * =========================================================
         * GET /ministerios
         * =========================================================
         */
        $this->app->get(
            '/ministerios',
            [MinisteriosController::class, 'findAllController']
        );

        /**
         * =========================================================
         * GET /ministerios/count
         * =========================================================
         */
        $this->app->get(
            '/ministerios/count',
            [MinisteriosController::class, 'countController']
        );

        /**
         * =========================================================
         * GET /ministerios/{idMinisterios}
         * =========================================================
         */
        $this->app->get(
            '/ministerios/{idMinisterios}',
            [MinisteriosController::class, 'findByIdController']
        )
            ->add(ValidateMinisteriosId::class);

        /**
         * =========================================================
         * PUT /ministerios/{idMinisterios}
         * =========================================================
         */
        $this->app->put(
            '/ministerios/{idMinisterios}',
            [MinisteriosController::class, 'updateController']
        )
            ->add(ValidateMinisteriosBody::class)
            ->add(ValidateMinisteriosId::class);

        /**
         * =========================================================
         * DELETE /ministerios/{idMinisterios}
         * =========================================================
         */
        $this->app->delete(
            '/ministerios/{idMinisterios}',
            [MinisteriosController::class, 'deleteController']
        )
            ->add(ValidateMinisteriosId::class);
    }
}
