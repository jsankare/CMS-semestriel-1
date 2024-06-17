<?php

namespace App\Models;

use App\Core\SQL;

class Comment extends SQL
{
    private ?int $id = null;
    protected int $article_id;
    protected int $user_id;
    protected string $content;
    protected string $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticleId(): int
    {
        return $this->article_id;
    }

    public function setArticleId(int $article_id): void
    {
        $this->article_id = $article_id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getTitle(): string
    {
        $article = (new Article())->findOneById($this->article_id);
        return $article ? $article->getTitle() : 'Article non trouvé';
    }

    public function findOneById(string $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute([":id" => $id]);
        $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, 'App\Models\Comment');
        return $queryPrepared->fetch();
    }

    public function findAll()
    {
        $sql = "SELECT * FROM {$this->table}";

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();
        $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, 'App\Models\Comment');
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
            $sql = "UPDATE {$this->table} SET article_id = :article_id, user_id = :user_id, content = :content, status = :status WHERE id = :id";
            $queryPrepared = $this->pdo->prepare($sql);
            $queryPrepared->execute([
                ':article_id' => $this->getArticleId(),
                ':user_id' => $this->getUserId(),
                ':content' => $this->getContent(),
                ':status' => $this->getStatus(),
                ':id' => $this->getId(),
            ]);
        } else {
            $sql = "INSERT INTO {$this->table} (article_id, user_id, content, status) VALUES (:article_id, :user_id, :content, :status)";
            $queryPrepared = $this->pdo->prepare($sql);
            $queryPrepared->execute([
                ':article_id' => $this->getArticleId(),
                ':user_id' => $this->getUserId(),
                ':content' => $this->getContent(),
                ':status' => $this->getStatus(),
            ]);
            $this->id = $this->pdo->lastInsertId();
        }
    }

    public function findCommentsByUserId(int $userId): array
    {
        $sql = "SELECT c.*, a.title AS article_title 
                FROM esgi_comment c
                INNER JOIN esgi_article a ON c.article_id = a.id 
                WHERE c.user_id = :user_id";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute(['user_id' => $userId]);
        return $queryPrepared->fetchAll(\PDO::FETCH_ASSOC);
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
