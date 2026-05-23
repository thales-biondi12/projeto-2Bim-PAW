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
