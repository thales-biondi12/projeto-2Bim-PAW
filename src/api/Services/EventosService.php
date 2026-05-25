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

        $titulo = trim($objPHP->eventos->titulo ?? '');
        $descricao = $objPHP->eventos->descricao ?? null;
        $dataEventoStr = $objPHP->eventos->dataEvento ?? null;
        $localEvento = $objPHP->eventos->localEvento ?? null;
        $limiteVagas = (int)($objPHP->eventos->limiteVagas ?? 0);
        $statusEvento = $objPHP->eventos->statusEvento ?? null;

        if ($titulo === '') {
            throw new ErrorResponse(400, "Título inválido", ["message" => "O título do evento não pode ser vazio."]);
        }

        $existente = $this->eventosDAO->findByField('titulo', $titulo);
        if (count($existente) > 0) {
            throw new ErrorResponse(400, "Evento já existe", ["message" => "O evento {$titulo} já está cadastrado"]);
        }

        if (!$dataEventoStr) {
            throw new ErrorResponse(400, "Data inválida", ["message" => "A data do evento é obrigatória."]);
        }

        try {
            $dataEvento = new \DateTime($dataEventoStr);
        } catch (\Exception $e) {
            throw new ErrorResponse(400, "Data inválida", ["message" => "Formato de data inválido."]);
        }

        $hoje = (new \DateTime())->setTime(0, 0, 0);
        $dataEvento->setTime(0, 0, 0);
        if ($dataEvento < $hoje) {
            throw new ErrorResponse(400, "Data inválida", ["message" => "A data do evento não pode ser anterior à data atual."]);
        }

        if ($limiteVagas < 0) {
            throw new ErrorResponse(400, "Limite inválido", ["message" => "O limite de vagas deve ser maior ou igual a zero."]);
        }

        $evento = new Eventos();
        $evento->setTitulo($titulo);
        $evento->setDescricao($descricao);
        $evento->setDataEvento($dataEvento->format('Y-m-d'));
        $evento->setLocalEvento($localEvento);
        $evento->setLimiteVagas($limiteVagas);
        $evento->setStatusEvento($statusEvento);

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

        $titulo = trim($objPHP->eventos->titulo ?? '');
        $descricao = $objPHP->eventos->descricao ?? null;
        $dataEventoStr = $objPHP->eventos->dataEvento ?? null;
        $localEvento = $objPHP->eventos->localEvento ?? null;
        $limiteVagas = (int)($objPHP->eventos->limiteVagas ?? 0);
        $statusEvento = $objPHP->eventos->statusEvento ?? null;

        if ($titulo === '') {
            throw new ErrorResponse(400, "Título inválido", ["message" => "O título do evento não pode ser vazio."]);
        }

        $existente = $this->eventosDAO->findByField('titulo', $titulo);
        foreach ($existente as $eventoMesmoTitulo) {
            if ($eventoMesmoTitulo->getIdEvento() !== $idEvento) {
                throw new ErrorResponse(400, "Evento já existe", ["message" => "O evento {$titulo} já está cadastrado"]);
            }
        }

        if (!$dataEventoStr) {
            throw new ErrorResponse(400, "Data inválida", ["message" => "A data do evento é obrigatória."]);
        }

        try {
            $dataEvento = new \DateTime($dataEventoStr);
        } catch (\Exception $e) {
            throw new ErrorResponse(400, "Data inválida", ["message" => "Formato de data inválido."]);
        }

        $hoje = (new \DateTime())->setTime(0, 0, 0);
        $dataEvento->setTime(0, 0, 0);
        if ($dataEvento < $hoje) {
            throw new ErrorResponse(400, "Data inválida", ["message" => "A data do evento não pode ser anterior à data atual."]);
        }

        if ($limiteVagas < 0) {
            throw new ErrorResponse(400, "Limite inválido", ["message" => "O limite de vagas deve ser maior ou igual a zero."]);
        }

        $eventoExistente->setTitulo($titulo);
        $eventoExistente->setDescricao($descricao);
        $eventoExistente->setDataEvento($dataEvento->format('Y-m-d'));
        $eventoExistente->setLocalEvento($localEvento);
        $eventoExistente->setLimiteVagas($limiteVagas);
        $eventoExistente->setStatusEvento($statusEvento);

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
