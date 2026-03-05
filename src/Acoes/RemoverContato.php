<?php

class RemoverContato implements AcaoInterface
{
    public function __construct(
        private Menu $menu,
        private ContatoRepository $repository,
    ) {}

    public function executar(): void
    {
        $this->menu->mensagem("\n--- Remover Contato ---\n");

        if ($this->repository->total() === 0) {
            $this->menu->mensagem("Nenhum contato cadastrado.\n");
            return;
        }

        $id = (int) $this->menu->lerEntrada("Digite o ID do contato: ");
        $contato = $this->repository->buscarPorId($id);

        if ($contato === null) {
            $this->menu->mensagem("Contato com ID $id não encontrado.\n");
            return;
        }

        $confirmacao = $this->menu->lerEntrada("Tem certeza que deseja remover \"{$contato->getNome()}\"? (s/n): ");

        if (strtolower($confirmacao) === 's') {
            $this->repository->remover($id);
            $this->menu->mensagem("Contato removido com sucesso!\n");
        } else {
            $this->menu->mensagem("Remoção cancelada.\n");
        }
    }
}
