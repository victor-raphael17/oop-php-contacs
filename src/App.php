<?php

class App
{
    private Menu $menu;
    /** @var array<string, ActionInterface> */
    private array $actions;

    public function __construct(string $contactsFile)
    {
        $this->menu = new Menu();
        $repository = new ContactRepository($contactsFile);

        $this->actions = [
            '1' => new CreateContact($this->menu, $repository),
            '2' => new ListContacts($this->menu, $repository),
            '3' => new SearchContact($this->menu, $repository),
            '4' => new EditContact($this->menu, $repository),
            '5' => new DeleteContact($this->menu, $repository),
            '6' => new ShowStatistics($this->menu, $repository),
        ];
    }

    public function run(): void
    {
        $this->menu->message("Welcome to the Contact Management System!\n");

        while (true) {
            $this->menu->display();
            $option = $this->menu->readInput("Choose an option: ");

            if ($option === '0') {
                $this->menu->message("\nThank you for using the system. Goodbye!\n");
                exit(0);
            }

            if (isset($this->actions[$option])) {
                $this->actions[$option]->execute();
            } else {
                $this->menu->message("Invalid option. Try again.\n");
            }
        }
    }
}
