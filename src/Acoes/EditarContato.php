<?php

class EditarContato implements AcaoInterface
{
    public function __construct(
        private Menu $menu,
        private ContatoRepository $repository,
    ) {}

    public function executar(): void
    {
        $this->menu->mensagem("\n--- Editar Contato ---\n");

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

        $this->menu->mensagem("Editando: {$contato->getNome()} (pressione Enter para manter o valor atual)\n");

        $nome = $this->menu->lerEntrada("Nome [{$contato->getNome()}]: ");
        if ($nome !== '') {
            $contato->setNome($nome);
        }

        $email = $this->menu->lerEntrada("Email [{$contato->getEmail()}]: ");
        if ($email !== '') {
            if (!Validador::validarEmail($email)) {
                $this->menu->mensagem("Email inválido. Campo não alterado.\n");
            } else {
                $contato->setEmail($email);
            }
        }

        $telefone = $this->menu->lerEntrada("Telefone [{$contato->getTelefone()}]: ");
        if ($telefone !== '') {
            $contato->setTelefone($telefone);
        }

        $idade = $this->menu->lerEntrada("Idade [{$contato->getIdade()}]: ");
        if ($idade !== '') {
            $idade = (int) $idade;
            if (Validador::validarIdade($idade)) {
                $contato->setIdade($idade);
            } else {
                $this->menu->mensagem("Idade inválida. Campo não alterado.\n");
            }
        }

        $statusAtual = $contato->isAtivo() ? 'Ativo' : 'Inativo';
        $ativo = $this->menu->lerEntrada("Status (1=Ativo, 0=Inativo) [$statusAtual]: ");
        if ($ativo !== '') {
            $contato->setAtivo($ativo === '1');
        }

        $this->repository->salvar();
        $this->menu->mensagem("Contato atualizado com sucesso!\n");
    }
}
