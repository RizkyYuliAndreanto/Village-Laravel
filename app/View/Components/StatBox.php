<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StatBox extends Component
{
    /**
     * Nilai statistik yang akan ditampilkan.
     *
     * @var mixed
     */
    public $value;

    /**
     * Label dari statistik.
     *
     * @var string
     */
    public $label;

    /**
     * Buat instance komponen baru.
     *
     * @param mixed $value
     * @param string $label
     */
    public function __construct($value = 0, $label = '')
    {
        $this->value = $value;
        $this->label = $label;
    }

    /**
     * Tampilkan view komponen.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.stat-box', [
            'value' => $this->value,
            'label' => $this->label,
        ]);
    }
}
