<?php

class ListarContatos implements AcaoInterface
{
    public function __construct(
        private Menu $menu,
        private ContatoRepository $repository,
    ) {}

    public function executar(): void
    {
        $this->menu->mensagem("\n--- Lista de Contatos ---\n");

        if ($this->repository->total() === 0) {
            $this->menu->mensagem("Nenhum contato cadastrado.\n");
            return;
        }

        foreach ($this->repository->listarOrdenado() as $contato) {
            $this->menu->exibirContato($contato);
        }

        $this->menu->mensagem("Total: {$this->repository->total()} contato(s)\n");
    }
}
