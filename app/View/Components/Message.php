<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Message extends Component
{
    public string $message = '';
    public string $type = '';
    public $msg = '';
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($message = '', $type="")
    {
        //
        $this->msg = '';
        
        $this->message = $message;
        if ($type == 'OK') {
            $this->type= "success";
        }
        else if ($type== 'ERROR') {
            $this->type= "warning";      
        }
        else if ($type == 'random') {
            $this->msg = '';
        }
        else {
            $this->type= "primary";
        }

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.message');
    }
}
