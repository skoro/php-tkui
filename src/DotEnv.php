<?php declare(strict_types=1);

namespace Tkui;

use RuntimeException;

/**
 * .env file environment loader.
 */
final class DotEnv implements Environment
{
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
    }

    /**
     * Resets the previous environment and loads a new one.
     *
     * @throws RuntimeException When the env file cannot be read or parsed.
     */
    public function load(): void
    {
        $file = $this->path . DIRECTORY_SEPARATOR . $this->filename;
        if (! file_exists($file)) {
            return;
        }

        if (! is_readable($file)) {
            throw new RuntimeException(sprintf('File "%s" is not readable.', $file));
        }

        $dotenv = \Dotenv\Dotenv::createImmutable($this->path, $this->filename);
        $dotenv->safeLoad();
    }

    /**
     * Loads the environment and override values.
     */
    public function loadAndMergeWith(array $override): void
    {
        $this->load();
        foreach ($override as $k => $v) {
            $_ENV[$k] = $v;
        }
    }

    /**
     * @inheritdoc
     */
    public function getValue(string $param, $default = null)
    {
        $value = $_ENV[$param] ?? $default;
        switch (strtolower($value)) {
            case 'true':
                return true;
            case 'false':
                return false;
        }
        return $value;
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