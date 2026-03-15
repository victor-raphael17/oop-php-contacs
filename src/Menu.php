<?php

class Menu
{
    public function display(): void
    {
        echo "\n";
        echo "========================================\n";
        echo "   CONTACT MANAGEMENT\n";
        echo "========================================\n";
        echo " [1] Create contact\n";
        echo " [2] List contacts\n";
        echo " [3] Search contact\n";
        echo " [4] Edit contact\n";
        echo " [5] Delete contact\n";
        echo " [6] Statistics\n";
        echo " [0] Exit\n";
        echo "========================================\n";
    }

    public function readInput(string $message): string
    {
        return trim(readline($message));
    }

    public function displayContact(Contact $contact): void
    {
        $status = $contact->isActive() ? 'Active' : 'Inactive';
        $name = ucwords(strtolower($contact->getName()));

        echo "ID: {$contact->getId()} | Name: $name | Email: {$contact->getEmail()} | Phone: {$contact->getPhone()} | Age: {$contact->getAge()} | Status: $status\n";
    }

    public function message(string $text): void
    {
        echo $text;
    }
}
