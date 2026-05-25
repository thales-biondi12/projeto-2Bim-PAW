<?php

namespace Api\Services;

use Api\Models\Mensagens;
use Api\Dao\MensagemDao;
<<<<<<< HEAD
use Api\Dao\UsuariosDao;
=======
>>>>>>> ddd022ee9a6055f2d71227862320bc73bcba8ce1
use Api\Http\ErrorResponse;
use stdClass;

class MensagensService
{
    private MensagemDao $mensagemDAO;
<<<<<<< HEAD
    private UsuariosDao $usuariosDAO;

    public function __construct(MensagemDao $mensagemDAODependency, UsuariosDao $usuariosDAODependency)
    {
        error_log("⬆️ MensagensService::__construct()");
        $this->mensagemDAO = $mensagemDAODependency;
        $this->usuariosDAO = $usuariosDAODependency;
=======

    public function __construct(MensagemDao $mensagemDAODependency)
    {
        error_log("⬆️ MensagensService::__construct()");
        $this->mensagemDAO = $mensagemDAODependency;
>>>>>>> ddd022ee9a6055f2d71227862320bc73bcba8ce1
    }

    public function createService(stdClass $objPHP): Mensagens
    {
        error_log("🟣 MensagensService::createService()");

        $mensagem = new Mensagens();
<<<<<<< HEAD
        $titulo = trim($objPHP->mensagens->titulo ?? '');
        $conteudo = trim($objPHP->mensagens->conteudo ?? '');
        $usuarioId = $objPHP->mensagens->usuarioId ?? null;
        $dataPostagem = $objPHP->mensagens->dataPostagem ?? null;

        if ($titulo === '') {
            throw new ErrorResponse(400, "Título inválido", ["message" => "O título da mensagem não pode ser vazio."]);
        }

        if ($conteudo === '') {
            throw new ErrorResponse(400, "Conteúdo inválido", ["message" => "O conteúdo da mensagem não pode ser vazio."]);
        }

        if (!$usuarioId || !$this->usuariosDAO->findById($usuarioId)) {
            throw new ErrorResponse(400, "Usuário não encontrado", ["message" => "O usuário com id {$usuarioId} não existe."]);
        }

        if (!$dataPostagem) {
            $dataPostagem = (new \DateTime())->format('Y-m-d');
        }

        $mensagem->setTitulo($titulo);
        $mensagem->setConteudo($conteudo);
        $mensagem->setUsuarioId($usuarioId);
        $mensagem->setDataPostagem($dataPostagem);
=======
        $mensagem->setTitulo($objPHP->mensagens->titulo);
        $mensagem->setConteudo($objPHP->mensagens->conteudo);
        $mensagem->setUsuarioId($objPHP->mensagens->usuarioId);
        $mensagem->setDataPostagem($objPHP->mensagens->dataPostagem);
>>>>>>> ddd022ee9a6055f2d71227862320bc73bcba8ce1

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

<<<<<<< HEAD
        $titulo = trim($objPHP->mensagens->titulo ?? '');
        $conteudo = trim($objPHP->mensagens->conteudo ?? '');
        $usuarioId = $objPHP->mensagens->usuarioId ?? null;
        $dataPostagem = $objPHP->mensagens->dataPostagem ?? null;

        if ($titulo === '') {
            throw new ErrorResponse(400, "Título inválido", ["message" => "O título da mensagem não pode ser vazio."]);
        }

        if ($conteudo === '') {
            throw new ErrorResponse(400, "Conteúdo inválido", ["message" => "O conteúdo da mensagem não pode ser vazio."]);
        }

        if (!$usuarioId || !$this->usuariosDAO->findById($usuarioId)) {
            throw new ErrorResponse(400, "Usuário não encontrado", ["message" => "O usuário com id {$usuarioId} não existe."]);
        }

        $mensagemExistente->setTitulo($titulo);
        $mensagemExistente->setConteudo($conteudo);
        $mensagemExistente->setUsuarioId($usuarioId);
        $mensagemExistente->setDataPostagem($dataPostagem);
=======
        $mensagemExistente->setTitulo($objPHP->mensagens->titulo);
        $mensagemExistente->setConteudo($objPHP->mensagens->conteudo);
        $mensagemExistente->setUsuarioId($objPHP->mensagens->usuarioId);
        $mensagemExistente->setDataPostagem($objPHP->mensagens->dataPostagem);
>>>>>>> ddd022ee9a6055f2d71227862320bc73bcba8ce1

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
