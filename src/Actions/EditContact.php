<?php

class EditContact implements ActionInterface
{
    public function __construct(
        private Menu $menu,
        private ContactRepository $repository,
    ) {}

    public function execute(): void
    {
        $this->menu->message("\n--- Edit Contact ---\n");

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

        $this->menu->message("Editing: {$contact->getName()} (press Enter to keep current value)\n");

        $name = $this->menu->readInput("Name [{$contact->getName()}]: ");
        if ($name !== '') {
            $contact->setName($name);
        }

        $email = $this->menu->readInput("Email [{$contact->getEmail()}]: ");
        if ($email !== '') {
            if (!Validator::validateEmail($email)) {
                $this->menu->message("Invalid email. Field not changed.\n");
            } else {
                $contact->setEmail($email);
            }
        }

        $phone = $this->menu->readInput("Phone [{$contact->getPhone()}]: ");
        if ($phone !== '') {
            $contact->setPhone($phone);
        }

        $ageInput = $this->menu->readInput("Age [{$contact->getAge()}]: ");
        if ($ageInput !== '') {
            $age = Validator::validateAgeInput($ageInput);
            if ($age === null) {
                $this->menu->message("Invalid age. Must be a number between 1 and 150. Field not changed.\n");
            } else {
                $contact->setAge($age);
            }
        }

        $currentStatus = $contact->isActive() ? 'Active' : 'Inactive';
        $active = $this->menu->readInput("Status (1=Active, 0=Inactive) [$currentStatus]: ");
        if ($active !== '') {
            $contact->setActive($active === '1');
        }

        $this->repository->save();
        $this->menu->message("Contact updated successfully!\n");
    }
}
