<?php

class Contato
{
    public function __construct(
        private int $id,
        private string $nome,
        private string $email,
        private string $telefone,
        private int $idade,
        private bool $ativo = true,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getTelefone(): string
    {
        return $this->telefone;
    }

    public function setTelefone(string $telefone): void
    {
        $this->telefone = $telefone;
    }

    public function getIdade(): int
    {
        return $this->idade;
    }

    public function setIdade(int $idade): void
    {
        $this->idade = $idade;
    }

    public function isAtivo(): bool
    {
        return $this->ativo;
    }

    public function setAtivo(bool $ativo): void
    {
        $this->ativo = $ativo;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'email' => $this->email,
            'telefone' => $this->telefone,
            'idade' => $this->idade,
            'ativo' => $this->ativo,
        ];
    }

    public static function fromArray(array $dados): self
    {
        return new self(
            id: $dados['id'],
            nome: $dados['nome'],
            email: $dados['email'],
            telefone: $dados['telefone'],
            idade: $dados['idade'],
            ativo: $dados['ativo'],
        );
    }
}
