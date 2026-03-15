<?php

class DeleteContact implements ActionInterface
{
    public function __construct(
        private Menu $menu,
        private ContactRepository $repository,
    ) {}

    public function execute(): void
    {
        $this->menu->message("\n--- Delete Contact ---\n");

        if ($this->repository->total() === 0) {
            $this->menu->message("No contacts registered.\n");
            return;
        }

        $id = (int) $this->menu->readInput("Enter contact ID: ");
        $contact = $this->repository->findById($id);

        if ($contact === null) {
            $this->menu->message("Contact with ID $id not found.\n");
            return;
        }

        $confirmation = $this->menu->readInput("Are you sure you want to delete \"{$contact->getName()}\"? (y/n): ");

        if (strtolower($confirmation) === 'y') {
            $this->repository->remove($id);
            $this->menu->message("Contact deleted successfully!\n");
        } else {
            $this->menu->message("Deletion cancelled.\n");
        }
    }
}
