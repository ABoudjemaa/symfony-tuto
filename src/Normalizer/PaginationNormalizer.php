<?php

namespace App\Normalizer;

use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PaginationNormalizer implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private readonly NormalizerInterface $normalizer
    )
    {
    }

    public function normalize(mixed $data, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        return [
            'items' => array_map(
                fn($item) => $this->normalizer->normalize($item, $format, $context),
                $data->getItems()
            ),
            'totalItems' => $data->getTotalItemCount(),
            'itemsPerPage' => $data->getItemNumberPerPage(),
            'currentPage' => $data->getCurrentPageNumber(),
            'totalPages' => $data->getPageCount(),
        ];
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof PaginationInterface && $format === 'json';
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            PaginationInterface::class => true
        ];
    }
}