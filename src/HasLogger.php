<?php declare(strict_types=1);

namespace Tkui;

use Psr\Log\LoggerInterface;

/**
 * Adds logger support.
 */
trait HasLogger
{
    private ?LoggerInterface $logger = null;

    public function getLogger(): ?LoggerInterface
    {
        return $this->logger;
    }

    public function setLogger(?LoggerInterface $logger): self
    {
        $this->logger = $logger;
        return $this;
    }

    protected function debug(string $message, array $context = []): void
    {
        // TODO: PHP8 $this->logger?->debug(...)
        if ($this->logger) {
            $this->logger->debug($message, $context);
        }
    }

    protected function info(string $message, array $context = []): void
    {
        // TODO: PHP8 $this->logger?->debug(...)
        if ($this->logger) {
            $this->logger->info($message, $context);
        }
    }
}