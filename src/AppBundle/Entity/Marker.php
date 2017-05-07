<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Marker
 */
class Marker
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var decimal
     */
    private $lat;

    /**
     * @var decimal
     */
    private $lng;

    /**
     * @var string
     */
    private $name;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set lat
     *
     * @param decimal $lat
     * @return Marker
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return decimal 
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param decimal $lng
     * @return Marker
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get lng
     *
     * @return decimal 
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Marker
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
}
