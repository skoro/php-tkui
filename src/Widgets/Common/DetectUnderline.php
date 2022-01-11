<?php declare(strict_types=1);

namespace Tkui\Widgets\Common;

/**
 * Helper for detecting index for the "underline" property.
 */
trait DetectUnderline
{
    /**
     * Disable if detection is not needed.
     */
    protected bool $enableAutoUnderline = true;

    /**
     * Use the specific character for getting the index.
     */
    protected string $underlineChar = '_';

    /**
     * Removes the underline character from the given string.
     *
     * @param string $value The string with underline character.
     *
     * @return string A new string with removed underline character.
     */
    protected function removeUnderlineChar(string $value): string
    {
        if (($idx = $this->detectUnderlineIndex($value)) === null) {
            return $value;
        }
        return ($idx > 0 ? mb_substr($value, 0, $idx) : '') . mb_substr($value, $idx + 1);
    }

    /**
     * Detects the underline index from the given string.
     *
     * @return null|int A positive value of the underline index or NULL.
     */
    protected function detectUnderlineIndex(string $value): ?int
    {
        if (! $this->enableAutoUnderline) {
            return null;
        }

        if (($p = mb_strpos($value, $this->underlineChar)) === false) {
            return null;
        }

        if ($p >= mb_strlen($value)) {
            return null;
        }

        if (mb_substr($value, $p, 2) === $this->underlineChar . $this->underlineChar) {
            return null;
        }

        return $p;
    }
}