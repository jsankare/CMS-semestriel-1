<?php

namespace App\Models;

use App\Core\SQL;

class Page extends SQL
{
    private ?int $id=null;
    protected string $title;
    protected string $content;
//    protected int $creator_id;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = strtolower(trim($title));
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function findOneByTitle(string $title) {
        $sql = "SELECT * FROM {$this->table} WHERE title = :title";

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute([":title" => $title]);
        $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, 'App\Models\Page');
        return $queryPrepared->fetch();
    }
}