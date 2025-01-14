<?php

namespace App\DTO;

readonly class  CategoryWithCountTDO
{
    public function __construct(
        public int    $id,
        public string $name,
        public int    $count
    )
    {
    }
}