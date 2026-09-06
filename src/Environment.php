<?php

declare(strict_types=1);

namespace App;

use RuntimeException;

use function in_array;
use function sprintf;

final class Environment
{
    public const DEV = 'dev';
    public const TEST = 'test';
    public const PROD = 'prod';

    public const ENVIRONMENTS = [
        self::DEV,
        self::TEST,
        self::PROD,
    ];

    private static array $values = [];

    /**
     * Summary of prepare
     * @return void
     */
    public static function prepare(): void
    {
        self::setEnvironment();
        self::setBoolean('APP_DEBUG', true);
        self::setString('DB_DRIVER', 'pgsql');
        self::setString('DB_HOST', '127.0.0.1');
        self::setString('DB_PORT', '5432');
        self::setString('DB_NAME', 'holybible');
        self::setString('DB_USER', 'postgres');
        self::setString('DB_PASSWORD', 'postgres');
    }

    /**
     * Summary of appEnv
     * @return non-empty-string
     */
    public static function appEnv(): string
    {
        /** @var non-empty-string */
        return self::$values['APP_ENV'];
    }

    /**
     * Summary of isDev
     * @return bool
     */
    public static function isDev(): bool
    {
        return self::appEnv() === self::DEV;
    }

    /**
     * Summary of isTest
     * @return bool
     */
    public static function isTest(): bool
    {
        return self::appEnv() === self::TEST;
    }

    /**
     * Summary of isProd
     * @return bool
     */
    public static function isProd(): bool
    {
        return self::appEnv() === self::PROD;
    }

    /**
     * Summary of appDebug
     * @return bool
     */
    public static function appDebug(): bool
    {
        /** @var bool */
        return self::$values['APP_DEBUG'] ?? true;
    }

    /**
     * Summary of get
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return self::$values[$key] ?? self::getRawValue($key) ?? $default;
    }

    /**
     * Summary of setEnvironment
     * @throws RuntimeException
     * @return void
     */
    private static function setEnvironment(): void
    {
        $environment = self::getRawValue('APP_ENV') ?: self::DEV;

        if (!in_array($environment, self::ENVIRONMENTS, true)) {
            throw new RuntimeException(
                sprintf(
                    'APP_ENV="%s" is invalid. Valid values are "%s".',
                    $environment,
                    implode('", "', self::ENVIRONMENTS),
                ),
            );
        }

        self::$values['APP_ENV'] = $environment;
    }

    /**
     * Summary of setBoolean
     * @param string $key
     * @param bool $default
     * @return void
     */
    private static function setBoolean(string $key, bool $default): void
    {
        $value = self::getRawValue($key);
        self::$values[$key] = $value === null
            ? $default
            : (filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? $default);
    }

    /**
     * Summary of setString
     * @param string $key
     * @param string $default
     * @return void
     */
    private static function setString(string $key, string $default): void
    {
        $value = self::getRawValue($key);
        self::$values[$key] = $value ?? $default;
    }

    /**
     * Summary of getRawValue
     * @param string $key
     * @return string|null
     */
    private static function getRawValue(string $key): ?string
    {
        $value = getenv($key, true);
        if ($value !== false) {
            return $value;
        }

        $value = getenv($key);
        if ($value !== false) {
            return $value;
        }

        return isset($_ENV[$key]) ? (string) $_ENV[$key] : null;
    }
}
