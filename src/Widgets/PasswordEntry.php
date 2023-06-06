<?php

declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Options;

/**
 * Password oriented entry.
 *
 * The same as entry but it shows "*" instead of typing character.
 */
class PasswordEntry extends Entry
{
    public function __construct(Container $parent, Options|array $options = [])
    {
        parent::__construct($parent, options: $options);
        $this->show = '*';
    }
}
