<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Category;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $thumb;
    
    /**
     * @ORM\Column(type="text")
     */
    private $description;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $author;
    
    /**
     * @ORM\Column(type="float", scale=2)
     */
    private $price;

     /**
     * @ORM\ManyToOne(targetEntity="Category", fetch="EAGER")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getThumb()
    {
        return $this->thumb;
    }

    public function setThumb($thumb)
    {
        $this->thumb = $thumb;
    }
    
    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($rate)
    {
        $this->price = $price;
    }
    
    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }
}
