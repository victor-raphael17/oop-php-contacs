<?php

class ContatoRepository
{
    /** @var Contato[] */
    private array $contatos = [];
    private int $contadorId = 1;

    public function __construct(private string $arquivo)
    {
        $this->carregar();
    }

    private function carregar(): void
    {
        if (!file_exists($this->arquivo)) {
            return;
        }

        $json = file_get_contents($this->arquivo);
        $dados = json_decode($json, true);

        if (!is_array($dados)) {
            return;
        }

        foreach ($dados as $item) {
            $this->contatos[] = Contato::fromArray($item);
        }

        if (!empty($this->contatos)) {
            $ids = array_map(fn(Contato $c) => $c->getId(), $this->contatos);
            $this->contadorId = max($ids) + 1;
        }
    }

    public function salvar(): void
    {
        $dados = array_map(fn(Contato $c) => $c->toArray(), $this->contatos);
        $json = json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($this->arquivo, $json);
    }

    public function adicionar(string $nome, string $email, string $telefone, int $idade): Contato
    {
        $contato = new Contato(
            id: $this->contadorId++,
            nome: $nome,
            email: $email,
            telefone: $telefone,
            idade: $idade,
        );

        $this->contatos[] = $contato;
        $this->salvar();

        return $contato;
    }

    public function buscarPorId(int $id): ?Contato
    {
        foreach ($this->contatos as $contato) {
            if ($contato->getId() === $id) {
                return $contato;
            }
        }

        return null;
    }

    /**
     * @return Contato[]
     */
    public function buscarPorNome(string $termo): array
    {
        $termoLower = strtolower($termo);

        return array_values(array_filter(
            $this->contatos,
            fn(Contato $c) => str_contains(strtolower($c->getNome()), $termoLower)
        ));
    }

    public function remover(int $id): bool
    {
        foreach ($this->contatos as $i => $contato) {
            if ($contato->getId() === $id) {
                unset($this->contatos[$i]);
                $this->contatos = array_values($this->contatos);
                $this->salvar();
                return true;
            }
        }

        return false;
    }

    /**
     * @return Contato[]
     */
    public function listarOrdenado(): array
    {
        $contatos = $this->contatos;

        usort($contatos, fn(Contato $a, Contato $b) =>
            strcmp(strtolower($a->getNome()), strtolower($b->getNome()))
        );

        return $contatos;
    }

    public function total(): int
    {
        return count($this->contatos);
    }

    public function totalAtivos(): int
    {
        return count(array_filter(
            $this->contatos,
            fn(Contato $c) => $c->isAtivo()
        ));
    }

    public function mediaIdade(): float
    {
        if ($this->total() === 0) {
            return 0.0;
        }

        $soma = array_sum(array_map(
            fn(Contato $c) => $c->getIdade(),
            $this->contatos
        ));

        return $soma / $this->total();
    }
}
