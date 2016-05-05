<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of FlightTicket
 *
 * @author contactenesi
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="flightticket")
 */
class FlightTicket {
    /* Constants for Enum type */

    const STATUS = array("not_paid", "part_paid", "paid", "refunded");

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="ticketid", type="integer", nullable=false)
     */
    private $ticketId;

    /**
     * @ORM\Column(name="pnr", type="string", length=6)
     */
    private $pnr;

    /**
     * @ORM\Column(name="ticketno", type="string", length=15, unique=true)
     */
    private $ticketNo;

    /**
     * @ORM\Column(name="status", type="string", length=10, options={"default":"not_paid"})
     */
    private $status;

    /**
     * @ORM\Column(name="fare", type="decimal", precision=11, scale=4)
     */
    private $fare;

    /**
     * @ORM\Column(name="commission", type="decimal", precision=5, scale=2, options={"default":0})
     */
    private $commission;

    /**
     * @ORM\Column(name="witholding_tax", type="decimal", precision=5, scale=2, options={"default":0})
     */
    private $witholdingTax;

    /**
     * @ORM\Column(name="leadway_fee", type="decimal", precision=11, scale=4)
     */
    private $leadwayFee;

    /**
     * @ORM\Column(name="amount_due", type="decimal", precision=11, scale=4)
     */
    private $amountDue;

    /**
     * @ORM\Column(name="amount_paid", type="decimal", precision=11, scale=4, options={"default":0})
     */
    private $amountPaid;

    /**
     * @ORM\Column(name="service_charge", type="decimal", precision=11, scale=4, options={"default":0})
     */
    private $serviceCharge;

    /**
     * @ORM\Column(name="entry_date", type="datetime")
     */
    private $entryDate;

    /**
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumn(name="agentid", referencedColumnName="agentid", nullable=true)
     */
    private $agent;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="userid", referencedColumnName="userid", nullable=false)
     */
    private $user;

    public function __construct() {
        $this->status = "not_paid";
        $this->entryDate = new \DateTime();
        $this->amountDue = 0;
        $this->amountPaid = 0;
        $this->witholdingTax = 0;
        $this->commission = 0;
        $this->serviceCharge = 0;
    }

    /**
     * Get ticketId
     *
     * @return integer 
     */
    public function getTicketId() {
        return $this->ticketId;
    }

    /**
     * Set pnr
     *
     * @param string $pnr
     * @return FlightTicket
     */
    public function setPnr($pnr) {
        $this->pnr = $pnr;

        return $this;
    }

    /**
     * Get pnr
     *
     * @return string 
     */
    public function getPnr() {
        return $this->pnr;
    }

    /**
     * Set ticketNo
     *
     * @param string $ticketNo
     * @return FlightTicket
     */
    public function setTicketNo($ticketNo) {
        $this->ticketNo = $ticketNo;

        return $this;
    }

    /**
     * Get ticketNo
     *
     * @return string 
     */
    public function getTicketNo() {
        return $this->ticketNo;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return FlightTicket
     */
    public function setStatus($status) {
        if (in_array($status, self::STATUS)) {
            $this->status = $status;
            return $this;
        } else {
            throw new Exception("Invalid Ticket Status.");
        }
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set entryDate
     *
     * @param \DateTime $entryDate
     * @return FlightTicket
     */
    public function setEntryDate($entryDate) {
        $this->entryDate = $entryDate;

        return $this;
    }

    /**
     * Get entryDate
     *
     * @return \DateTime 
     */
    public function getEntryDate() {
        return $this->entryDate;
    }

    /**
     * Set agent
     *
     * @param \AppBundle\Entity\Agent $agent
     * @return FlightTicket
     */
    public function setAgent(\AppBundle\Entity\Agent $agent) {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Get agent
     *
     * @return \AppBundle\Entity\Agent 
     */
    public function getAgent() {
        return $this->agent;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return FlightTicket
     */
    public function setUser(\AppBundle\Entity\User $user) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Set fare
     *
     * @param string $fare
     * @return FlightTicket
     */
    public function setFare($fare) {
        $this->fare = $fare;
        $this->computeAmountDue();
        return $this;
    }

    /**
     * Get fare
     *
     * @return string 
     */
    public function getFare() {
        return $this->fare;
    }

    /**
     * Set commission
     *
     * @param string $commission
     * @return FlightTicket
     */
    public function setCommission($commission) {
        $this->commission = $commission;
        $this->computeAmountDue();
        return $this;
    }

    /**
     * Get commission
     *
     * @return string 
     */
    public function getCommission() {
        return $this->commission;
    }

    /**
     * Set witholdingTax
     *
     * @param string $witholdingTax
     * @return FlightTicket
     */
    public function setWitholdingTax($witholdingTax) {
        $this->witholdingTax = $witholdingTax;
        $this->computeAmountDue();
        return $this;
    }

    /**
     * Get witholdingTax
     *
     * @return string 
     */
    public function getWitholdingTax() {
        return $this->witholdingTax;
    }

    /**
     * Set leadwayFee
     *
     * @param string $leadwayFee
     * @return FlightTicket
     */
    public function setLeadwayFee($leadwayFee) {
        $this->leadwayFee = $leadwayFee;
        $this->computeAmountDue();
        return $this;
    }

    /**
     * Get leadwayFee
     *
     * @return string 
     */
    public function getLeadwayFee() {
        return $this->leadwayFee;
    }

    /**
     * Set amountDue
     *
     * @param string $amountDue
     * @return FlightTicket
     */
    public function setAmountDue($amountDue) {
        $this->amountDue = $amountDue;

        return $this;
    }

    /**
     * Get amountDue
     *
     * @return string 
     */
    public function getAmountDue() {
        return $this->amountDue;
    }

    /**
     * Set amountPaid
     *
     * @param string $amountPaid
     * @return FlightTicket
     */
    public function setAmountPaid($amountPaid) {
        if($this->status=="refunded"){
            return $this;
        }
        $status = "not-paid";
        $this->amountPaid += $amountPaid;
        if($this->amountPaid==0){
            $status = "not-paid";
        }else
        if($this->getAmountDue()>$this->getAmountPaid()){
            $status = "part-paid";
        }else{
            $status = "paid";
        }
        $this->setStatus($status);

        return $this;
    }

    /**
     * Get amountPaid
     *
     * @return string 
     */
    public function getAmountPaid() {
        return $this->amountPaid;
    }

    /**
     * Set serviceCharge
     *
     * @param string $serviceCharge
     * @return FlightTicket
     */
    public function setServiceCharge($serviceCharge) {
        $this->serviceCharge = $serviceCharge;
        $this->computeAmountDue();
        return $this;
    }

    /**
     * Get serviceCharge
     *
     * @return string 
     */
    public function getServiceCharge() {
        return $this->serviceCharge;
    }

    public function computeAmountDue() {
        $fare = $this->getFare();
        if ($fare == 0) {
            $this->setAmountDue(0);
        }
        $commission = (($this->getCommission() / 100) * $fare);
        $serviceCharge = $this->getServiceCharge();
        $witholding = (($this->getWitholdingTax() / 100) * $commission);
        $leadway = $this->getLeadwayFee();
        $this->setAmountDue($fare + $commission + $serviceCharge + $witholding + $leadway);
    }

}
