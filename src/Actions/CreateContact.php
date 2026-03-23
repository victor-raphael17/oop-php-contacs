<?php

class CreateContact implements ActionInterface
{
    public function __construct(
        private Menu $menu,
        private ContactRepository $repository,
    ) {}

    public function execute(): void
    {
        $this->menu->message("\n--- Create Contact ---\n");

        $name = $this->menu->readInput("Name: ");
        if (!Validator::validateName($name)) {
            $this->menu->message("Name cannot be empty.\n");
            return;
        }

        $email = $this->menu->readInput("Email: ");
        if (!Validator::validateEmail($email)) {
            $this->menu->message("Invalid email.\n");
            return;
        }

        $phone = $this->menu->readInput("Phone: ");
        if (!Validator::validatePhone($phone)) {
            $this->menu->message("Phone cannot be empty.\n");
            return;
        }

        $age = Validator::validateAgeInput($this->menu->readInput("Age: "));
        if ($age === null) {
            $this->menu->message("Invalid age. Must be a number between 1 and 150.\n");
            return;
        }

        $contact = $this->repository->add($name, $email, $phone, $age);
        $this->menu->message("Contact created successfully! (ID: {$contact->getId()})\n");
    }
}
