<?php

namespace Api\Services;

use Api\Models\Ministerios;
use Api\Dao\MinisterioDao;
use Api\Dao\UsuariosDao;
use Api\Http\ErrorResponse;
use stdClass;

/**
 * Camada de regra de negócio da entidade Ministerios.
 *
 * Fluxo:
 * Controller -> Service -> DAO -> Banco
 */
class MinisteriosService
{
    /**
     * DAO responsável pelo acesso aos dados.
     *
     * @var MinisterioDao
     */
    private MinisterioDao $ministerioDAO;

    /**
     * DAO responsável pela validação de usuários.
     *
     * @var UsuariosDao
     */
    private UsuariosDao $usuariosDAO;

    /**
     * Injeção de dependência.
     *
     * @param MinisterioDao $ministerioDAODependency
     * @param UsuariosDao $usuariosDAODependency
     */
    public function __construct(MinisterioDao $ministerioDAODependency, UsuariosDao $usuariosDAODependency)
    {
        error_log("⬆️ MinisteriosService::__construct()");
        $this->ministerioDAO = $ministerioDAODependency;
        $this->usuariosDAO = $usuariosDAODependency;
    }

    /**
     * Valida se o coordenador existe no sistema.
     *
     * @param int $idCoordenador
     * @throws ErrorResponse
     */
<<<<<<< HEAD
        //dominio
=======
>>>>>>> ddd022ee9a6055f2d71227862320bc73bcba8ce1
    private function validateCoordinator(int $idCoordenador): void
    {
        if (!$this->usuariosDAO->findById($idCoordenador)) {
            throw new ErrorResponse(
                400,
                "Coordenador não encontrado",
                [
                    "message" => "O usuário com id {$idCoordenador} não existe. Verifique o id do coordenador."
                ]
            );
        }
    }

    /**
     * Cria um novo ministério.
     *
     * @param stdClass $objPHP
     * @return Ministerios
     * @throws ErrorResponse
     */
    public function createService(stdClass $objPHP): Ministerios
    {
        error_log("🟣 MinisteriosService::createService()");

        /**
         * Valida se o coordenador existe.
         */
        $this->validateCoordinator((int)$objPHP->ministerios->idCoordenador);

        $ministerio = new Ministerios();

        $ministerio->setNome($objPHP->ministerios->nome);
        $ministerio->setDescricao($objPHP->ministerios->descricao ?? null);
        $ministerio->setDiaReuniao($objPHP->ministerios->diaReuniao);
        $ministerio->setIdCoordenador($objPHP->ministerios->idCoordenador);

        /**
         * Verifica duplicidade de nome.
         */
        $resultado = $this->ministerioDAO->findByField(
            'nome',
            $ministerio->getNome()
        );

        if (count($resultado) > 0) {
            throw new ErrorResponse(
                400,
                "Ministério já existe",
                [
                    "message" =>
                        "O ministério {$ministerio->getNome()} já está cadastrado"
                ]
            );
        }

        return $this->ministerioDAO->create($ministerio);
    }

    /**
     * Retorna quantidade total.
     *
     * @return int
     */
    public function countService(): int
    {
        error_log("🟣 MinisteriosService::countService()");
        return $this->ministerioDAO->count();
    }

    /**
     * Lista todos os ministérios.
     *
     * @return array
     */
    public function findAllService(): array
    {
        error_log("🟣 MinisteriosService::findAllService()");
        return $this->ministerioDAO->findAll();
    }

    /**
     * Busca ministério por ID.
     *
     * @param int $idMinisterio
     * @return Ministerios|null
     */
    public function findByIdService(int $idMinisterio): ?Ministerios
    {
        error_log("🟣 MinisteriosService::findByIdService()");

        return $this->ministerioDAO->findById($idMinisterio);
    }

    /**
     * Atualiza ministério existente.
     *
     * @param int $idMinisterio
     * @param stdClass $objPHP
     * @return Ministerios
     * @throws ErrorResponse
     */
    public function updateService(int $idMinisterio, stdClass $objPHP): Ministerios
    {
        error_log("🟣 MinisteriosService::updateService()");

        /**
         * Valida se o coordenador existe.
         */
        $this->validateCoordinator((int)$objPHP->ministerios->idCoordenador);

        /**
         * Verifica existência.
         */
        $ministerioExistente = $this->ministerioDAO->findById($idMinisterio);

        if (!$ministerioExistente) {
            throw new ErrorResponse(
                404,
                "Ministério não encontrado",
                [
                    "message" =>
                        "Não existe ministério com id {$idMinisterio}"
                ]
            );
        }

        /**
         * Atualiza dados.
         */
        $ministerioExistente->setNome($objPHP->ministerios->nome);
        $ministerioExistente->setDescricao($objPHP->ministerios->descricao ?? null);
        $ministerioExistente->setDiaReuniao($objPHP->ministerios->diaReuniao);
        $ministerioExistente->setIdCoordenador($objPHP->ministerios->idCoordenador);

        $this->ministerioDAO->update($ministerioExistente);

        return $ministerioExistente;
    }

    /**
     * Remove ministério existente.
     *
     * @param int $idMinisterio
     * @return bool
     * @throws ErrorResponse
     */
    public function deleteService(int $idMinisterio): bool
    {
        error_log("🟣 MinisteriosService::deleteService()");

        /**
         * Verifica existência.
         */
        $ministerioExistente = $this->ministerioDAO->findById($idMinisterio);

        if (!$ministerioExistente) {
            throw new ErrorResponse(
                404,
                "Ministério não encontrado",
                [
                    "message" =>
                        "Não existe ministério com id {$idMinisterio}"
                ]
            );
        }

        return $this->ministerioDAO->delete($ministerioExistente);
    }
}
