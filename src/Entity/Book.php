<?php

declare(strict_types=1);

namespace App\Entity;

final class Book
{
    /**
     * Summary of __construct
     * @param int $id
     * @param int $testamentId
     * @param int $position
     * @param string $name
     * @param string $abbreviation
     * @param string $namePt
     * @param string $abbreviationPt
     * @param int $chaptersCount
     */
    public function __construct(
        public readonly int $id,
        public readonly int $testamentId,
        public readonly int $position,
        public readonly string $name,
        public readonly string $abbreviation,
        public readonly string $namePt = '',
        public readonly string $abbreviationPt = '',
        public readonly int $chaptersCount = 0,
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
            testamentId: (int) $data['testament_id'],
            position: (int) $data['position'],
            name: (string) ($data['name'] ?? ''),
            abbreviation: (string) ($data['abbreviation'] ?? ''),
            namePt: (string) ($data['name_pt'] ?? $data['name'] ?? ''),
            abbreviationPt: (string) ($data['abbreviation_pt'] ?? $data['abbreviation'] ?? ''),
            chaptersCount: (int) ($data['chapters_count'] ?? 0),
        );
    }

    /**
     * Summary of getDisplayName
     * @param string $lang
     * @return string
     */
    public function getDisplayName(string $lang = 'pt'): string
    {
        if ($lang === 'en') {
            return $this->name ?: $this->namePt;
        }
        return $this->namePt ?: $this->name;
    }

    /**
     * Summary of getDisplayAbbreviation
     * @param string $lang
     * @return string
     */
    public function getDisplayAbbreviation(string $lang = 'pt'): string
    {
        if ($lang === 'en') {
            return $this->abbreviation ?: $this->abbreviationPt;
        }
        return $this->abbreviationPt ?: $this->abbreviation;
    }
}
