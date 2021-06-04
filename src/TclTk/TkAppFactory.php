<?php declare(strict_types=1);

namespace PhpGui\TclTk;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PhpGui\AppFactory;
use PhpGui\Environment;
use PhpGui\FFILoader;

/**
 * Tk implementation of Application Factory.
 */
class TkAppFactory implements AppFactory
{
    /**
     * @inheritdoc
     */
    public function create(Environment $env): TkApplication
    {
        $loader = new FFILoader();
        $tcl = new Tcl($loader->loadTcl());
        $interp = $tcl->createInterp();

        if (($debug = (bool) $env->getValue('DEBUG'))) {
            $logger = $this->createLogger($env->getValue('DEBUG_LOG', 'php://stdout'));
        }

        if ($debug) {
            $interp->setLogger($logger->withName('interp'));
        }

        $tk = new Tk($loader->loadTk(), $interp);
        
        $app = new TkApplication($tk);
        if ($debug) {
            $app->setLogger($logger->withName('app'));
        }
        $app->init();

        if (($theme = $env->getValue('THEME'))) {
            $app->getThemeManager()->useTheme($theme);
        }

        return $app;
    }

    protected function createLogger(string $file): Logger
    {
        $log = new Logger('php-gui');
        // TODO: PHP8 use named arguments.
        $formatter = new LineFormatter(null, 'Y-m-d H:i:s', false, true);
        $stream = new StreamHandler($file, Logger::DEBUG);
        $stream->setFormatter($formatter);
        $log->pushHandler($stream);
        return $log;
    }
}