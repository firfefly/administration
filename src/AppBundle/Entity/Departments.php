<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Departments
 *
 * @ORM\Table(name="departments")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DepartmentsRepository")
 */
class Departments
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", length=11)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10000, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=4500, nullable=true)
     */
    private $short_description;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $active;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Get short_description
     *
     * @return string
     */
    public function getShortDescription() {
        return $this->short_description;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * Set id
     *
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Set code
     *
     * @param string $code
     */
    public function setCode($code) {
        $this->code = $code;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * Set short_description
     *
     * @param string $short_description
     */
    public function setShortDescription($short_description) {
        $this->short_description = $short_description;
    }

    /**
     * Set image
     *
     * @param string $image
     */
    public function setImage($image) {
        $this->image = $image;
    }

    /**
     * Set active
     *
     * @param boolean $active
     */
    public function setActive($active) {
        $this->active = $active;
    }
}

