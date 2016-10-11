<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 2/13/16
 * Time: 3:27 PM
 */

namespace Guessing;


class GuessingController
{
    /**
     * GuessingController constructor.
     * @param Guessing $guess The Guessing object
     * @param $request The $_REQUEST array
     */
    public function __construct(Guessing $guess, $post) {
        $this->guessing = $guess;
        if(isset($post['value'])){
            $this->guessing->guess(strip_tags($post['value']));
        }
        else if(isset($post['clear'])){
            $this->reset = true;
        }
    }


    public function isReset() {
        return $this->reset;
    }

    private $guessing;                // The Guessing object we are controlling
    private $reset = false;
}