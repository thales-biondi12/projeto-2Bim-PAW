<?php

namespace Api\Services;

use Api\Models\Mensagens;
use Api\Dao\MensagemDao;
use Api\Http\ErrorResponse;
use stdClass;

class MensagensService
{
    private MensagemDao $mensagemDAO;

    public function __construct(MensagemDao $mensagemDAODependency)
    {
        error_log("⬆️ MensagensService::__construct()");
        $this->mensagemDAO = $mensagemDAODependency;
    }

    public function createService(stdClass $objPHP): Mensagens
    {
        error_log("🟣 MensagensService::createService()");

        $mensagem = new Mensagens();
        $mensagem->setTitulo($objPHP->mensagens->titulo);
        $mensagem->setConteudo($objPHP->mensagens->conteudo);
        $mensagem->setUsuarioId($objPHP->mensagens->usuarioId);
        $mensagem->setDataPostagem($objPHP->mensagens->dataPostagem);

        return $this->mensagemDAO->create($mensagem);
    }

    public function countService(): int
    {
        error_log("🟣 MensagensService::countService()");
        return $this->mensagemDAO->count();
    }

    public function findAllService(): array
    {
        error_log("🟣 MensagensService::findAllService()");
        return $this->mensagemDAO->findAll();
    }

    public function findByIdService(int $idMensagens): ?Mensagens
    {
        error_log("🟣 MensagensService::findByIdService()");
        return $this->mensagemDAO->findById($idMensagens);
    }

    public function updateService(int $idMensagens, stdClass $objPHP): Mensagens
    {
        error_log("🟣 MensagensService::updateService()");

        $mensagemExistente = $this->mensagemDAO->findById($idMensagens);

        if (!$mensagemExistente) {
            throw new ErrorResponse(
                404,
                "Mensagem não encontrada",
                ["message" => "Não existe mensagem com id {$idMensagens}"]
            );
        }

        $mensagemExistente->setTitulo($objPHP->mensagens->titulo);
        $mensagemExistente->setConteudo($objPHP->mensagens->conteudo);
        $mensagemExistente->setUsuarioId($objPHP->mensagens->usuarioId);
        $mensagemExistente->setDataPostagem($objPHP->mensagens->dataPostagem);

        $this->mensagemDAO->update($mensagemExistente);
        return $mensagemExistente;
    }

    public function deleteService(int $idMensagens): bool
    {
        error_log("🟣 MensagensService::deleteService()");

        $mensagemExistente = $this->mensagemDAO->findById($idMensagens);

        if (!$mensagemExistente) {
            throw new ErrorResponse(
                404,
                "Mensagem não encontrada",
                ["message" => "Não existe mensagem com id {$idMensagens}"]
            );
        }

        return $this->mensagemDAO->delete($mensagemExistente);
    }
}
