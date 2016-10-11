<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 3/16/16
 * Time: 2:35 AM
 */

namespace Felis;


class StaffView extends View
{

    /**
     * Constructor
     * Sets the page title and any other settings.
     */
    public function __construct()
    {
        $this->setTitle("Felis Investigations Staff");
        $this->addLink("./post/logout.php", "Log out");
    }

}