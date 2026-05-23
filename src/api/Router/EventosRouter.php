<?php

namespace Api\Router;

use Slim\App;
use Api\Controller\EventosController;
use Api\Middlewares\Eventos\ValidateEventosBody;
use Api\Middlewares\Eventos\ValidateEventosId;

class EventosRouter
{
    private App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function setupRoutes(): void
    {
        $this->app->post('/eventos', [EventosController::class, 'createController'])
            ->add(ValidateEventosBody::class);

        $this->app->get('/eventos', [EventosController::class, 'findAllController']);

        $this->app->get('/eventos/count', [EventosController::class, 'countController']);

        $this->app->get('/eventos/{idEvento}', [EventosController::class, 'findByIdController'])
            ->add(ValidateEventosId::class);

        $this->app->put('/eventos/{idEvento}', [EventosController::class, 'updateController'])
            ->add(ValidateEventosBody::class)
            ->add(ValidateEventosId::class);

        $this->app->delete('/eventos/{idEvento}', [EventosController::class, 'deleteController'])
            ->add(ValidateEventosId::class);
    }
}
