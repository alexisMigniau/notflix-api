<?php

namespace App\Entity\Trait;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\DBAL\Types\Types;

trait Timestampable {

    use TimestampableEntity;

    /**
     * @var \DateTime|null
     * @Gedmo\Timestampable(on="create")
     * @Groups({"timestampable"})
     * @ORM\Column(type="datetime")
     */
    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    protected $createdAt;

    /**
     * @var \DateTime|null
     * @Gedmo\Timestampable(on="update")
     * @Groups({"timestampable"})
     * @ORM\Column(type="datetime")
     */
    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    protected $updatedAt;
}