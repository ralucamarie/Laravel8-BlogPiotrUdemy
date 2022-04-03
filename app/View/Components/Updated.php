<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Updated extends Component
{
    public $name;
    public $date;

    public $userId;

    public $slot;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $date, $userId)
    {
        $this->name=$name;
        $this->date=$date;
        $this->userId=$userId;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.updated');
    }
}
