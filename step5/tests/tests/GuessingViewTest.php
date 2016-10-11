<?php
require __DIR__ . "/../../vendor/autoload.php";
use Guessing\Guessing as Guessing;
use Guessing\GuessingView as GuessingView;
/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
class GuessingViewTest extends \PHPUnit_Framework_TestCase
{
	public function test_construct() {
		$guessing = new Guessing(1234);
		$view = new GuessingView($guessing);
		$this->assertNotEquals(null,$view);
	}

	public function test_invalid() {
		$guessing = new Guessing(1234);
		$view = new GuessingView($guessing);
        $html = '<form method="post" action="guessing-post.php">' .
            '<h1>Guessing Game</h1>';

        $this->assertContains($html,$view->present());

		$guessing->guess(-1);
		$guess = $guessing->getGuess();

        $html .= <<<HTML
<p class="message">Your guess of $guess is invalid!</p>
<p><label for="value">Guess:</label> <input type="text" name="value" id="value"></p>
<p><input type="submit"></p>
HTML;

        $html .= '<p><input type="submit" name="clear" value="New Game"></p></form>';
        $this->assertContains($html,$view->present());
	}

	public function test_new_game() {
		$guessing = new Guessing(1234);
		$view = new GuessingView($guessing);

		$html = <<<HTML
<p class="message">Try to guess the number.</p>
<p><label for="value">Guess:</label> <input type="text" name="value" id="value"></p>
<p><input type="submit"></p>
HTML;

		$this->assertContains($html,$view->present());
	}

	public function test_low() {
		$guessing = new Guessing(1234);
		$view = new GuessingView($guessing);
		$html = '<form method="post" action="guessing-post.php">' .
				'<h1>Guessing Game</h1>';
		$ending = '<p><input type="submit" name="clear" value="New Game"></p></form>';

		$guessing->guess(15);

		$num = $guessing->getNumGuesses();
		$msg = "too low";
		$html .= <<<HTML
    <p class="message">After $num guesses you are $msg!</p>
    <p><label for="value">Guess:</label> <input type="text" name="value" id="value"></p>
    <p><input type="submit"></p>
HTML;

		$html .= $ending;
		$this->assertContains($html,$view->present());
	}

	public function test_high() {
		$guessing = new Guessing(1234);
		$view = new GuessingView($guessing);
		$html = '<form method="post" action="guessing-post.php">' .
				'<h1>Guessing Game</h1>';
		$ending = '<p><input type="submit" name="clear" value="New Game"></p></form>';

		$guessing->guess(100);

		$html .= <<<HTML
    <p class="message">After 1 guesses you are too high!</p>
    <p><label for="value">Guess:</label> <input type="text" name="value" id="value"></p>
    <p><input type="submit"></p>
HTML;

		$html .= $ending;
		$this->assertContains($html,$view->present());
	}

	public function test_correct() {
		$guessing = new Guessing(1234);
		$view = new GuessingView($guessing);
		$html = '<form method="post" action="guessing-post.php">' .
				'<h1>Guessing Game</h1>';
		$ending = '<p><input type="submit" name="clear" value="New Game"></p></form>';

		$guessing->guess(23);

		$num = $guessing->getNumGuesses();

		$html .= <<<HTML
<p class="message">After $num guesses you are correct!</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
HTML;

		$html .= $ending;
		$this->assertContains($html,$view->present());
	}

}

/// @endcond
?>
