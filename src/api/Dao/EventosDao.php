<?php

namespace Api\Dao;

use Api\Models\Eventos;
use Api\Database\MysqlDatabase;
use Exception;

/**
 * Classe responsável pelo acesso aos dados da entidade Eventos.
 *
 * Camadas:
 * Controller -> Service -> DAO -> Banco de Dados
 *
 * Objetivo:
 * Centralizar todas as operações SQL relacionadas à tabela eventos.
 */
class EventosDao
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

        error_log("⬆️ EventosDao::__construct()");
    }

    /**
     * Cadastra evento.
     *
     * @param Eventos $objEvento
     * @return Eventos
     * @throws Exception
     */
    public function create(Eventos $objEvento): Eventos
    {
        error_log("🟢 EventosDao::create()");

        $sql = "
            INSERT INTO eventos
            (
                titulo,
                descricao,
                data_evento,
                local_evento,
                limite_vagas,
                status_evento
            )
            VALUES
            (
                :titulo,
                :descricao,
                :data_evento,
                :local_evento,
                :limite_vagas,
                :status_evento
            )
        ";

        $parametros = [
            ':titulo' => $objEvento->getTitulo(),
            ':descricao' => $objEvento->getDescricao(),
            ':data_evento' => $objEvento->getDataEvento(),
            ':local_evento' => $objEvento->getLocalEvento(),
            ':limite_vagas' => $objEvento->getLimiteVagas(),
            ':status_evento' => $objEvento->getStatusEvento()
        ];

        $stmt = $this->database->getConnection()->prepare($sql);

        if (!$stmt->execute($parametros)) {
            throw new Exception("Erro ao cadastrar evento.");
        }

        $novoID = (int) $this->database->getConnection()->lastInsertId();

        $objEvento->setIdEvento($novoID);

        return $objEvento;
    }

    /**
     * Remove evento.
     *
     * @param Eventos $objEventoModel
     * @return bool
     */
    public function delete(Eventos $objEventoModel): bool
    {
        error_log("🟢 EventosDao::delete()");

        $sql = "
            DELETE FROM eventos
            WHERE id_evento = :id_evento
        ";

        $parametros = [
            ':id_evento' => $objEventoModel->getIdEvento()
        ];

        $stmt = $this->database->getConnection()->prepare($sql);

        $stmt->execute($parametros);

        return $stmt->rowCount() > 0;
    }

    /**
     * Atualiza evento.
     *
     * @param Eventos $objEventoModel
     * @return bool
     */
    public function update(Eventos $objEventoModel): bool
    {
        error_log("🟢 EventosDao::update()");

        $sql = "
            UPDATE eventos
            SET
                titulo = :titulo,
                descricao = :descricao,
                data_evento = :data_evento,
                local_evento = :local_evento,
                limite_vagas = :limite_vagas,
                status_evento = :status_evento
            WHERE id_evento = :id_evento
        ";

        $parametros = [
            ':titulo' => $objEventoModel->getTitulo(),
            ':descricao' => $objEventoModel->getDescricao(),
            ':data_evento' => $objEventoModel->getDataEvento(),
            ':local_evento' => $objEventoModel->getLocalEvento(),
            ':limite_vagas' => $objEventoModel->getLimiteVagas(),
            ':status_evento' => $objEventoModel->getStatusEvento(),
            ':id_evento' => $objEventoModel->getIdEvento()
        ];

        $stmt = $this->database->getConnection()->prepare($sql);

        $stmt->execute($parametros);

        return $stmt->rowCount() > 0;
    }

    /**
     * Lista todos os eventos.
     *
     * @return array
     */
    public function findAll(): array
    {
        error_log("🟢 EventosDao::findAll()");

        $sql = "SELECT * FROM eventos";

        $stmt = $this->database->getConnection()->query($sql);

        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $eventos = [];

        foreach ($matrizArrays as $linhaMatriz) {

            $evento = new Eventos();

            $evento->setIdEvento((int) $linhaMatriz['id_evento']);
            $evento->setTitulo($linhaMatriz['titulo']);
            $evento->setDescricao($linhaMatriz['descricao']);
            $evento->setDataEvento($linhaMatriz['data_evento']);
            $evento->setLocalEvento($linhaMatriz['local_evento']);
            $evento->setLimiteVagas((int) $linhaMatriz['limite_vagas']);
            $evento->setStatusEvento($linhaMatriz['status_evento']);

            $eventos[] = $evento;
        }

        return $eventos;
    }

    /**
     * Conta eventos.
     *
     * @return int
     */
    public function count(): int
    {
        error_log("🟢 EventosDao::count()");

        $sql = "SELECT COUNT(*) AS qtd FROM eventos";

        $stmt = $this->database->getConnection()->query($sql);

        $linhaMatriz = $stmt->fetch(\PDO::FETCH_ASSOC);

        return (int) $linhaMatriz['qtd'];
    }

    /**
     * Busca evento por ID.
     *
     * @param int $idEvento
     * @return Eventos|null
     */
    public function findById(int $idEvento): ?Eventos
    {
        error_log("🟢 EventosDao::findById()");

        $resultado = $this->findByField('id_evento', $idEvento);

        if (!empty($resultado)) {
            return $resultado[0];
        }

        return null;
    }

    /**
     * Busca evento por campo.
     *
     * @param string $field
     * @param mixed $value
     * @return array
     * @throws Exception
     */
    public function findByField(string $field, $value): array
    {
        error_log("🟢 EventosDao::findByField()");

        $camposPermitidos = [
            'id_evento',
            'titulo',
            'descricao',
            'data_evento',
            'local_evento',
            'limite_vagas',
            'status_evento'
        ];

        if (!in_array($field, $camposPermitidos)) {
            throw new Exception("Campo inválido.");
        }

        $sql = "SELECT * FROM eventos WHERE $field = :value";

        $stmt = $this->database->getConnection()->prepare($sql);

        $stmt->execute([
            ':value' => $value
        ]);

        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $eventos = [];

        foreach ($matrizArrays as $linhaMatriz) {

            $evento = new Eventos();

            $evento->setIdEvento((int) $linhaMatriz['id_evento']);
            $evento->setTitulo($linhaMatriz['titulo']);
            $evento->setDescricao($linhaMatriz['descricao']);
            $evento->setDataEvento($linhaMatriz['data_evento']);
            $evento->setLocalEvento($linhaMatriz['local_evento']);
            $evento->setLimiteVagas((int) $linhaMatriz['limite_vagas']);
            $evento->setStatusEvento($linhaMatriz['status_evento']);

            $eventos[] = $evento;
        }

        return $eventos;
    }
}
