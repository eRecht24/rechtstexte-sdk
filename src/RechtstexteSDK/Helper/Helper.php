<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Helper;

abstract class Helper
{
    const ALLOWED_PUSH_TYPES = [
        'ping',
        'imprint',
        'privacyPolicy',
        'privacyPolicySocialMedia',
    ];

    const PING_RESPONSE = [
        'code'    => 200,
        'message' => 'pong'
    ];


        /**
     * Convert a value to studly caps case.
     *
     * @param string $value
     * @return string
     */
    public static function studly(string $value): string
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $value));

        return str_replace(' ', '', $value);
    }

    /**
     * Checks if $type is a valid push type
     *
     * @param string $type
     * @return bool
     */
    public static function isValidPushType(string $type): bool
    {
        return in_array($type, self::ALLOWED_PUSH_TYPES);
    }
}