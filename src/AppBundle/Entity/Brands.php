<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Brands
 *
 * @ORM\Table(name="brands")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BrandsRepository")
 */
class Brands
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
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $url;

    /**
     * @ORM\Column(type="string")
     */
    private $dir;

    /**
     * Get id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name
     * @return string
     */
    function getName() {
        return $this->name;
    }

    /**
     * Get url
     * @return string
     */
    function getUrl() {
        return $this->url;
    }

    /**
     * Get dir
     * @return string
     */
    function getDir() {
        return $this->dir;
    }

    /**
     * Set name
     * @param string $name
     */
    function setName($name) {
        $this->name = $name;
    }

    /**
     * Set url
     * @param string $url
     */
    function setUrl($url) {
        $this->url = $url;
    }

    /**
     * Set dir
     * @param string $dir
     */
    function setDir($dir) {
        $this->dir = $dir;
    }
}

