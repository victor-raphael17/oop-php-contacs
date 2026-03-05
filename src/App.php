<?php

class App
{
    private Menu $menu;
    /** @var array<string, AcaoInterface> */
    private array $acoes;

    public function __construct(string $arquivoContatos)
    {
        $this->menu = new Menu();
        $repository = new ContatoRepository($arquivoContatos);

        $this->acoes = [
            '1' => new CadastrarContato($this->menu, $repository),
            '2' => new ListarContatos($this->menu, $repository),
            '3' => new BuscarContato($this->menu, $repository),
            '4' => new EditarContato($this->menu, $repository),
            '5' => new RemoverContato($this->menu, $repository),
            '6' => new ExibirEstatisticas($this->menu, $repository),
        ];
    }

    public function executar(): void
    {
        $this->menu->mensagem("Bem-vindo ao Sistema de Gerenciamento de Contatos!\n");

        while (true) {
            $this->menu->exibir();
            $opcao = $this->menu->lerEntrada("Escolha uma opção: ");

            if ($opcao === '0') {
                $this->menu->mensagem("\nObrigado por usar o sistema. Até logo!\n");
                exit(0);
            }

            if (isset($this->acoes[$opcao])) {
                $this->acoes[$opcao]->executar();
            } else {
                $this->menu->mensagem("Opção inválida. Tente novamente.\n");
            }
        }
    }
}
