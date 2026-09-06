<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\BibleRepositoryInterface;
use HttpSoft\Message\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Yii\View\Renderer\WebViewRenderer;

final class BibleController
{
    /**
     * Summary of __construct
     * @param \App\Repository\BibleRepositoryInterface $bibleRepo
     * @param \Yiisoft\Yii\View\Renderer\WebViewRenderer $viewRenderer
     * @param \Yiisoft\Router\UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        private readonly BibleRepositoryInterface $bibleRepo,
        private readonly WebViewRenderer $viewRenderer,
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    /**
     * Summary of index
     * @param ServerRequestInterface $request
     * @param CurrentRoute $currentRoute
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request, CurrentRoute $currentRoute): ResponseInterface
    {
        $queryParams = $request->getQueryParams();

        $versionId = (int) ($queryParams['v'] ?? 2); // Default: ACRF (Almeida Corrigida e Fiel)
        $bookId = (int) ($queryParams['b'] ?? 1);     // Default: Genesis
        $chapter = (int) ($queryParams['c'] ?? 1);    // Default: Chapter 1
        $highlightVerse = isset($queryParams['verse']) ? (int) $queryParams['verse'] : null;

        $versions = $this->bibleRepo->getVersions();
        $testaments = $this->bibleRepo->getTestaments();
        $books = $this->bibleRepo->getBooks();

        $currentVersion = $this->bibleRepo->getVersionById($versionId) ?? $versions[0] ?? null;
        $currentBook = $this->bibleRepo->getBookById($bookId) ?? $books[0] ?? null;

        $totalChapters = $currentBook ? $this->bibleRepo->getChaptersCount($currentBook->id) : 50;
        if ($chapter < 1) {
            $chapter = 1;
        }
        if ($chapter > $totalChapters && $totalChapters > 0) {
            $chapter = $totalChapters;
        }

        $verses = $this->bibleRepo->getVerses($currentVersion->id, $currentBook->id, $chapter);

        // Previous and next navigation
        $prevLink = null;
        $nextLink = null;

        if ($chapter > 1) {
            $prevLink = ['b' => $currentBook->id, 'c' => $chapter - 1, 'v' => $currentVersion->id];
        } elseif ($currentBook->id > 1) {
            $prevBook = $this->bibleRepo->getBookById($currentBook->id - 1);
            if ($prevBook) {
                $prevBookChapters = $this->bibleRepo->getChaptersCount($prevBook->id);
                $prevLink = ['b' => $prevBook->id, 'c' => $prevBookChapters, 'v' => $currentVersion->id];
            }
        }

        if ($chapter < $totalChapters) {
            $nextLink = ['b' => $currentBook->id, 'c' => $chapter + 1, 'v' => $currentVersion->id];
        } elseif ($currentBook->id < count($books)) {
            $nextBook = $this->bibleRepo->getBookById($currentBook->id + 1);
            if ($nextBook) {
                $nextLink = ['b' => $nextBook->id, 'c' => 1, 'v' => $currentVersion->id];
            }
        }

        return $this->viewRenderer->render('bible/index', [
            'versions' => $versions,
            'testaments' => $testaments,
            'books' => $books,
            'currentVersion' => $currentVersion,
            'currentBook' => $currentBook,
            'chapter' => $chapter,
            'totalChapters' => $totalChapters,
            'verses' => $verses,
            'highlightVerse' => $highlightVerse,
            'prevLink' => $prevLink,
            'nextLink' => $nextLink,
            'urlGenerator' => $this->urlGenerator,
            'currentRoute' => $currentRoute,
        ]);
    }

    /**
     * Summary of compare
     * @param ServerRequestInterface $request
     * @param CurrentRoute $currentRoute
     * @return ResponseInterface
     */
    public function compare(ServerRequestInterface $request, CurrentRoute $currentRoute): ResponseInterface
    {
        $queryParams = $request->getQueryParams();

        $numColumns = (int) ($queryParams['cols'] ?? 3);
        if ($numColumns < 1)
            $numColumns = 1;
        if ($numColumns > 3)
            $numColumns = 3;

        $v1 = (int) ($queryParams['v1'] ?? 2); // ACRF
        $v2 = (int) ($queryParams['v2'] ?? 3); // NVI
        $v3 = (int) ($queryParams['v3'] ?? 8); // KJV

        $selectedVersionIds = array_slice([$v1, $v2, $v3], 0, $numColumns);

        $bookId = (int) ($queryParams['b'] ?? 1);
        $chapter = (int) ($queryParams['c'] ?? 1);
        $highlightVerse = isset($queryParams['verse']) ? (int) $queryParams['verse'] : null;
        $viewMode = $queryParams['mode'] ?? 'columns'; // 'columns' (side-by-side) or 'verses' (verse by verse)

        $versions = $this->bibleRepo->getVersions();
        $testaments = $this->bibleRepo->getTestaments();
        $books = $this->bibleRepo->getBooks();

        $currentBook = $this->bibleRepo->getBookById($bookId) ?? $books[0] ?? null;
        $totalChapters = $currentBook ? $this->bibleRepo->getChaptersCount($currentBook->id) : 50;
        if ($chapter < 1)
            $chapter = 1;
        if ($chapter > $totalChapters && $totalChapters > 0)
            $chapter = $totalChapters;

        // Selected version objects
        $selectedVersions = [];
        foreach ($selectedVersionIds as $vId) {
            $selectedVersions[$vId] = $this->bibleRepo->getVersionById($vId) ?? $versions[0];
        }

        // Compare grouped verses
        $comparedVerses = $this->bibleRepo->compareChapter($selectedVersionIds, $currentBook->id, $chapter);

        // Columns data for side-by-side mode
        $columnsData = [];
        foreach ($selectedVersionIds as $vId) {
            $columnsData[$vId] = $this->bibleRepo->getVerses($vId, $currentBook->id, $chapter);
        }

        return $this->viewRenderer->render('bible/compare', [
            'versions' => $versions,
            'testaments' => $testaments,
            'books' => $books,
            'selectedVersions' => $selectedVersions,
            'selectedVersionIds' => $selectedVersionIds,
            'currentBook' => $currentBook,
            'chapter' => $chapter,
            'totalChapters' => $totalChapters,
            'highlightVerse' => $highlightVerse,
            'comparedVerses' => $comparedVerses,
            'columnsData' => $columnsData,
            'numColumns' => $numColumns,
            'viewMode' => $viewMode,
            'v1' => $v1,
            'v2' => $v2,
            'v3' => $v3,
            'urlGenerator' => $this->urlGenerator,
            'currentRoute' => $currentRoute,
        ]);
    }

    /**
     * Summary of search
     * @param ServerRequestInterface $request
     * @param CurrentRoute $currentRoute
     * @return ResponseInterface
     */
    public function search(ServerRequestInterface $request, CurrentRoute $currentRoute): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $query = (string) ($queryParams['q'] ?? '');
        $versionId = (int) ($queryParams['v'] ?? 2);

        $versions = $this->bibleRepo->getVersions();
        $currentVersion = $this->bibleRepo->getVersionById($versionId) ?? $versions[0];

        $results = [];
        if (trim($query) !== '') {
            $results = $this->bibleRepo->search($currentVersion->id, $query, 100);
        }

        return $this->viewRenderer->render('bible/search', [
            'versions' => $versions,
            'currentVersion' => $currentVersion,
            'query' => $query,
            'results' => $results,
            'urlGenerator' => $this->urlGenerator,
            'currentRoute' => $currentRoute,
        ]);
    }

    /**
     * Summary of apiChapters
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function apiChapters(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $bookId = (int) ($queryParams['b'] ?? 1);
        $count = $this->bibleRepo->getChaptersCount($bookId);

        $response = new Response();
        $response->getBody()->write((string) json_encode(['bookId' => $bookId, 'chapters' => $count]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
