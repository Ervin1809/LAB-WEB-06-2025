<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public $title;
    public $imageSrc;
    public $description;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $imageSrc, $description)
    {
        $this->title = $title;
        $this->imageSrc = $imageSrc;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.card');
    }
}