<?php

namespace App\Models;

use App\Core\SQL;

class Settings extends SQL
{
    private ?int $id=null;
    protected ?string $color=null;
    protected ?string $font=null;

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
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(string $color): void
    {
        $this->color = trim($color);
    }

    /**
     * @return string
     */
    public function getFont(): ?string
    {
        return $this->font;
    }

    /**
     * @param string $font
     */
    public function setFont(string $font): void
    {
        $this->font = ucwords(strtolower($font));
    }

    public function count(): int
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();
        $result = $queryPrepared->fetch(\PDO::FETCH_ASSOC);
        return (int) $result['count'];
    }

    public function findOneById(string $id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute([":id" => $id]);
        $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, 'App\Models\Settings');
        return $queryPrepared->fetch();
    }
}