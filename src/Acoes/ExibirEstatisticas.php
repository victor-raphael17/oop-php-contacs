<?php

class ExibirEstatisticas implements AcaoInterface
{
    public function __construct(
        private Menu $menu,
        private ContatoRepository $repository,
    ) {}

    public function executar(): void
    {
        $this->menu->mensagem("\n--- Estatísticas ---\n");

        $total = $this->repository->total();

        if ($total === 0) {
            $this->menu->mensagem("Nenhum contato cadastrado.\n");
            return;
        }

        $ativos = $this->repository->totalAtivos();
        $inativos = $total - $ativos;
        $media = number_format($this->repository->mediaIdade(), 1);

        $this->menu->mensagem("Total de contatos: $total\n");
        $this->menu->mensagem("Ativos: $ativos\n");
        $this->menu->mensagem("Inativos: $inativos\n");
        $this->menu->mensagem("Média de idade: $media\n");
    }
}
