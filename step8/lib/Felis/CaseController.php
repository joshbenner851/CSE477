<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 3/23/16
 * Time: 1:24 AM
 */

namespace Felis;


class CaseController
{

    /**
     * CaseController constructor.
     * @param Site $site
     * @param $post
     */
    public function __construct(Site $site,array $get, $post)
    {
        $root = $site->getRoot();
        if(isset($post['id'])){
            // the id for the case
            $id = strip_tags($post['id']);
            if(isset($post["update"])){
                $caseNum = strip_tags($post['number']);

                $cases = new Cases($site);
                $case = $cases->get($id);
                //var_dump($case);
                $stuff = $cases->get($cases->fetchID($caseNum));
                //var_dump($stuff);
                // Check if the case number already exists
                // if so return to edit page
                if($cases->get($cases->fetchID($caseNum)) === null || $case === null){
                    $this->redirect = "$root/case.php";
                }
                else{
                    $number = strip_tags($post['number']);
                    $summary = strip_tags($post['summary']);
                    $agent =strip_tags($post['agent']);
                    $status = strip_tags($post['status']);

                    //agent needs to be their id, not their name
                    $cases->update($id,$number,$summary,$agent,$status);
                    $this->redirect = "$root/cases.php";
                }
                //if($post['number'])
                //$this->redirect = "$root/newcase.php";
            }
        }
        else{
            $this->redirect = "$root/cases.php";
        }

    }

    /**
     * @return mixed
     */
    public function getRedirect()
    {
        return $this->redirect;
    }	///< Page we will redirect the user to.

    public function setRedirect($redirect){
        $this->redirect = $redirect;
    }

    private $redirect;
}