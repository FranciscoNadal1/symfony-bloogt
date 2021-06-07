<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @var string
     */
    private $name;
    
      /**
     * @ORM\ManyToMany(targetEntity="Hashtag", cascade={"persist", "remove"})
     */
    private $hashtags;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="category", cascade={"all"}, fetch="LAZY"), orphanRemoval=true)
     * @ORM\JoinColumn(name="post_id")
     */
    private $posts;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getHashtags()
    {
        return $this->hashtags;
    }

    /**
     * @param mixed $hashtags
     */
    public function setHashtags($hashtags): void
    {
        $this->hashtags = $hashtags;
    }

    /**
     * @return mixed
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @param mixed $posts
     */
    public function setPosts($posts): void
    {
        $this->posts = $posts;
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////////
    ///         DATA PROJECTIONS
    ///

    public static function MapDataCategoryOnlyNameProjection($data){
        if(is_array($data)  or $data instanceof \Doctrine\ORM\PersistentCollection){
            $dataToReturn = array();
            foreach($data as $dat) {
                $dataToReturn[] = Category::CategoryOnlyName($dat);
            }
            return $dataToReturn;
        }else{
            return Category::CategoryOnlyName($data);
        }
    }



    public static function CategoryOnlyName($Category){

        $data =[
            'id' => $Category->getId(),
            'name' => $Category->getName(),

        ];
        return $data;
    }

}
