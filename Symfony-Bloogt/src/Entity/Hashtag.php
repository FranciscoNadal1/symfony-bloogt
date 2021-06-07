<?php

namespace App\Entity;

use App\Repository\HashtagRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HashtagRepository::class)
 */
class Hashtag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
        /**
     * @ORM\Column(type="string", unique="true")
     * @var string
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Post")
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

    public static function MapDataHashtagOnlyNameProjection($data){
        if(is_array($data)  or $data instanceof \Doctrine\ORM\PersistentCollection){
            $dataToReturn = array();
            foreach($data as $dat) {
                $dataToReturn[] = Hashtag::HashtagOnlyName($dat);
            }
            return $dataToReturn;
        }else{
            return Hashtag::HashtagOnlyName($data);
        }
    }



    public static function HashtagOnlyName($Hashtag){

        $data =[
            'id' => $Hashtag->getId(),
            'name' => $Hashtag->getName(),
            'postCount' => sizeof($Hashtag->getPosts()),
        ];
        return $data;
    }
}
