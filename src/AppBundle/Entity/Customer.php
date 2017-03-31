<?php

namespace AppBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Car
 *
 * @ORM\Table(name="Customers_shop")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CarRepository")
 */
class Customer{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var = string
     *
     * @ORM\Column(name="FirstName", type="string",length=255,nullable=true)
     */

    private $firstName;

    /**
     * @var = string
     *
     * @ORM\Column(name="LastName", type="string",length=255)
     */

    private $lastName;

    /**
     * @var = string
     *
     * @ORM\Column(name="Address", type="string",length=255)
     */

    private $address;
    /**
     * @var = string
     *
     * @ORM\Column(name="City", type="string",length=255)
     */

    private $city;
    /**
     * @var = string
     *
     * @ORM\Column(name="Country", type="string",length=255)
     */

    private $country;
    /**
     * @var string
     *
     * @ORM\Column(name="Postcode", type="string")
     */

    private $postcode;

    /**
     * @var = string
     *
     * @ORM\Column(name="Email", type="string",length=255)
     */

    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="DeliveryStatus", type="string",length=255)
     */

    private $delivery;

    /**
     * @var \DateTime
     * @ORM\Column(name="Date", type="datetime")
     */

    private $date;

    /**
     * @var = int
     *
     * @ORM\Column(name="Quantity", type="integer")
     */

    private $quantity;

    /**
     * @var = string
     *
     * @ORM\Column(name="ProductTitle", type="string",length=255,nullable=true)
     */

    private $title;

    /**
     * @var = string
     *
     * @ORM\Column(name="ProductCategory", type="string",length=255,nullable=true)
     */

    private $category;


//-------------------------------------------------------------
    /**
     * @var int
     *
     * @ORM\Column(name="ProductPrice", type="decimal", precision=7, scale=2)
     */

    private $price = 0;
//-------------------------------------------------------------

    /**
     *
     * @var = string
     * @ORM\Column(name="Description", type="string",length=400,nullable=true)
     */
    private $description;

    /**
     * @var = string
     *
     * @ORM\Column(name="PhotoLink", type="string",length=255,nullable=true)
     */
    private $photos;

    /**
     * @Assert\Type(type="AppBundle\Entity\OrdersAllInOne")
     * @Assert\Valid()
     */
    protected $OrdersAllInOne;

    public function  __construct(){
        $this -> date = new \DateTime();
        $this -> processdate = new \DateTime();
        $this -> delivery ='Not yet sent';
    }


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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Customer
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Customer
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Customer
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Customer
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Customer
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set postcode
     *
     * @param string $postcode
     *
     * @return Customer
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Customer
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Customer
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Customer
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Customer
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set photos
     *
     * @param string $photos
     *
     * @return Customer
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;

        return $this;
    }

    /**
     * Get photos
     *
     * @return string
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Customer
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Customer
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set delivery
     *
     * @param string $delivery
     *
     * @return Customer
     */
    public function setDelivery($delivery)
    {
        $this->delivery = $delivery;

        return $this;
    }

    /**
     * Get delivery
     *
     * @return string
     */
    public function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Customer
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set processdate
     *
     * @param \DateTime $processdate
     *
     * @return Customer
     */
   
}
