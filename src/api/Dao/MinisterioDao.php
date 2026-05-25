<?php

namespace Api\Dao;

use Api\Models\Ministerios;
use Api\Database\MysqlDatabase;
use Exception;

/**
 * Classe responsável pelo acesso aos dados da entidade Ministérios.
 *
 * Camadas:
 * Controller -> Service -> DAO -> Banco de Dados
 *
 * Objetivo:
 * Centralizar todas as operações SQL relacionadas à tabela ministerios.
 */
class MinisterioDao
{
    /**
     * Instância de conexão com banco de dados.
     *
     * @var MysqlDatabase
     */
    private MysqlDatabase $database;

    /**
     * Recebe a conexão via injeção de dependência.
     *
     * @param MysqlDatabase $databaseInstance
     */
    public function __construct(MysqlDatabase $databaseInstance)
    {
        $this->database = $databaseInstance;
        error_log("⬆️ MinisterioDao::__construct()");
    }

    /**
     * Insere um novo ministério no banco.
     *
     * @param Ministerios $objMinisterios
     * @return Ministerios gerado
     * @throws Exception
     */
    public function create(Ministerios $objMinisterios): Ministerios
    {
        error_log("🟢 MinisterioDao::create()");

        /**
         * SQL de inserção.
         */
        $sql = "
            INSERT INTO ministerios (nome, descricao, dia_reuniao, id_coordenador)
            VALUES (:nome, :descricao, :dia_reuniao, :id_coordenador)
        ";

        /**
         * Valores da query.
         */
        $parametros = [
            ':nome' => $objMinisterios->getNome(),
            ':descricao' => $objMinisterios->getDescricao(),
            ':dia_reuniao' => $objMinisterios->getDiaReuniao(),
            ':id_coordenador' => $objMinisterios->getIdCoordenador()
        ];

        /**
         * Prepara e executa.
         */
        $stmt = $this->database->getConnection()->prepare($sql);

        if (!$stmt->execute($parametros)) {
            throw new Exception("Erro ao cadastrar ministério.");
        }

        /**
         * Retorna ID criado.
         */
        $novoID = (int) $this->database->getConnection()->lastInsertId();
        $objMinisterios->setIdMinisterios($novoID);
        return $objMinisterios;
    }

    /**
     * Remove um ministério pelo ID.
     *
     * @param Ministerios $objMinisteriosModel
     * @return bool
     */
    public function delete(Ministerios $objMinisteriosModel): bool
    {
        error_log("🟢 MinisterioDao::delete()");

        /**
         * SQL de exclusão.
         */
        $sql = "
            DELETE FROM ministerios
            WHERE id_ministerios = :id_ministerios
        ";

        /**
         * Valores da query.
         */
        $parametros = [
            ':id_ministerios' => $objMinisteriosModel->getIdMinisterios()
        ];

        /**
         * Executa exclusão.
         */
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute($parametros);

        /**
         * True se removeu registro.
         */
        return $stmt->rowCount() > 0;
    }

    /**
     * Atualiza um ministério existente.
     *
     * @param Ministerios $objMinisteriosModel
     * @return bool
     */
    public function update(Ministerios $objMinisteriosModel): bool
    {
        error_log("🟢 MinisterioDao::update()");

        /**
         * SQL de atualização.
         */
        $sql = "
            UPDATE ministerios
            SET nome = :nome, descricao = :descricao, dia_reuniao = :dia_reuniao, id_coordenador = :id_coordenador
            WHERE id_ministerios = :id_ministerios
        ";

        /**
         * Valores da query.
         */
        $parametros = [
            ':nome' => $objMinisteriosModel->getNome(),
            ':descricao' => $objMinisteriosModel->getDescricao(),
            ':dia_reuniao' => $objMinisteriosModel->getDiaReuniao(),
            ':id_coordenador' => $objMinisteriosModel->getIdCoordenador(),
            ':id_ministerios' => $objMinisteriosModel->getIdMinisterios()
        ];

        /**
         * Executa atualização.
         */
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute($parametros);

        /**
         * True se alterou registro.
         */
        return $stmt->rowCount() > 0;
    }

