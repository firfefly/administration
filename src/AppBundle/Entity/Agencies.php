<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agencies
 *
 * @ORM\Table(name="agencies")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AgenciesRepository")
 */
class Agencies
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
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=5, nullable=false)
     */
    private $zip_code;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=2, nullable=false)
     */
    private $department_code;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=40, nullable=false)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true, options={"default" = 0})
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $schedule;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false, options={"default" = 0})
     */
    private $next_to;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=1000, nullable=false, options={"default" = 0})
     */
    private $caption = 0;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=5000, nullable=false, options={"default" = 0})
     */
    private $description = 0;

    /**
     * Get id
     *
     * @return int
     */
    function getId() {
        return $this->id;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    function getLatitude() {
        return $this->latitude;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    function getLongitude() {
        return $this->longitude;
    }

    /**
     * Get name
     *
     * @return string
     */
    function getName() {
        return $this->name;
    }

    /**
     * Get zip_code
     *
     * @return string
     */
    function getZipCode() {
        return $this->zip_code;
    }

    /**
     * Get city
     *
     * @return string
     */
    function getCity() {
        return $this->city;
    }

    /**
     * Get department_code
     *
     * @return string
     */
    function getDepartmentCode() {
        return $this->department_code;
    }

    /**
     * Get address
     *
     * @return string
     */
    function getAddress() {
        return $this->address;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    function getPhoneNumber() {
        return $this->phoneNumber;
    }

    /**
     * Get email
     *
     * @return string
     */
    function getEmail() {
        return $this->email;
    }

    /**
     * Get schedule
     *
     * @return string
     */
    function getSchedule() {
        return $this->schedule;
    }

    /**
     * Get next_to
     *
     * @return string
     */
    function getNextTo() {
        return $this->next_to;
    }

    /**
     * Get caption
     *
     * @return string
     */
    function getCaption() {
        return $this->caption;
    }

    /**
     * Get description
     *
     * @return string
     */
    function getDescription() {
        return $this->description;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setLatitude($latitude) {
        $this->latitude = $latitude;
    }

    function setLongitude($longitude) {
        $this->longitude = $longitude;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setZipCode($zipCode) {
        $this->zip_code = $zipCode;
    }

    function setCity($city) {
        $this->city = $city;
    }

    function setDepartmentCode($departmentCode) {
        $this->department_code = $departmentCode;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setSchedule($schedule) {
        $this->schedule = $schedule;
    }

    function setNextTo($nextTo) {
        $this->next_to = $nextTo;
    }

    function setCaption($caption) {
        $this->caption = $caption;
    }

    function setDescription($description) {
        $this->description = $description;
    }


}

