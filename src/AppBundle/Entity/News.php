<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * News
 *
 * @ORM\Table(name="news")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NewsRepository")
 */
class News {

    /**
     * @var int
     *
     * @ORM\Column(type="integer", length=11)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $department;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $caption;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    private $image;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", options={"default" = 0}, nullable=true)
     */
    private $active;

    /**
     * @var date
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $date;

    public function __construct() {
        $this->date = new \DateTime("now");
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get department
     *
     * @return string
     */
    public function getDepartment() {
        return $this->department;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Get caption
     *
     * @return string
     */
    public function getCaption() {
        return $this->caption;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText() {
        return $this->text;
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
     * Get date
     *
     * @return datetime
     */
    public function getDate() {
        return $this->date;
    }

    public function setDepartment($department) {
        $this->department = $department;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setCaption($caption) {
        $this->caption = $caption;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setActive($active) {
        $this->active = $active;
    }

    public function setDate($date) {
        $this->date = $date;
    }

}
