<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sectors
 *
 * @ORM\Table(name="sectors")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SectorsRepository")
 */
class Sectors
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $code;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $agency_id;

    /**
     * Get id
     *
     * @return int
     */
    function getId() {
        return $this->id;
    }

    /**
     * Get text
     *
     * @return string
     */
    function getCode() {
        return $this->code;
    }

    /**
     * Get id
     *
     * @return int
     */
    function getAgencyId() {
        return $this->agency_id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function setAgencyId($agencyId) {
        $this->agency_id = $agencyId;
    }


}

