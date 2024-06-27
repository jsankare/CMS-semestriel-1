<?php

namespace App\Models;

use App\Core\SQL;

class Settings extends SQL
{
    private ?int $id=null;
    protected ?string $font_color=null;
    protected ?string $background_color=null;
    protected ?string $font_style=null;

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
    public function getFontColor(): ?string
    {
        return $this->font_color;
    }

    /**
     * @param string $font_color
     */
    public function setFontColor(string $font_color): void
    {
        $this->font_color = trim($font_color);
    }

    /**
     * @return string
     */
    public function getBackgroundColor(): ?string
    {
        return $this->background_color;
    }

    /**
     * @param string $background_color
     */
    public function setBackgroundColor(string $background_color): void
    {
        $this->background_color = trim($background_color);
    }

    /**
     * @return string
     */
    public function getFontStyle(): ?string
    {
        return $this->font_style;
    }

    /**
     * @param string $font_style
     */
    public function setFontStyle(string $font_style): void
    {
        $this->font_style = ucwords(strtolower($font_style));
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