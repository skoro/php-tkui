<?php declare(strict_types=1);

namespace TclTk;

use RuntimeException;

/**
 * .env file environment loader.
 */
class DotEnv implements Environment
{
    private array $data;
    private string $path;
    private string $filename;

    /**
     * @param string $path     The directory where the env file is located.
     * @param string $filename The env file base name.
     */
    public function __construct(string $path, string $filename = '.env')
    {
        $this->path = $path;
        $this->filename = $filename;
        $this->data = [];
    }

    /**
     * @throws RuntimeException When the env file cannot be read or parsed.
     */
    public function load(): void
    {
        $file = $this->path . DIRECTORY_SEPARATOR . $this->filename;
        if (! file_exists($file)) {
            $this->data = [];
            return;
        }

        if (! is_readable($file)) {
            throw new RuntimeException('Cannot read file: ' . $file);
        }

        if (($this->data = parse_ini_file($file, false)) === false) {
            throw new RuntimeException('Cannot parse file: ' . $file);
        }
    }

    /**
     * Loads the environment and override values.
     */
    public function loadAndMergeWith(array $override): void
    {
        $this->load();
        array_merge($this->data, $override);
    }

    /**
     * @inheritdoc
     */
    public function getEnv(string $param, $default = null)
    {
        return $this->data[$param] ?? $default;
    }
}