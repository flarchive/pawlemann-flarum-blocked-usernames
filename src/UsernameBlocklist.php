<?php

namespace Rysstad\BlockedUsernames;

class UsernameBlocklist
{
    /**
     * Turn the raw textarea value into a list of lowercase entries.
     * Entries are separated by new lines or commas. Blank entries are dropped.
     *
     * @return string[]
     */
    public static function parse(?string $raw): array
    {
        if ($raw === null || trim($raw) === '') {
            return [];
        }

        $entries = preg_split('/[\r\n,]+/', $raw) ?: [];
        $entries = array_map(fn (string $entry) => mb_strtolower(trim($entry)), $entries);

        return array_values(array_unique(array_filter($entries, fn (string $entry) => $entry !== '')));
    }

    /**
     * Whether a username matches any entry. Matching is case-insensitive.
     * An asterisk in an entry matches any run of characters, e.g. "admin*"
     * blocks "admin", "admin1" and "administrator".
     *
     * @param string[] $entries
     */
    public static function isBlocked(string $username, array $entries): bool
    {
        $username = mb_strtolower(trim($username));

        foreach ($entries as $entry) {
            if (! str_contains($entry, '*')) {
                if ($username === $entry) {
                    return true;
                }

                continue;
            }

            $pattern = '/^'.str_replace('\*', '.*', preg_quote($entry, '/')).'$/u';

            if (preg_match($pattern, $username) === 1) {
                return true;
            }
        }

        return false;
    }
}
