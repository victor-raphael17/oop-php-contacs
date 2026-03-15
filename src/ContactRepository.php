<?php

class ContactRepository
{
    /** @var Contact[] */
    private array $contacts = [];
    private int $idCounter = 1;

    public function __construct(private string $file)
    {
        $this->load();
    }

    private function load(): void
    {
        if (!file_exists($this->file)) {
            return;
        }

        $json = file_get_contents($this->file);
        $data = json_decode($json, true);

        if (!is_array($data)) {
            return;
        }

        foreach ($data as $item) {
            $this->contacts[] = Contact::fromArray($item);
        }

        if (!empty($this->contacts)) {
            $ids = array_map(fn(Contact $c) => $c->getId(), $this->contacts);
            $this->idCounter = max($ids) + 1;
        }
    }

    public function save(): void
    {
        $data = array_map(fn(Contact $c) => $c->toArray(), $this->contacts);
        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($this->file, $json);
    }

    public function add(string $name, string $email, string $phone, int $age): Contact
    {
        $contact = new Contact(
            id: $this->idCounter++,
            name: $name,
            email: $email,
            phone: $phone,
            age: $age,
        );

        $this->contacts[] = $contact;
        $this->save();

        return $contact;
    }

    public function findById(int $id): ?Contact
    {
        foreach ($this->contacts as $contact) {
            if ($contact->getId() === $id) {
                return $contact;
            }
        }

        return null;
    }

    /**
     * @return Contact[]
     */
    public function searchByName(string $term): array
    {
        $termLower = strtolower($term);

        return array_values(array_filter(
            $this->contacts,
            fn(Contact $c) => str_contains(strtolower($c->getName()), $termLower)
        ));
    }

    public function remove(int $id): bool
    {
        foreach ($this->contacts as $i => $contact) {
            if ($contact->getId() === $id) {
                unset($this->contacts[$i]);
                $this->contacts = array_values($this->contacts);
                $this->save();
                return true;
            }
        }

        return false;
    }

    /**
     * @return Contact[]
     */
    public function listSorted(): array
    {
        $contacts = $this->contacts;

        usort($contacts, fn(Contact $a, Contact $b) =>
            strcmp(strtolower($a->getName()), strtolower($b->getName()))
        );

        return $contacts;
    }

    public function total(): int
    {
        return count($this->contacts);
    }

    public function totalActive(): int
    {
        return count(array_filter(
            $this->contacts,
            fn(Contact $c) => $c->isActive()
        ));
    }

    public function averageAge(): float
    {
        if ($this->total() === 0) {
            return 0.0;
        }

        $sum = array_sum(array_map(
            fn(Contact $c) => $c->getAge(),
            $this->contacts
        ));

        return $sum / $this->total();
    }
}
