<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 3/21/16
 * Time: 1:46 AM
 */

namespace Felis;


class CasesView extends View
{
    /**
     * Constructor
     * Sets the page title and any other settings.
     */
    public function __construct(Site $site, $get, $session) {
        parent::__construct($site, $get, $session);
        $this->setTitle("Felis Investigations Cases");
        $this->addLink("staff.php","Staff");
    }

    public function present(){
        $html = <<<HTML
<form method="post" action="post/cases.php" class="table">
	<p>
	<input type="submit" name="add" id="add" value="Add">
	<input type="submit" name="delete" id="delete" value="Delete">
	</p>

	<table>
		<tr>
			<th>&nbsp;</th>
			<th>Case Number</th>
			<th>Client</th>
			<th>Agent In Charge</th>
			<th class="desc">Description</th>
			<th>Most Recent Report</th>
			<th>Status</th>
		</tr>
HTML;
        $cases = new Cases($this->site);
		$all = $cases->getCases();
        //var_dump($all);

		foreach($all as $clientcase) {

			$caseNum = $clientcase->getNumber();
			$clientName = $clientcase->getClientName();
			$agentName = $clientcase->getAgentName();
			$status = $clientcase->getStatus();
            //$id = $clientcase->getId();
            $summary = $clientcase->getSummary();
			$html .= <<<HTML
<tr><td><input type="radio" value="$caseNum" name="id"></td>
<td><a href="case.php?id=$caseNum">$caseNum</a></td><td>$clientName</td><td>$agentName</td><td>$summary</td><td>&nbsp;</td><td>$status</td>
</tr>
HTML;
		}

        $html .= <<<HTML
</table></form>
HTML;

//        $html .= <<<HTML
//		<tr>
//			<td><input type="radio" name="user"></td>
//			<td><a href="case.php">16-0088</a></td>
//			<td>Swift, Taylor</td>
//			<td>Bogart, Humphrey</td>
//			<td class="desc"><div>Tabby sneaking around her place.</div></td>
//			<td>2-16-2016 11:32pm</td>
//			<td>Open</td>
//		</tr>
//		<tr>
//			<td><input type="radio" name="user"></td>
//			<td><a href="case.php">16-0172</a></td>
//			<td>Trump, Donald</td>
//			<td>Martin, Harvey</td>
//			<td class="desc"><div>Garbage cans regularly knocked over.</div></td>
//			<td>2-12-2016 1:19am</td>
//			<td>Open</td>
//		</tr>
//
//		<tr>
//			<td><input type="radio" name="user"></td>
//			<td><a href="case.php">16-0218</a></td>
//			<td>Diamond, Olivia</td>
//			<td>Martin, Harvey</td>
//			<td class="desc"><div>Macavity stole her tuna caserole.</div></td>
//			<td>1-12-2015 3:33am</td>
//			<td>Closed</td>
//		</tr>
//	</table>
//</form>
//HTML;
        return $html;
    }



}