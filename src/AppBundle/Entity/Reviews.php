<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reviews
 *
 * @ORM\Table(name="reviews")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReviewsRepository")
 */
class Reviews
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
     * @ORM\Column(type="string", length=500, nullable=false)
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $who;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\File(mimeTypes={ "image/jpeg","image/png" })
     */
    private $image1 = 'default.jpg';

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\File(mimeTypes={ "image/jpeg","image/png" })
     */
    private $image2 = 'default2.jpg';

    /**
     * @var date
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="mark", options={"default" = 100}, type="integer")
     */
    private $mark;

    public function __construct()
    {
        $this->date = new \DateTime("now");
    }

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
    function getText() {
        return $this->text;
    }

    /**
     * Get who
     *
     * @return string
     */
    function getWho() {
        return $this->who;
    }

    /**
     * Get image1
     *
     * @return string
     */
    function getImage1() {
        return $this->image1;
    }

    /**
     * Get image2
     *
     * @return string
     */
    function getImage2() {
        return $this->image2;
    }

    /**
     * Get date
     *
     * @return dateTime
     */
    function getDate() {
        return $this->date;
    }

    /**
     * Get mark
     *
     * @return int
     */
    function getMark() {
        return $this->mark;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setText($text) {
        $this->text = $text;
    }

    function setWho($who) {
        $this->who = $who;
    }

    function setImage1($image1) {
        $this->image1 = $image1;
        return $this;
    }

    function setImage2($image2) {
        $this->image2 = $image2;
        return $this;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setMark($mark) {
        $this->mark = $mark;
    }


}

