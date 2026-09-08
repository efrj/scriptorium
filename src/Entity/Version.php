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

    /**
     * Summary of getLanguageName
     * @return string
     */
    public function getLanguageName(): string
    {
        return match (strtolower($this->language)) {
            'pt' => 'Português',
            'en' => 'English',
            'es' => 'Español',
            'de' => 'Deutsch (Alemão)',
            'fr' => 'Français (Francês)',
            'it' => 'Italiano',
            'la' => 'Latina (Latim)',
            'ru' => 'Русский (Russo)',
            'zh' => '中文 (Chinês)',
            'ja' => '日本語 (Japonês)',
            'ko' => '한국어 (Coreano)',
            'he' => 'עברית (Hebraico)',
            'nl' => 'Nederlands (Holandês)',
            'cs' => 'Čeština (Tcheco)',
            'da' => 'Dansk (Dinamarquês)',
            'sv' => 'Svenska (Sueco)',
            'no' => 'Norsk (Norueguês)',
            'fi' => 'Suomi (Finlandês)',
            'pl' => 'Polski (Polonês)',
            'hr' => 'Hrvatski (Croata)',
            'hu' => 'Magyar (Húngaro)',
            'ro' => 'Română (Romeno)',
            'bg' => 'Български (Búlgaro)',
            'sq' => 'Shqip (Albanês)',
            'tl' => 'Tagalog (Filipino)',
            'vi' => 'Tiếng Việt (Vietnamita)',
            'th' => 'ไทย (Tailandês)',
            'tr' => 'Türkçe (Turco)',
            'sw' => 'Kiswahili (Suaíli)',
            'lv' => 'Latviešu (Letão)',
            'mi' => 'Māori',
            'chr' => 'Cherokee',
            default => strtoupper($this->language),
        };
    }
}
