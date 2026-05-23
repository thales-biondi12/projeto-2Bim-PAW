<?php

namespace Api\Router;

use Slim\App;
use Api\Controller\InscricoesController;
use Api\Middlewares\Inscricao\ValidateInscricoesBody;
use Api\Middlewares\Inscricao\ValidateInscricoesId;

class InscricoesRouter
{
    private App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function setupRoutes(): void
    {
        $this->app->post('/inscricoes', [InscricoesController::class, 'createController'])
            ->add(ValidateInscricoesBody::class);

        $this->app->get('/inscricoes', [InscricoesController::class, 'findAllController']);

        $this->app->get('/inscricoes/count', [InscricoesController::class, 'countController']);

        $this->app->get('/inscricoes/{idInscricoes}', [InscricoesController::class, 'findByIdController'])
            ->add(ValidateInscricoesId::class);

        $this->app->put('/inscricoes/{idInscricoes}', [InscricoesController::class, 'updateController'])
            ->add(ValidateInscricoesBody::class)
            ->add(ValidateInscricoesId::class);

        $this->app->delete('/inscricoes/{idInscricoes}', [InscricoesController::class, 'deleteController'])
            ->add(ValidateInscricoesId::class);
    }
}
