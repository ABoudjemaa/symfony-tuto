<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class PaginationTDO
{
    public function __construct(
        #[Assert\Positive()]
        public ?int $page = 1,
    )
    {
    }

}