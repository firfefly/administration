<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Sliders
 *
 * @ORM\Table(name="sliders")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SlidersRepository")
 */
class Sliders
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
     * @ORM\Column(type="string")
     *
     * @Assert\File(mimeTypes={ "image/jpeg","image/png" })
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $src;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $alt;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=200, nullable=false)
     */
    private $slogan;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $actionLink1;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $actionText1;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $actionLink2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $actionText2;

    /**
     * Get id
     *
     * @return int
     */
    function getId() {
        return $this->id;
    }

    /**
     * Get image
     *
     * @return string
     */
    function getImage() {
        return $this->image;
    }

    /**
     * Get src
     *
     * @return string
     */
    function getSrc() {
        return $this->src;
    }

    /**
     * Get alt
     *
     * @return string
     */
    function getAlt() {
        return $this->alt;
    }

    /**
     * Get slogan
     *
     * @return string
     */
    function getSlogan() {
        return $this->slogan;
    }

    /**
     * Get title
     *
     * @return string
     */
    function getTitle() {
        return $this->title;
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
     * Get actionLink1
     *
     * @return string
     */
    function getActionLink1() {
        return $this->actionLink1;
    }

    /**
     * Get actionText1
     *
     * @return string
     */
    function getActionText1() {
        return $this->actionText1;
    }

    /**
     * Get actionLink1
     *
     * @return string
     */
    function getActionLink2() {
        return $this->actionLink2;
    }

    /**
     * Get actionText2
     *
     * @return string
     */
    function getActionText2() {
        return $this->actionText2;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setImage($image) {
        $this->image = $image;
    }

    function setSrc($src) {
        $this->src = $src;
    }

    function setAlt($alt) {
        $this->alt = $alt;
    }

    function setSlogan($slogan) {
        $this->slogan = $slogan;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setText($text) {
        $this->text = $text;
    }

    function setActionLink1($actionLink1) {
        $this->actionLink1 = $actionLink1;
    }

    function setActionText1($actionText1) {
        $this->actionText1 = $actionText1;
    }

    function setActionLink2($actionLink2) {
        $this->actionLink2 = $actionLink2;
    }

    function setActionText2($actionText2) {
        $this->actionText2 = $actionText2;
    }


}

