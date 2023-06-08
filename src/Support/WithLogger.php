<?php declare(strict_types=1);

namespace Tkui\Support;

use Psr\Log\LoggerInterface;

/**
 * Adds logger support.
 */
trait WithLogger
{
    private ?LoggerInterface $logger = null;

    public function getLogger(): ?LoggerInterface
    {
        return $this->logger;
    }

    public function setLogger(?LoggerInterface $logger): static
    {
        $this->logger = $logger;
        return $this;
    }

    protected function debug(string $message, array $context = []): void
    {
        $this->logger?->debug($message, $context);
    }

    protected function info(string $message, array $context = []): void
    {
        $this->logger?->info($message, $context);
    }

    protected function error(string $message, array $context = []): void
    {
        $this->logger?->error($message, $context);
    }

    protected function warning(string $message, array $context = []): void
    {
        $this->logger?->warning($message, $context);
    }
}
