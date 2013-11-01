<?php

namespace Tracko\BaseBundle\Model;

/**
 * Class TimestampTrait
 *
 * @author Tobias Nyholm
 *
 */
trait TimestampTrait
{
    /**
     * @var \Datetime $createdAt
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \Datetime $updatedAt
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    protected $updatedAt;

    /**
     *
     * @return \Datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return $this
     */
    public function updateUpdatedAt()
    {
        $this->updatedAt = new \DateTime();

        return $this;
    }

    /**
     *
     * @return \Datetime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}