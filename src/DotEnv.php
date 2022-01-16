<?php declare(strict_types=1);

namespace Tkui;

use RuntimeException;
use M1\Env\Parser as EnvParser;

/**
 * .env file environment loader.
 */
final class DotEnv implements Environment
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
     * Resets the previous environment and loads a new one.
     *
     * @throws RuntimeException When the env file cannot be read or parsed.
     */
    public function load(): void
    {
        $this->data = [];

        $file = $this->path . DIRECTORY_SEPARATOR . $this->filename;
        if (! file_exists($file)) {
            return;
        }

        if (! is_readable($file)) {
            throw new RuntimeException(sprintf('File "%s" is not readable.', $file));
        }

        if (($buf = @file_get_contents($file)) === false) {
            throw new RuntimeException("Couldn't read file: " . $file);
        }
        $this->data = EnvParser::parse($buf);
    }

    /**
     * Loads the environment and override values.
     */
    public function loadAndMergeWith(array $override): void
    {
        $this->load();
        $this->data = array_merge($this->data, $override);
    }

    /**
     * @inheritdoc
     */
    public function getValue(string $param, $default = null)
    {
        return $this->data[$param] ?? $default;
    }

    /**
     * Creates and loads environment.
     *
     * @param string $dst Could be an env filename or directory where .env is located.
     */
    public static function create(string $dst): self
    {
        if (is_dir($dst)) {
            $env = new static($dst);
        } else {
            $env = new static(dirname($dst), basename($dst));
        }

        $env->load();

        return $env;
    }
}