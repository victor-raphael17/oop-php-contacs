<?php

class BuscarContato implements AcaoInterface
{
    public function __construct(
        private Menu $menu,
        private ContatoRepository $repository,
    ) {}

    public function executar(): void
    {
        $this->menu->mensagem("\n--- Buscar Contato ---\n");

        if ($this->repository->total() === 0) {
            $this->menu->mensagem("Nenhum contato cadastrado.\n");
            return;
        }

        $termo = $this->menu->lerEntrada("Digite o nome para busca: ");
        if ($termo === '') {
            $this->menu->mensagem("Termo de busca não pode ser vazio.\n");
            return;
        }

        $resultados = $this->repository->buscarPorNome($termo);

        if (count($resultados) === 0) {
            $this->menu->mensagem("Nenhum contato encontrado para \"$termo\".\n");
            return;
        }

        $this->menu->mensagem(count($resultados) . " contato(s) encontrado(s):\n");

        foreach ($resultados as $contato) {
            $this->menu->exibirContato($contato);
        }
    }
}