    /**
     * Retorna todos os ministérios cadastrados.
     *
     * @return array
     */
    public function findAll(): array
    {
        error_log("🟢 MinisterioDao::findAll()");

        /**
         * Consulta todos os registros.
         */
        $sql = "SELECT * FROM ministerios";

        /**
         * Executa consulta.
         */
        $stmt = $this->database->getConnection()->query($sql);

        /**
         * Matriz de arrays.
         */
        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        /**
         * Lista final de objetos Ministerios.
         */
        $ministerios = [];

        /**
         * Converte cada linha em objeto Ministerios.
         */
        foreach ($matrizArrays as $linhaMatriz) {
            $ministerio = new Ministerios();

            $ministerio->setIdMinisterios((int) $linhaMatriz['id_ministerios']);
            $ministerio->setNome($linhaMatriz['nome']);
            $ministerio->setDescricao($linhaMatriz['descricao'] ?? null);
            $ministerio->setDiaReuniao($linhaMatriz['dia_reuniao']);
            $ministerio->setIdCoordenador((int) $linhaMatriz['id_coordenador']);

            $ministerios[] = $ministerio;
        }

        /**
         * Retorna lista pronta.
         */
        return $ministerios;
    }

    /**
     * Retorna total de ministérios cadastrados.
     *
     * @return int
     */
    public function count(): int
    {
        error_log("🟢 MinisterioDao::count()");

        /**
         * SQL de contagem.
         */
        $sql = "SELECT COUNT(*) AS qtd FROM ministerios";

        /**
         * Executa consulta.
         */
        $stmt = $this->database->getConnection()->query($sql);

        /**
         * Resultado único.
         */
        $linhaMatriz = $stmt->fetch(\PDO::FETCH_ASSOC);

        /**
         * Retorna total.
         */
        return (int) $linhaMatriz['qtd'];
    }

    /**
     * Busca ministério pelo ID.
     *
     * @param int $idMinisterios
     * @return Ministerios|null
     */
    public function findById(int $idMinisterios): ?Ministerios
    {
        error_log("🟢 MinisterioDao::findById()");

        /**
         * Busca reutilizando método genérico.
         */
        $resultado = $this->findByField('id_ministerios', $idMinisterios);

        /**
         * Se encontrou registro.
         */
        if (!empty($resultado)) {
            return $resultado[0];
        }

        /**
         * Não encontrado.
         */
        return null;
    }

    /**
     * Busca por campo específico.
     *
     * @param string $field
     * @param mixed $value
     * @return array
     * @throws Exception
     */
    public function findByField(string $field, $value): array
    {
        error_log("🟢 MinisterioDao::findByField()");

        /**
         * Campos permitidos.
         */
        $camposPermitidos = [
            'id_ministerios',
            'nome',
            'descricao',
            'dia_reuniao',
            'id_coordenador'
        ];

        /**
         * Valida campo informado.
         */
        if (!in_array($field, $camposPermitidos)) {
            throw new Exception("Campo inválido.");
        }

        /**
         * SQL dinâmica segura.
         */
        $sql = "SELECT * FROM ministerios WHERE $field = :value";

        /**
         * Prepara consulta.
         */
        $stmt = $this->database->getConnection()->prepare($sql);

        /**
         * Executa busca.
         */
        $stmt->execute([
            ':value' => $value
        ]);

        /**
         * Matriz retornada.
         */
        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        /**
         * Lista final de objetos Ministerios.
         */
        $ministerios = [];

        /**
         * Converte linhas em objetos.
         */
        foreach ($matrizArrays as $linhaMatriz) {
            $ministerio = new Ministerios();

            $ministerio->setIdMinisterios((int) $linhaMatriz['id_ministerios']);
            $ministerio->setNome($linhaMatriz['nome']);
            $ministerio->setDescricao($linhaMatriz['descricao'] ?? null);
            $ministerio->setDiaReuniao($linhaMatriz['dia_reuniao']);
            $ministerio->setIdCoordenador((int) $linhaMatriz['id_coordenador']);

            $ministerios[] = $ministerio;
        }

        /**
         * Retorna lista.
         */
        return $ministerios;
    }
}
