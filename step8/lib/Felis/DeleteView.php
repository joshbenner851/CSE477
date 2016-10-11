<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 3/23/16
 * Time: 3:51 AM
 */

namespace Felis;


class DeleteView extends View
{

    /**
     * Constructor
     * Sets the page title and any other settings.
     */
    public function __construct(Site $site,array $get, array $session) {
        parent::__construct($site, $get, $session);
        $this->setTitle("Felis Investigations Cases");
        $this->addLink("staff.php","Staff");
        $this->addLink("cases.php","Cases");
        $this->addLink("./","Log out");
        $this->site = $site;
    }

    public function present(){
        $caseNum = strip_tags($this->get['id']);
        $hidden = '<input type="hidden" name="id" value="' . $caseNum . '">';

        $html = <<<HTML
<form method="post" action="post/delete.php">
$hidden
	<fieldset>
		<legend>Delete?</legend>
		<p>Are you sure absolutely certain beyond a shadow of
			a doubt that you want to delete case $caseNum?</p>

		<p>Speak now or forever hold your peace.</p>

		<p><input type="submit" name="yes" id="yes" value="Yes"> <input type="submit" name="no" id="no" value="No"></p>

	</fieldset>
</form>
HTML;

        return $html;

    }
}