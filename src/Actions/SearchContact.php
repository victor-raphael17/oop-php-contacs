<?php

class SearchContact implements ActionInterface
{
    public function __construct(
        private Menu $menu,
        private ContactRepository $repository,
    ) {}

    public function execute(): void
    {
        $this->menu->message("\n--- Search Contact ---\n");

        if ($this->repository->total() === 0) {
            $this->menu->message("No contacts registered.\n");
            return;
        }

        $term = $this->menu->readInput("Enter name to search: ");
        if ($term === '') {
            $this->menu->message("Search term cannot be empty.\n");
            return;
        }

        $results = $this->repository->searchByName($term);

        if (count($results) === 0) {
            $this->menu->message("No contacts found for \"$term\".\n");
            return;
        }

        $this->menu->message(count($results) . " contact(s) found:\n");

        foreach ($results as $contact) {
            $this->menu->displayContact($contact);
        }
    }
}
