<?php

namespace Tracko\BaseBundle\Model;

/**
 * Class RogoPerformance
 *
 * @author Tobias Nyholm
 *
 */
trait RogoPerformanceTrait
{
    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    protected $attempts = 0;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    protected $successfulAttempts = 0;

    /**
     * @var float higher number is more trustworthy
     *
     * @ORM\Column(type="float")
     */
    protected $reliability = 1;

    /**
     * @var float higher number is more difficult
     *
     * @ORM\Column(type="float")
     */
    protected $difficulty = 0;

    /**
     *
     * @param float $attempts
     *
     * @return $this
     */
    public function setAttempts($attempts)
    {
        $this->attempts = $attempts;

        return $this;
    }

    /**
     *
     * @return float
     */
    public function getAttempts()
    {
        return $this->attempts;
    }

    /**
     *
     * @param float $difficulty
     *
     * @return $this
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     *
     * @return float
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     *
     * @param float $reliability
     *
     * @return $this
     */
    public function setReliability($reliability)
    {
        $this->reliability = $reliability;

        return $this;
    }

    /**
     *
     * @return float
     */
    public function getReliability()
    {
        return $this->reliability;
    }

    /**
     *
     * @param float $successfulAttempts
     *
     * @return $this
     */
    public function setSuccessfulAttempts($successfulAttempts)
    {
        $this->successfulAttempts = $successfulAttempts;

        return $this;
    }

    /**
     *
     * @return float
     */
    public function getSuccessfulAttempts()
    {
        return $this->successfulAttempts;
    }

    /**
     * Increase attempts by one
     *
     * @param boolean $successful
     *
     * @return $this
     */
    public function increaseAttempts($successful)
    {
        $this->attempts++;

        if ($successful) {
            $this->successfulAttempts++;
        }

        return $this;
    }
}