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
            $this->menu->message("Invalid email. Must contain '@' and be at least 5 characters.\n");
            return;
        }

        $phone = $this->menu->readInput("Phone: ");
        if (!Validator::validatePhone($phone)) {
            $this->menu->message("Phone cannot be empty.\n");
            return;
        }

        $age = (int) $this->menu->readInput("Age: ");
        if (!Validator::validateAge($age)) {
            $this->menu->message("Invalid age.\n");
            return;
        }

        $contact = $this->repository->add($name, $email, $phone, $age);
        $this->menu->message("Contact created successfully! (ID: {$contact->getId()})\n");
    }
}
