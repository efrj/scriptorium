<?php

declare(strict_types=1);

namespace App\Entity;

final class Testament
{
    /**
     * Summary of __construct
     * @param int $id
     * @param string $name
     * @param string $namePt
     */
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $namePt = '',
    ) {
    }

    /**
     * Summary of fromArray
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            name: (string) ($data['name'] ?? ''),
            namePt: (string) ($data['name_pt'] ?? $data['name'] ?? ''),
        );
    }
}
