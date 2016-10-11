<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 2/10/16
 * Time: 5:15 PM
 */

namespace Guessing;


class Guessing
{
    const MIN = 1;
    const MAX = 100;

    const INVALID = -1;
    const TOOLOW = 0;
    const CORRECT = 1;
    const TOOHIGH = 2;
    const NOGUESS = 5;

    public function __construct($seed = null) {
        if($seed === null) {
            $seed = time();
        }

        srand($seed);
        $this->number = rand(self::MIN, self::MAX);
    }

    /** Gets the guess num
     * @return int
     */
    public function getNumber() {
        return $this->number;
    }

    public function getGuess() {
        return $this->guess;
    }

    /** Checks if a guess is valid
     * @return bool
     */
    public function check() {

        if(!is_numeric($this->guess) || $this->guess > 100 || $this->guess < 1) {
            if($this->num_guesses == 0  && !$this->guess_made){
                return self::NOGUESS;
            }
            return self::INVALID;
        }
        else {
            if($this->guess == $this->number) {
                return self::CORRECT;
            }
            else if($this->guess < $this->number){
                return self::TOOLOW;
            }
            else if($this->guess > $this->number) {
                return self::TOOHIGH;
            }
        }
    }

    public function guess($guess) {
        $this->guess = $guess;
        $this->guess_made = true;
        if( is_numeric($this->guess) && $this->guess <= 100 && $this->guess >= 1 ) {
            $this->num_guesses++;
        }

    }

    /** Gets the number of guesses
     * @return int
     */
    public function getNumGuesses() {
        return $this->num_guesses;
    }

    private $guess_made = false;
    private $guess;
    private $num_guesses = 0;
    private $number;
}