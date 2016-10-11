<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 3/22/16
 * Time: 2:49 PM
 */

namespace Felis;


class Email {
    public function mail($to, $subject, $message, $headers) {
        mail($to, $subject, $message, $headers);
    }
}