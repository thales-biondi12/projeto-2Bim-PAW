<?php

namespace Api\Server;

// Importações das classes necessárias
use Slim\App;
use Psr\Http\Message\ServerRequestInterface;
use Api\Http\ErrorResponse;

use Api\Router\UsuariosRouter;
use Api\Router\MinisteriosRouter;
use Api\Router\EventosRouter;
use Api\Router\InscricoesRouter;
use Api\Router\MensagensRouter;

/**
 * Classe Server - Responsável por configurar e executar o servidor HTTP
 */
class Server
{
    /**
     * Instância da aplicação Slim
     * @var App
     */
    private App $app;

    /**
     * Router responsável pelas rotas de usuários
     * @var UsuariosRouter
     */
    private UsuariosRouter $usuariosRouter;

    /**
     * Router responsável pelas rotas de ministérios
     * @var MinisteriosRouter
     */
    private MinisteriosRouter $ministeriosRouter;

    /**
     * Router responsável pelas rotas de eventos
     * @var EventosRouter
     */
    private EventosRouter $eventosRouter;

    /**
     * Router responsável pelas rotas de inscrições
     * @var InscricoesRouter
     */
    private InscricoesRouter $inscricoesRouter;

    /**
     * Router responsável pelas rotas de mensagens
     * @var MensagensRouter
     */
    private MensagensRouter $mensagensRouter;

    /**
     * Construtor
     */
    public function __construct(
        App $app,
        UsuariosRouter $usuariosRouter,
        MinisteriosRouter $ministeriosRouter,
        EventosRouter $eventosRouter,
        InscricoesRouter $inscricoesRouter,
        MensagensRouter $mensagensRouter
    ) {

        $this->app = $app;

        $this->usuariosRouter = $usuariosRouter;
        $this->ministeriosRouter = $ministeriosRouter;
        $this->eventosRouter = $eventosRouter;
        $this->inscricoesRouter = $inscricoesRouter;
        $this->mensagensRouter = $mensagensRouter;

        $this->setupMiddlewares();
        $this->setupRoutes();
        $this->setupErrorHandling();
    }

    /**
     * Configuração dos middlewares
     */
    private function setupMiddlewares(): void
    {

        $this->app->addBodyParsingMiddleware();

        $this->app->add(function ($request, $handler) {

            $response = $handler->handle($request);

            return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader(
                    'Access-Control-Allow-Methods',
                    'GET, POST, PUT, DELETE, OPTIONS'
                )
                ->withHeader(
                    'Access-Control-Allow-Headers',
                    'Content-Type, Authorization'
                );
        });
    }

    /**
     * Configuração das rotas
     */
    private function setupRoutes(): void
    {

        /**
         * =========================
         * ROTAS
         * =========================
         */

        $this->usuariosRouter->setupRoutes();
        $this->ministeriosRouter->setupRoutes();
        $this->eventosRouter->setupRoutes();
        $this->inscricoesRouter->setupRoutes();
        $this->mensagensRouter->setupRoutes();

        /**
         * =========================
         * ROTA RAIZ
         * =========================
         */

        $this->app->get('/', function ($request, $response) {

            return $response
                ->withHeader('Location', '/login.html')
                ->withStatus(302);
        });
    }

    /**
     * Tratamento global de erros
     */
    private function setupErrorHandling(): void
    {

        $errorMiddleware = $this->app->addErrorMiddleware(true, true, true);

        $errorMiddleware->setDefaultErrorHandler(
            function (
                ServerRequestInterface $request,
                \Throwable $exception
            ) {

                $response = new \Slim\Psr7\Response();

                $status = 500;

                /**
                 * ERROS PERSONALIZADOS
                 */
                if ($exception instanceof ErrorResponse) {

                    $payload = [
                        'success' => false,
                        'message' => $exception->getMessage(),
                        'error' => $exception->getError() ?? (object) [],
                    ];

                    $status = $exception->getHttpCode();
                }

                /**
                 * ERROS GERAIS
                 */
                else {

                    $payload = [
                        'success' => false,
                        'message' => $exception->getMessage(),
                        'error' => [
                            'code' => $exception->getCode(),
                            'stack' => $exception->getTrace(),
                            'file' => $exception->getFile(),
                            'line' => $exception->getLine(),
                        ],
                    ];
                }

                $response->getBody()->write(
                    json_encode(
                        $payload,
                        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
                    )
                );

                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus($status);
            }
        );
    }

    /**
     * Executa o servidor
     */
    public function run(): void
    {

        $this->app->run();
    }
}
