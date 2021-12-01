<?php

namespace App\Model;

class News
{
    private int $id;
    private string $title;
    private string $desc;

    public function __construct(int $id, string $title, string $desc)
    {
        $this->desc = $desc;
        $this->id = $id;
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDesc(): string
    {
        return $this->desc;
    }


}