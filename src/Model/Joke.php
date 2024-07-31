<?php

namespace App\Model;
class Joke
{
    private string $value;
    private string $iconUrl;

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function getIconUrl(): string
    {
        return $this->iconUrl;
    }

    public function setIconUrl(string $iconUrl): void
    {
        $this->iconUrl = $iconUrl;
    }


}