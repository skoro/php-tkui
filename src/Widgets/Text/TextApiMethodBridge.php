<?php declare(strict_types=1);

namespace Tkui\Widgets\Text;

/**
 * Provides the bridge method to text api.
 *
 * In terms of Tk there are subcommands that handle dependent text feature.
 */
interface TextApiMethodBridge
{
    /**
     * Calls the text widget method.
     *
     * @return mixed
     */
    public function callMethod(...$args);
}
