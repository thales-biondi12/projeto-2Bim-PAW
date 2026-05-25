<?php

namespace Api\Models;

use InvalidArgumentException;
use JsonSerializable;

class Ministerios implements JsonSerializable
{
    private int $idMinisterios;
    private string $nome = "";
    private string $descricao = "";
    private string $diaReuniao = "";
    private int $idCoordenador;

    public function getIdMinisterios(): ?int
    {
        return $this->idMinisterios;
    }

    public function setIdMinisterios(int $value): void
    {
        if ($value <= 0) {
            throw new InvalidArgumentException("idMinisterios deve ser maior que zero.");
        }

        $this->idMinisterios = $value;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $value): void
    {
        $nome = trim($value);

        if ($nome === '') {
            throw new InvalidArgumentException("nome nao pode ser vazio.");
        }

        if (mb_strlen($nome) < 3) {
            throw new InvalidArgumentException("nome deve ter pelo menos 3 caracteres.");
        }

        if (mb_strlen($nome) > 100) {
            throw new InvalidArgumentException("nome muito grande.");
        }

        $this->nome = $nome;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $value): void
    {
        $this->descricao = trim($value);
    }

    public function getDiaReuniao(): ?string
    {
        return $this->diaReuniao;
    }

    public function setDiaReuniao(string $value): void
    {
        $dia = trim($value);

        if ($dia === '') {
            throw new InvalidArgumentException("diaReuniao nao pode ser vazio.");
        }

        $this->diaReuniao = $dia;
    }

    public function getIdCoordenador(): ?int
    {
        return $this->idCoordenador;
    }

    public function setIdCoordenador(int $value): void
    {
        if ($value <= 0) {
            throw new InvalidArgumentException("idCoordenador deve ser maior que zero.");
        }

        $this->idCoordenador = $value;
    }

    public function jsonSerialize(): array
    {
        return [
            'idMinisterios' => $this->getIdMinisterios(),
            'nome' => $this->getNome(),
            'descricao' => $this->getDescricao(),
            'diaReuniao' => $this->getDiaReuniao(),
            'idCoordenador' => $this->getIdCoordenador()
        ];
    }
}
