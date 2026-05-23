<?php

namespace Api\Models;

use InvalidArgumentException;
use JsonSerializable;

class Eventos implements JsonSerializable
{
    private int $idEvento;
    private string $titulo = "";
    private string $descricao = "";
    private string $dataEvento = "";
    private string $localEvento = "";
    private int $limiteVagas;
    private string $statusEvento = "";

    public function getIdEvento(): ?int
    {
        return $this->idEvento;
    }

    public function setIdEvento(int $value): void
    {
        if ($value <= 0) {
            throw new InvalidArgumentException("idEvento deve ser maior que zero.");
        }

        $this->idEvento = $value;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $value): void
    {
        $titulo = trim($value);

        if ($titulo === '') {
            throw new InvalidArgumentException("titulo nao pode ser vazio.");
        }

        if (mb_strlen($titulo) < 3) {
            throw new InvalidArgumentException("titulo deve ter pelo menos 3 caracteres.");
        }

        if (mb_strlen($titulo) > 100) {
            throw new InvalidArgumentException("titulo muito grande.");
        }

        $this->titulo = $titulo;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $value): void
    {
        $descricao = trim($value);

        if ($descricao === '') {
            throw new InvalidArgumentException("descricao nao pode ser vazia.");
        }

        $this->descricao = $descricao;
    }

    public function getDataEvento(): ?string
    {
        return $this->dataEvento;
    }

    public function setDataEvento(string $value): void
    {
        $data = trim($value);

        if ($data === '') {
            throw new InvalidArgumentException("dataEvento nao pode ser vazia.");
        }

        $this->dataEvento = $data;
    }

    public function getLocalEvento(): ?string
    {
        return $this->localEvento;
    }

    public function setLocalEvento(string $value): void
    {
        $local = trim($value);

        if ($local === '') {
            throw new InvalidArgumentException("localEvento nao pode ser vazio.");
        }

        $this->localEvento = $local;
    }

    public function getLimiteVagas(): ?int
    {
        return $this->limiteVagas;
    }

    public function setLimiteVagas(int $value): void
    {
        if ($value < 0) {
            throw new InvalidArgumentException("limiteVagas nao pode ser negativo.");
        }

        $this->limiteVagas = $value;
    }

    public function getStatusEvento(): ?string
    {
        return $this->statusEvento;
    }

    public function setStatusEvento(string $value): void
    {
        $status = trim($value);

        if ($status === '') {
            throw new InvalidArgumentException("statusEvento nao pode ser vazio.");
        }

        $this->statusEvento = $status;
    }

    public function jsonSerialize(): array
    {
        return [
            'idEvento' => $this->getIdEvento(),
            'titulo' => $this->getTitulo(),
            'descricao' => $this->getDescricao(),
            'dataEvento' => $this->getDataEvento(),
            'localEvento' => $this->getLocalEvento(),
            'limiteVagas' => $this->getLimiteVagas(),
            'statusEvento' => $this->getStatusEvento()
        ];
    }
}
