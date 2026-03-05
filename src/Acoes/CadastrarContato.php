<?php

class CadastrarContato implements AcaoInterface
{
    public function __construct(
        private Menu $menu,
        private ContatoRepository $repository,
    ) {}

    public function executar(): void
    {
        $this->menu->mensagem("\n--- Cadastrar Contato ---\n");

        $nome = $this->menu->lerEntrada("Nome: ");
        if (!Validador::validarNome($nome)) {
            $this->menu->mensagem("Nome não pode ser vazio.\n");
            return;
        }

        $email = $this->menu->lerEntrada("Email: ");
        if (!Validador::validarEmail($email)) {
            $this->menu->mensagem("Email inválido. Deve conter '@' e ter pelo menos 5 caracteres.\n");
            return;
        }

        $telefone = $this->menu->lerEntrada("Telefone: ");
        if (!Validador::validarTelefone($telefone)) {
            $this->menu->mensagem("Telefone não pode ser vazio.\n");
            return;
        }

        $idade = (int) $this->menu->lerEntrada("Idade: ");
        if (!Validador::validarIdade($idade)) {
            $this->menu->mensagem("Idade inválida.\n");
            return;
        }

        $contato = $this->repository->adicionar($nome, $email, $telefone, $idade);
        $this->menu->mensagem("Contato cadastrado com sucesso! (ID: {$contato->getId()})\n");
    }
}
