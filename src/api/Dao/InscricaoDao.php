<?php

namespace Api\Dao;

use Api\Models\Inscricoes;
use Api\Database\MysqlDatabase;
use Exception;

/**
 * Classe responsável pelo acesso aos dados da entidade Inscrições.
 *
 * Camadas:
 * Controller -> Service -> DAO -> Banco de Dados
 *
 * Objetivo:
 * Centralizar todas as operações SQL relacionadas à tabela inscricoes.
 */
class InscricaoDao
{
    /**
     * Instância do banco.
     *
     * @var MysqlDatabase
     */
    private MysqlDatabase $database;

    /**
     * Construtor.
     *
     * @param MysqlDatabase $databaseInstance
     */
    public function __construct(MysqlDatabase $databaseInstance)
    {
        $this->database = $databaseInstance;

        error_log("⬆️ InscricaoDao::__construct()");
    }

    /**
     * Cadastra inscrição.
     *
     * @param Inscricoes $objInscricao
     * @return Inscricoes
     * @throws Exception
     */
    public function create(Inscricoes $objInscricao): Inscricoes
    {
        error_log("🟢 InscricaoDao::create()");

        $sql = "
            INSERT INTO inscricoes
            (
                usuario_id,
                evento_id,
                data_inscricao,
                presenca
            )
            VALUES
            (
                :usuario_id,
                :evento_id,
                :data_inscricao,
                :presenca
            )
        ";

        $parametros = [
            ':usuario_id' => $objInscricao->getUsuarioId(),
            ':evento_id' => $objInscricao->getEventoId(),
            ':data_inscricao' => $objInscricao->getDataInscricao(),
            ':presenca' => $objInscricao->getPresenca()
        ];

        //compila o sql antes de inserir os dados previnindo SQL Injection
        $stmt = $this->database->getConnection()->prepare($sql);

        if (!$stmt->execute($parametros)) {
            throw new Exception("Erro ao cadastrar inscrição.");
        }

        $novoID = (int) $this->database->getConnection()->lastInsertId();

        $objInscricao->setIdInscricoes($novoID);

        return $objInscricao;
    }

    /**
     * Remove inscrição.
     *
     * @param Inscricoes $objInscricaoModel
     * @return bool
     */
    public function delete(Inscricoes $objInscricaoModel): bool
    {
        error_log("🟢 InscricaoDao::delete()");

        $sql = "
            DELETE FROM inscricoes
            WHERE id_inscricoes = :id_inscricoes
        ";

        $parametros = [
            ':id_inscricoes' => $objInscricaoModel->getIdInscricoes()
        ];

        $stmt = $this->database->getConnection()->prepare($sql);

        $stmt->execute($parametros);

        return $stmt->rowCount() > 0;
    }

    /**
     * Atualiza inscrição.
     *
     * @param Inscricoes $objInscricaoModel
     * @return bool
     */
    public function update(Inscricoes $objInscricaoModel): bool
    {
        error_log("🟢 InscricaoDao::update()");

        $sql = "
            UPDATE inscricoes
            SET
                usuario_id = :usuario_id,
                evento_id = :evento_id,
                data_inscricao = :data_inscricao,
                presenca = :presenca
            WHERE id_inscricoes = :id_inscricoes
        ";

        $parametros = [
            ':usuario_id' => $objInscricaoModel->getUsuarioId(),
            ':evento_id' => $objInscricaoModel->getEventoId(),
            ':data_inscricao' => $objInscricaoModel->getDataInscricao(),
            ':presenca' => $objInscricaoModel->getPresenca(),
            ':id_inscricoes' => $objInscricaoModel->getIdInscricoes()
        ];

        $stmt = $this->database->getConnection()->prepare($sql);

        $stmt->execute($parametros);

        return $stmt->rowCount() > 0;
    }

    /**
     * Lista todas as inscrições.
     *
     * @return array
     */
    public function findAll(): array
    {
        error_log("🟢 InscricaoDao::findAll()");

        $sql = "SELECT * FROM inscricoes";

        $stmt = $this->database->getConnection()->query($sql);

        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $inscricoes = [];

        foreach ($matrizArrays as $linhaMatriz) {

            $inscricao = new Inscricoes();

            $inscricao->setIdInscricoes((int) $linhaMatriz['id_inscricoes']);
            $inscricao->setUsuarioId((int) $linhaMatriz['usuario_id']);
            $inscricao->setEventoId((int) $linhaMatriz['evento_id']);
            $inscricao->setDataInscricao($linhaMatriz['data_inscricao']);
            $inscricao->setPresenca($linhaMatriz['presenca']);

            $inscricoes[] = $inscricao;
        }

        return $inscricoes;
    }

    /**
     * Conta inscrições.
     *
     * @return int
     */
    public function count(): int
    {
        error_log("🟢 InscricaoDao::count()");

        $sql = "SELECT COUNT(*) AS qtd FROM inscricoes";

        $stmt = $this->database->getConnection()->query($sql);

        $linhaMatriz = $stmt->fetch(\PDO::FETCH_ASSOC);

        return (int) $linhaMatriz['qtd'];
    }

    /**
     * Busca inscrição por ID.
     *
     * @param int $idInscricoes
     * @return Inscricoes|null
     */
    public function findById(int $idInscricoes): ?Inscricoes
    {
        error_log("🟢 InscricaoDao::findById()");

        $resultado = $this->findByField('id_inscricoes', $idInscricoes);

        if (!empty($resultado)) {
            return $resultado[0];
        }

        return null;
    }

    /**
     * Busca inscrição por campo.
     *
     * @param string $field
     * @param mixed $value
     * @return array
     * @throws Exception
     */
    public function findByField(string $field, $value): array
    {
        error_log("🟢 InscricaoDao::findByField()");

        $camposPermitidos = [
            'id_inscricoes',
            'usuario_id',
            'evento_id',
            'data_inscricao',
            'presenca'
        ];

        if (!in_array($field, $camposPermitidos)) {
            throw new Exception("Campo inválido.");
        }

        $sql = "SELECT * FROM inscricoes WHERE $field = :value";

        $stmt = $this->database->getConnection()->prepare($sql);

        $stmt->execute([
            ':value' => $value
        ]);

        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $inscricoes = [];

        foreach ($matrizArrays as $linhaMatriz) {

            $inscricao = new Inscricoes();

            $inscricao->setIdInscricoes((int) $linhaMatriz['id_inscricoes']);
            $inscricao->setUsuarioId((int) $linhaMatriz['usuario_id']);
            $inscricao->setEventoId((int) $linhaMatriz['evento_id']);
            $inscricao->setDataInscricao($linhaMatriz['data_inscricao']);
            $inscricao->setPresenca($linhaMatriz['presenca']);

            $inscricoes[] = $inscricao;
        }

        return $inscricoes;
    }
}
