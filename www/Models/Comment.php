<?php

namespace App\Models;

use App\Core\SQL;

class Comment extends SQL
{
    private ?int $id = null;
    protected int $article_id;
    protected int $user_id;
    protected string $content;

    protected int $status = 0;
    protected string $created_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreationDate(): ?string
    {
        return $this->created_at;
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
        $allowed_tags = '<h1><h2><h3><h4><h5><h6><p><b><i><u><strike><s><del><blockquote><center><code><ul><ol><li><a><img><div><span><br><strong><em>';
        $this->content = strip_tags($content, $allowed_tags);
    }

    
    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
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


    public function findCommentsByUserId(int $userId): array
    {   
        $sql = "SELECT c.*, a.title AS article_title FROM esgi_comment c INNER JOIN esgi_article a ON c.article_id = a.id WHERE c.user_id = :user_id";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute(['user_id' => $userId]);
        return $queryPrepared->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findCommentsByArticleId(int $articleId): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE article_id = :article_id";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute([':article_id' => $articleId]);
        return $queryPrepared->fetchAll(\PDO::FETCH_CLASS, 'App\Models\Comment');
    }

    public function count(): int
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();
        $result = $queryPrepared->fetch(\PDO::FETCH_ASSOC);
        return (int) $result['count'];
    }

    public function getUserName(): string
    {
        $user = (new User())->findOneById($this->user_id);
        return $user ? $user->getFirstname() . ' ' . $user->getLastname() : 'Utilisateur inconnu';
    }

    public function getFormattedDate(): string
    {
        if ($this->created_at) {
            try {
                $date = new \DateTime($this->created_at);
                return $date->format('d/m/Y à H:i');
            } catch (\Exception $e) {
                return 'Date invalide';
            }
        } else {
            return 'Date non définie';
        }
    }

    public function findArticleWithId(int $articleId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute([':id' => $articleId]);
        $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, 'App\Models\Article');
        return $queryPrepared->fetch();
    }
}
