<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Models
 *
 * @ORM\Table(name="models")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModelsRepository")
 */
class Models {

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
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10000, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $plans;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=150, nullable=true, options={"default" = NULL})
     */
    private $images;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\File(mimeTypes={ "image/jpeg","image/png" })

      private $image;

      function getImage() {
      return $this->image;
      }

      function setImage($image) {
      $this->image = $image;
      }
     */

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $properties;

    /**
     * Get id
     *
     * @return int
     */
    function getId() {
        return $this->id;
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
     * Get description
     *
     * @return string
     */
    function getDescription() {
        return $this->description;
    }

    /**
     * Get plans
     *
     * @return string
     */
    function getPlans() {
        return $this->plans;
    }

    /**
     * Get image
     *
     * @return string
     */
    function getImages() {
        return $this->images;
    }

    /**
     * Get properties
     *
     * @return string
     */
    function getProperties() {
        return $this->properties;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setPlans($plans) {
        $this->plans = $plans;
    }

    function setImages($images) {
        $this->images = $images;
    }

    function setProperties($properties) {
        $this->properties = $properties;
    }

}
