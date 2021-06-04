<?php


class Template
{
    private $id;
    private $name;
    private $description;
    private $category;

    public function __construct($id = null, $name = null, $description = null, $category = null) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->category = $category;
    }

    public function getParams()
    {
        return [$this->id,$this->name,$this->description,$this->category];
    }

    /**
     * @return mixed|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed|null $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed|null $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed|null $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed|null
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed|null $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }




}