<?php

class Menu
{
    public function exibir(): void
    {
        echo "\n";
        echo "========================================\n";
        echo "   GERENCIAMENTO DE CONTATOS\n";
        echo "========================================\n";
        echo " [1] Cadastrar contato\n";
        echo " [2] Listar contatos\n";
        echo " [3] Buscar contato\n";
        echo " [4] Editar contato\n";
        echo " [5] Remover contato\n";
        echo " [6] Estatísticas\n";
        echo " [0] Sair\n";
        echo "========================================\n";
    }

    public function lerEntrada(string $mensagem): string
    {
        return trim(readline($mensagem));
    }

    public function exibirContato(Contato $contato): void
    {
        $status = $contato->isAtivo() ? 'Ativo' : 'Inativo';
        $nome = ucwords(strtolower($contato->getNome()));

        echo "ID: {$contato->getId()} | Nome: $nome | Email: {$contato->getEmail()} | Tel: {$contato->getTelefone()} | Idade: {$contato->getIdade()} | Status: $status\n";
    }

    public function mensagem(string $texto): void
    {
        echo $texto;
    }
}
