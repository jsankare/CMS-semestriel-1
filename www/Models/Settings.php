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

}