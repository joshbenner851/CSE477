<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 3/21/16
 * Time: 12:44 AM
 */

namespace Felis;


class ClientCase
{
    const STATUS_OPEN = "O";	///< Case is open
    const STATUS_CLOSED = "C";


    public function __construct($row)
    {
        $this->id = $row['id'];
        $this->client = $row['client'];
        $this->clientName = $row['clientName'];
        $this->agent = $row['agent'];
        $this->agentName = $row['agentName'];
        $this->summary = $row['summary'];
        $this->status = $row['status'];
        $this->number = $row['number'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return mixed
     */
    public function getClientName()
    {
        return $this->clientName;
    }

    /**
     * @return mixed
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * @return mixed
     */
    public function getAgentName()
    {
        return $this->agentName;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return mixed
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }	///< Case is closed

    private $id;
    private $client;
    private $clientName;
    private $agent;
    private $agentName;
    private $number;
    private $summary;
    private $status;
}