<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Book;
use App\Entity\Testament;
use App\Entity\Verse;
use App\Entity\Version;

interface BibleRepositoryInterface
{
    /**
     * Summary of getVersions
     * @return Version[]
     */
    public function getVersions(): array;

    /**
     * Summary of getVersionById
     * @param int $id
     * @return Version|null
     */
    public function getVersionById(int $id): ?Version;

    /**
     * Summary of getTestaments
     * @return Testament[]
     */
    public function getTestaments(): array;

    /**
     * Summary of getBooks
     * @return Book[]
     */
    public function getBooks(): array;

    /**
     * Summary of getBookById
     * @param int $id
     * @return Book|null
     */
    public function getBookById(int $id): ?Book;

    /**
     * Summary of getChaptersCount
     * @param int $bookId
     * @return int
     */
    public function getChaptersCount(int $bookId): int;

    /**
     * Summary of getVersesCount
     * @param int $versionId
     * @param int $bookId
     * @param int $chapter
     * @return int
     */
    public function getVersesCount(int $versionId, int $bookId, int $chapter): int;

    /**
     * Summary of getVerses
     * @param int $versionId
     * @param int $bookId
     * @param int $chapter
     * @return Verse[]
     */
    public function getVerses(int $versionId, int $bookId, int $chapter): array;

    /**
     * Summary of getVerse
     * @param int $versionId
     * @param int $bookId
     * @param int $chapter
     * @param int $verse
     * @return Verse|null
     */
    public function getVerse(int $versionId, int $bookId, int $chapter, int $verse): ?Verse;

    /**
     * Summary of compareChapter
     * Compare chapter across multiple versions (up to 3 or more).
     *
     * @param int[] $versionIds
     * @param int $bookId
     * @param int $chapter
     * @return array<int, array<int, Verse|null>>
     */
    public function compareChapter(array $versionIds, int $bookId, int $chapter): array;

    /**
     * Summary of getColumnsVerses
     * Compare verses independently for multi-column comparison.
     *
     * @param array<int, array{versionId: int, bookId: int, chapter: int}> $columnsConfig
     * @return array<int, Verse[]>
     */
    public function getColumnsVerses(array $columnsConfig): array;

    /**
     * Summary of search
     * Search text in a Bible version.
     *
     * @param int $versionId
     * @param string $query
     * @param int $limit
     * @return array<int, array{verse: Verse, book: Book, version: Version}>
     */
    public function search(int $versionId, string $query, int $limit = 50): array;
}
