<?php

namespace App\Models;

use App\Core\SQL;

class Page extends SQL
{
    private ?int $id = null;
    protected string $title;
    protected string $description;
    protected string $content;
    protected int $creator_id;
    protected ?string $slug = null;
    protected ?bool $is_main = null;

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
        $this->title = ucwords(strtolower(($title)));
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

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $this->generateSlug($slug);

    }

    /**
     * @return bool|null
     */
    public function isMain(): ?bool
    {
        return $this->is_main;
    }

    /**
     * @param bool $is_main
     */
    public function setIsMain(bool $is_main): void
    {
        $this->is_main = $is_main;
    }

    /**
     * @return bool|null
     */
    public function getIsMain(): ?bool
    {
        return (bool) $this->is_main;
    }

    public function findOneByTitle(string $title)
    {
        $sql = "SELECT * FROM {$this->table} WHERE title = :title";

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute([":title" => $title]);
        $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, 'App\Models\Page');
        return $queryPrepared->fetch();
    }

    public function findOneById(string $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute([":id" => $id]);
        $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, 'App\Models\Page');
        return $queryPrepared->fetch();
    }

    public function findOneBySlug(string $slug)
    {
        $sql = "SELECT * FROM {$this->table} WHERE slug = :slug";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute([':slug' => $slug]);
        $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, 'App\Models\Page');
        $page = $queryPrepared->fetch();

        if ($page === false) {
            error_log("Page not found for slug: $slug");
            return null;
        }

        return $page;
    }

    public function findAll()
    {
        $sql = "SELECT * FROM {$this->table}";

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();
        $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, 'App\Models\Page');
        return $queryPrepared->fetchAll();
    }

    public function findAllExcept(string $slug)
    {
        $sql = "SELECT * FROM {$this->table} WHERE slug != :slug";

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute([':slug' => $slug]);
        $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, 'App\Models\Page');
        return $queryPrepared->fetchAll();
    }

    public function findMainPage()
    {
        $sql = "SELECT * FROM {$this->table} WHERE is_main = TRUE";

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();
        $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, 'App\Models\Page');
        return $queryPrepared->fetch();
    }

    public function resetMainPage(): void
    {
        $sql = "UPDATE {$this->table} SET is_main = FALSE";
        $this->pdo->exec($sql);
    }

    public function delete(): void
    {
        if (!empty($this->getId())) {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $queryPrepared = $this->pdo->prepare($sql);
            $queryPrepared->execute([':id' => $this->getId()]);
        }
    }

    public function generateSlug(string $input): string
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $input)));
    }

    public function save(): void
    {
        $isMain = $this->isMain() ? 'TRUE' : 'FALSE';

        if (!empty($this->getId())) {
            $sql = "UPDATE {$this->table} SET title = :title, description = :description, content = :content, slug = :slug, is_main = :is_main, creator_id = :creator_id WHERE id = :id";
            $queryPrepared = $this->pdo->prepare($sql);
            $queryPrepared->execute([
                ':title' => $this->getTitle(),
                ':description' => $this->getDescription(),
                ':content' => $this->getContent(),
                ':slug' => $this->getSlug(),
                ':is_main'  => $isMain,
                ':creator_id' => $this->getCreatorId(),
                ':id' => $this->getId(),
            ]);
        } else {
            $sql = "INSERT INTO {$this->table} (title, description, content, slug, is_main, creator_id) VALUES (:title, :description, :content, :slug, :is_main, :creator_id)";
            $queryPrepared = $this->pdo->prepare($sql);
            $queryPrepared->execute([
                ':title' => $this->getTitle(),
                ':description' => $this->getDescription(),
                ':content' => $this->getContent(),
                ':slug' => $this->getSlug(),
                ':is_main' => $isMain,
                ':creator_id' => $this->getCreatorId(),
            ]);
            $this->id = $this->pdo->lastInsertId();
        }
    }

    public function count(): int
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();
        $result = $queryPrepared->fetch(\PDO::FETCH_ASSOC);
        return (int) $result['count'];
    }
}
