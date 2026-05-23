<?php

namespace Api\Services;

use Api\Models\Eventos;
use Api\Dao\EventosDao;
use Api\Http\ErrorResponse;
use stdClass;

/**
 * Camada de regra de negócio da entidade Eventos.
 *
 * Fluxo:
 * Controller -> Service -> DAO -> Banco
 */
class EventosService
{
    private EventosDao $eventosDAO;

    public function __construct(EventosDao $eventosDAODependency)
    {
        error_log("⬆️ EventosService::__construct()");
        $this->eventosDAO = $eventosDAODependency;
    }

    public function createService(stdClass $objPHP): Eventos
    {
        error_log("🟣 EventosService::createService()");

        $evento = new Eventos();
        $evento->setTitulo($objPHP->eventos->titulo);
        $evento->setDescricao($objPHP->eventos->descricao);
        $evento->setDataEvento($objPHP->eventos->dataEvento);
        $evento->setLocalEvento($objPHP->eventos->localEvento);
        $evento->setLimiteVagas($objPHP->eventos->limiteVagas);
        $evento->setStatusEvento($objPHP->eventos->statusEvento);

        return $this->eventosDAO->create($evento);
    }

    public function countService(): int
    {
        error_log("🟣 EventosService::countService()");
        return $this->eventosDAO->count();
    }

    public function findAllService(): array
    {
        error_log("🟣 EventosService::findAllService()");
        return $this->eventosDAO->findAll();
    }

    public function findByIdService(int $idEvento): ?Eventos
    {
        error_log("🟣 EventosService::findByIdService()");
        return $this->eventosDAO->findById($idEvento);
    }

    public function updateService(int $idEvento, stdClass $objPHP): Eventos
    {
        error_log("🟣 EventosService::updateService()");

        $eventoExistente = $this->eventosDAO->findById($idEvento);

        if (!$eventoExistente) {
            throw new ErrorResponse(
                404,
                "Evento não encontrado",
                ["message" => "Não existe evento com id {$idEvento}"]
            );
        }

        $eventoExistente->setTitulo($objPHP->eventos->titulo);
        $eventoExistente->setDescricao($objPHP->eventos->descricao);
        $eventoExistente->setDataEvento($objPHP->eventos->dataEvento);
        $eventoExistente->setLocalEvento($objPHP->eventos->localEvento);
        $eventoExistente->setLimiteVagas($objPHP->eventos->limiteVagas);
        $eventoExistente->setStatusEvento($objPHP->eventos->statusEvento);

        $this->eventosDAO->update($eventoExistente);
        return $eventoExistente;
    }

    public function deleteService(int $idEvento): bool
    {
        error_log("🟣 EventosService::deleteService()");

        $eventoExistente = $this->eventosDAO->findById($idEvento);

        if (!$eventoExistente) {
            throw new ErrorResponse(
                404,
                "Evento não encontrado",
                ["message" => "Não existe evento com id {$idEvento}"]
            );
        }

        return $this->eventosDAO->delete($eventoExistente);
    }
}
