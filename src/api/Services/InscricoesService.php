<?php

namespace Api\Services;

use Api\Models\Inscricoes;
use Api\Dao\InscricaoDao;
use Api\Dao\UsuariosDao;
use Api\Dao\EventosDao;
use Api\Http\ErrorResponse;
use stdClass;

class InscricoesService
{
    private InscricaoDao $inscricaoDAO;
    private UsuariosDao $usuariosDAO;
    private EventosDao $eventosDAO;

    public function __construct(
        InscricaoDao $inscricaoDAODependency,
        UsuariosDao $usuariosDAODependency,
        EventosDao $eventosDAODependency
    ) {
        error_log("⬆️ InscricoesService::__construct()");
        $this->inscricaoDAO = $inscricaoDAODependency;
        $this->usuariosDAO = $usuariosDAODependency;
        $this->eventosDAO = $eventosDAODependency;
    }

    public function createService(stdClass $objPHP): Inscricoes
    {
        error_log("🟣 InscricoesService::createService()");

<<<<<<< HEAD
        $usuarioId = $objPHP->inscricoes->usuarioId ?? null;
        $eventoId = $objPHP->inscricoes->eventoId ?? null;
        $dataInscricao = $objPHP->inscricoes->dataInscricao ?? null;
        $presenca = $objPHP->inscricoes->presenca ?? null;

        if (!$usuarioId || !$this->usuariosDAO->findById($usuarioId)) {
            throw new ErrorResponse(
                400,
                "Usuário não encontrado",
                ["message" => "O usuário com id {$usuarioId} não existe."]
            );
        }

        if (!$eventoId || !$this->eventosDAO->findById($eventoId)) {
            throw new ErrorResponse(
                400,
                "Evento não encontrado",
                ["message" => "O evento com id {$eventoId} não existe."]
            );
        }

        $inscricoesUsuario = $this->inscricaoDAO->findByField('usuario_id', $usuarioId);
        foreach ($inscricoesUsuario as $insc) {
            if ($insc->getEventoId() === $eventoId) {
                throw new ErrorResponse(
                    400,
                    "Inscrição duplicada",
                    ["message" => "Usuário já inscrito neste evento."]
                );
            }
        }

        $eventosInscricoes = $this->inscricaoDAO->findByField('evento_id', $eventoId);
        $evento = $this->eventosDAO->findById($eventoId);
        if ($evento && $evento->getLimiteVagas() > 0 && count($eventosInscricoes) >= $evento->getLimiteVagas()) {
            throw new ErrorResponse(
                400,
                "Evento sem vagas",
                ["message" => "Não há vagas disponíveis neste evento."]
            );
        }

        if (!$dataInscricao) {
            $dataInscricao = (new \DateTime())->format('Y-m-d');
        }

        $inscricao = new Inscricoes();
        $inscricao->setUsuarioId($usuarioId);
        $inscricao->setEventoId($eventoId);
        $inscricao->setDataInscricao($dataInscricao);
        $inscricao->setPresenca($presenca);
=======
        if (!$this->usuariosDAO->findById($objPHP->inscricoes->usuarioId)) {
            throw new ErrorResponse(
                400,
                "Usuário não encontrado",
                ["message" => "O usuário com id {$objPHP->inscricoes->usuarioId} não existe."]
            );
        }

        if (!$this->eventosDAO->findById($objPHP->inscricoes->eventoId)) {
            throw new ErrorResponse(
                400,
                "Evento não encontrado",
                ["message" => "O evento com id {$objPHP->inscricoes->eventoId} não existe."]
            );
        }

        $inscricao = new Inscricoes();
        $inscricao->setUsuarioId($objPHP->inscricoes->usuarioId);
        $inscricao->setEventoId($objPHP->inscricoes->eventoId);
        $inscricao->setDataInscricao($objPHP->inscricoes->dataInscricao);
        $inscricao->setPresenca($objPHP->inscricoes->presenca);
>>>>>>> ddd022ee9a6055f2d71227862320bc73bcba8ce1

        return $this->inscricaoDAO->create($inscricao);
    }

    public function countService(): int
    {
        error_log("🟣 InscricoesService::countService()");
        return $this->inscricaoDAO->count();
    }

    public function findAllService(): array
    {
        error_log("🟣 InscricoesService::findAllService()");
        return $this->inscricaoDAO->findAll();
    }

