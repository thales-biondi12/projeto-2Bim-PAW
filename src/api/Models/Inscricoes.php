<?php

namespace Api\Models;

use InvalidArgumentException;
use JsonSerializable;

class Inscricoes implements JsonSerializable
{
    private ?int $idInscricoes = null;
    private ?int $usuarioId = null;
    private ?int $eventoId = null;
    private string $dataInscricao = "";
    private string $presenca = "";

    public function getIdInscricoes(): ?int
    {
        return $this->idInscricoes;
    }

    public function setIdInscricoes(int $value): void
    {
        if ($value <= 0) {
            throw new InvalidArgumentException("idInscricoes deve ser maior que zero.");
        }

        $this->idInscricoes = $value;
    }

    public function getUsuarioId(): ?int
    {
        return $this->usuarioId;
    }

    public function setUsuarioId(int $value): void
    {
        if ($value <= 0) {
            throw new InvalidArgumentException("usuarioId deve ser maior que zero.");
        }

        $this->usuarioId = $value;
    }

    public function getEventoId(): ?int
    {
        return $this->eventoId;
    }

    public function setEventoId(int $value): void
    {
        if ($value <= 0) {
            throw new InvalidArgumentException("eventoId deve ser maior que zero.");
        }

        $this->eventoId = $value;
    }

    public function getDataInscricao(): ?string
    {
        return $this->dataInscricao;
    }

    public function setDataInscricao(string $value): void
    {
        $data = trim($value);

        if ($data === '') {
            throw new InvalidArgumentException("dataInscricao nao pode ser vazia.");
        }

        $this->dataInscricao = $data;
    }

    public function getPresenca(): ?string
    {
        return $this->presenca;
    }

    public function setPresenca(string $value): void
    {
        $presenca = trim($value);

        if ($presenca === '') {
            throw new InvalidArgumentException("presenca nao pode ser vazia.");
        }

        $this->presenca = $presenca;
    }

    public function jsonSerialize(): array
    {
        return [
            'idInscricoes' => $this->getIdInscricoes(),
            'usuarioId' => $this->getUsuarioId(),
            'eventoId' => $this->getEventoId(),
            'dataInscricao' => $this->getDataInscricao(),
            'presenca' => $this->getPresenca()
        ];
    }
}
