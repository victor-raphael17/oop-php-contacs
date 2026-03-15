<?php

class ListContacts implements ActionInterface
{
    public function __construct(
        private Menu $menu,
        private ContactRepository $repository,
    ) {}

    public function execute(): void
    {
        $this->menu->message("\n--- Contact List ---\n");

        if ($this->repository->total() === 0) {
            $this->menu->message("No contacts registered.\n");
            return;
        }

        foreach ($this->repository->listSorted() as $contact) {
            $this->menu->displayContact($contact);
        }

        $this->menu->message("Total: {$this->repository->total()} contact(s)\n");
    }
}