    public function findByIdService(int $idInscricoes): ?Inscricoes
    {
        error_log("🟣 InscricoesService::findByIdService()");
        return $this->inscricaoDAO->findById($idInscricoes);
    }

    public function updateService(int $idInscricoes, stdClass $objPHP): Inscricoes
    {
        error_log("🟣 InscricoesService::updateService()");

        $inscricaoExistente = $this->inscricaoDAO->findById($idInscricoes);

        if (!$inscricaoExistente) {
            throw new ErrorResponse(
                404,
                "Inscricao não encontrada",
                ["message" => "Não existe inscrição com id {$idInscricoes}"]
            );
        }

<<<<<<< HEAD
        $usuarioId = $objPHP->inscricoes->usuarioId ?? null;
        $eventoId = $objPHP->inscricoes->eventoId ?? null;
        $dataInscricao = $objPHP->inscricoes->dataInscricao ?? null;
        $presenca = $objPHP->inscricoes->presenca ?? null;

        if (!$usuarioId || !$this->usuariosDAO->findById($usuarioId)) {
            throw new ErrorResponse(
                400,
                "Usuário não encontrado",
                ["message" => "O usuário com id {$usuarioId} não existe."]
            );
        }

        if (!$eventoId || !$this->eventosDAO->findById($eventoId)) {
            throw new ErrorResponse(
                400,
                "Evento não encontrado",
                ["message" => "O evento com id {$eventoId} não existe."]
            );
        }

        $inscricoesUsuario = $this->inscricaoDAO->findByField('usuario_id', $usuarioId);
        foreach ($inscricoesUsuario as $insc) {
            if ($insc->getEventoId() === $eventoId && $insc->getIdInscricoes() !== $idInscricoes) {
                throw new ErrorResponse(
                    400,
                    "Inscrição duplicada",
                    ["message" => "Usuário já inscrito neste evento."]
                );
            }
        }

        $evento = $this->eventosDAO->findById($eventoId);
        $eventosInscricoes = $this->inscricaoDAO->findByField('evento_id', $eventoId);
        if ($evento && $evento->getLimiteVagas() > 0 && $inscricaoExistente->getEventoId() !== $eventoId && count($eventosInscricoes) >= $evento->getLimiteVagas()) {
            throw new ErrorResponse(
                400,
                "Evento sem vagas",
                ["message" => "Não há vagas disponíveis neste evento."]
            );
        }

        if (!$dataInscricao) {
            $dataInscricao = (new \DateTime())->format('Y-m-d');
        }

        $inscricaoExistente->setUsuarioId($usuarioId);
        $inscricaoExistente->setEventoId($eventoId);
        $inscricaoExistente->setDataInscricao($dataInscricao);
        $inscricaoExistente->setPresenca($presenca);
=======
        if (!$this->usuariosDAO->findById($objPHP->inscricoes->usuarioId)) {
            throw new ErrorResponse(
                400,
                "Usuário não encontrado",
                ["message" => "O usuário com id {$objPHP->inscricoes->usuarioId} não existe."]
            );
        }

        if (!$this->eventosDAO->findById($objPHP->inscricoes->eventoId)) {
            throw new ErrorResponse(
                400,
                "Evento não encontrado",
                ["message" => "O evento com id {$objPHP->inscricoes->eventoId} não existe."]
            );
        }

        $inscricaoExistente->setUsuarioId($objPHP->inscricoes->usuarioId);
        $inscricaoExistente->setEventoId($objPHP->inscricoes->eventoId);
        $inscricaoExistente->setDataInscricao($objPHP->inscricoes->dataInscricao);
        $inscricaoExistente->setPresenca($objPHP->inscricoes->presenca);
>>>>>>> ddd022ee9a6055f2d71227862320bc73bcba8ce1

        $this->inscricaoDAO->update($inscricaoExistente);
        return $inscricaoExistente;
    }

    public function deleteService(int $idInscricoes): bool
    {
        error_log("🟣 InscricoesService::deleteService()");

        $inscricaoExistente = $this->inscricaoDAO->findById($idInscricoes);

        if (!$inscricaoExistente) {
            throw new ErrorResponse(
                404,
                "Inscricao não encontrada",
                ["message" => "Não existe inscrição com id {$idInscricoes}"]
            );
        }

        return $this->inscricaoDAO->delete($inscricaoExistente);
    }
}
