<?php

class ShowStatistics implements ActionInterface
{
    public function __construct(
        private Menu $menu,
        private ContactRepository $repository,
    ) {}

    public function execute(): void
    {
        $this->menu->message("\n--- Statistics ---\n");

        $total = $this->repository->total();

        if ($total === 0) {
            $this->menu->message("No contacts registered.\n");
            return;
        }

        $active = $this->repository->totalActive();
        $inactive = $total - $active;
        $average = number_format($this->repository->averageAge(), 1);

        $this->menu->message("Total contacts: $total\n");
        $this->menu->message("Active: $active\n");
        $this->menu->message("Inactive: $inactive\n");
        $this->menu->message("Average age: $average\n");
    }
}
