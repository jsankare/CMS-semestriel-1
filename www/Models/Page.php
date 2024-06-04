
<?php

namespace App\Models;

use App\Core\SQL;

class Page extends SQL
{
    private ?int $id=null;
    protected string $title;
    protected string $description;
    protected string $content;
    protected int $creator_id;

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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
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

    /**
     * @return int
     */
    public function getCreatorId(): int
    {
        return $this->creator_id;
    }

    /**
     * @param int $creator_id
     */
    public function setCreatorId(int $creator_id): void
    {
        $this->creator_id = $creator_id;
    }

    public function findOneByTitle(string $title) {
        $sql = "SELECT * FROM {$this->table} WHERE title = :title";

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute([":title" => $title]);
        $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, 'App\Models\Page');
        return $queryPrepared->fetch();
    }

    public function findOneById(string $id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute([":id" => $id]);
        $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, 'App\Models\Page');
        return $queryPrepared->fetch();
    }

    public function findAll() {
        $sql = "SELECT * FROM {$this->table}";

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();
        $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, 'App\Models\Page');
        return $queryPrepared->fetchAll();
    }

    public function delete(): void
    {
        if (!empty($this->getId())) {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $queryPrepared = $this->pdo->prepare($sql);
            $queryPrepared->execute([':id' => $this->getId()]);
        }
    }

    public function save(): void
    {
        if (!empty($this->getId())) {
            $sql = "UPDATE {$this->table} SET title = :title, description = :description, content = :content, creator_id = :creator_id WHERE id = :id";
            $queryPrepared = $this->pdo->prepare($sql);
            $queryPrepared->execute([
                ':title' => $this->getTitle(),
                ':description' => $this->getDescription(),
                ':content' => $this->getContent(),
                ':creator_id' => $this->getCreatorId(),
                ':id' => $this->getId(),
            ]);
        } else {
            $sql = "INSERT INTO {$this->table} (title, description, content, creator_id) VALUES (:title, :description, :content, :creator_id)";
            $queryPrepared = $this->pdo->prepare($sql);
            $queryPrepared->execute([
                ':title' => $this->getTitle(),
                ':description' => $this->getDescription(),
                ':content' => $this->getContent(),
                ':creator_id' => $this->getCreatorId(),
            ]);
            $this->id = $this->pdo->lastInsertId();
        }
    }
}