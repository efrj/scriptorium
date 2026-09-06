<?php

declare(strict_types=1);

namespace App\Entity;

final class Version
{
    /**
     * Summary of __construct
     * @param int $id
     * @param string $code
     * @param string $name
     * @param string $language
     */
    public function __construct(
        public readonly int $id,
        public readonly string $code,
        public readonly string $name,
        public readonly string $language,
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
            code: (string) ($data['code'] ?? ''),
            name: (string) ($data['name'] ?? ''),
            language: (string) ($data['language'] ?? 'pt'),
        );
    }

    /**
     * Summary of getFullTitle
     * @return string
     */
    public function getFullTitle(): string
    {
        return sprintf('[%s] %s (%s)', $this->code, $this->name, strtoupper($this->language));
    }
}
