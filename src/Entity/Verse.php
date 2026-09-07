<?php

declare(strict_types=1);

namespace App\Entity;

final class Verse
{
    /**
     * Summary of __construct
     * @param int $id
     * @param int $versionId
     * @param int $bookId
     * @param int $chapter
     * @param int $verse
     * @param string $text
     */
    public function __construct(
        public readonly int $id,
        public readonly int $versionId,
        public readonly int $bookId,
        public readonly int $chapter,
        public readonly int $verse,
        public readonly string $text,
    ) {
    }

    /**
     * Summary of fromArray
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $rawText = (string) $data['text'];
        if (str_contains($rawText, '&')) {
            $rawText = html_entity_decode($rawText, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }

        return new self(
            id: (int) $data['id'],
            versionId: (int) $data['version_id'],
            bookId: (int) $data['book_id'],
            chapter: (int) $data['chapter'],
            verse: (int) $data['verse'],
            text: $rawText,
        );
    }
}
