<?php declare(strict_types=1);

namespace Tkui\TclTk;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Tkui\AppFactory;
use Tkui\Environment;
use Tkui\Exceptions\UnsupportedOSException;
use Tkui\System\FFILoader;
use Tkui\System\OS;

/**
 * Tk implementation of Application Factory.
 */
class TkAppFactory implements AppFactory
{
    const TCL_HEADER = 'tcl86.h';
    const TK_HEADER = 'tk86.h';

    const LINUX_LIB_TCL = 'libtcl8.6.so';
    const LINUX_LIB_TK = 'libtk8.6.so';

    const WINDOWS_LIB_TCL = 'tcl86t.dll';
    const WINDOWS_LIB_TK = 'tk86t.dll';

    const DEFAULT_WIN_THEME = 'vista';
    const DEFAULT_THEME = 'clam';

    private string $defaultTclHeader;
    private string $defaultTkHeader;

    private string $appName;

    /**
     * @param string $appName The application name (or class name in some desktop environments).
     */
    public function __construct(string $appName)
    {
        $this->appName = $appName;
        $this->defaultTclHeader = $this->getHeaderPath(self::TCL_HEADER);
        $this->defaultTkHeader = $this->getHeaderPath(self::TK_HEADER);
    }

    protected function getHeaderPath(string $file): string
    {
        return dirname(__DIR__)
            . DIRECTORY_SEPARATOR
            . 'headers'
            . DIRECTORY_SEPARATOR
            . $file
        ;
    }

    /**
     * @inheritdoc
     */
    public function createFromEnvironment(Environment $env): TkApplication
    {
        if (($libTcl = $env->getValue(sprintf('%s_LIB_TCL', OS::family()))) === null) {
            $libTcl = $this->getDefaultTclLib();
        }
        if (($libTk = $env->getValue(sprintf('%s_LIB_TK', OS::family()))) === null) {
            $libTk = $this->getDefaultTkLib();
        }

        $interp = $this->createTcl(
                $env->getValue('TCL_HEADER', $this->defaultTclHeader),
                $libTcl
            )
            ->createInterp();

        if (($debug = (bool) $env->getValue('DEBUG'))) {
            $logger = $this->createLogger($env->getValue('DEBUG_LOG', 'php://stdout'));
        }

        if ($debug) {
            $interp->setLogger($logger->withName('interp'));
        }

        $tk = $this->createTk(
            $interp,
            $env->getValue('TK_HEADER', $this->defaultTkHeader),
            $libTk
        );
        
        $app = new TkApplication($tk, [
            '-name' => $env->getValue('APP_NAME', $this->appName),
        ]);

        if ($debug) {
            $app->setLogger($logger->withName('app'));
        }

        $app->init();

        if (($theme = $env->getValue('THEME', 'auto'))) {
            $app->getThemeManager()->useTheme($this->getTheme($theme));
        }

        return $app;
    }

    protected function createTcl(string $header, string $sharedLib): Tcl
    {
        $loader = new FFILoader($header, $sharedLib);
        return new Tcl($loader->load());
    }

    protected function createTk(Interp $tclInterp, string $header, string $sharedLib): Tk
    {
        $loader = new FFILoader($header, $sharedLib);
        return new Tk($loader->load(), $tclInterp);
    }

    /**
     * @inheritdoc
     */
    public function create(): TkApplication
    {
        $interp = $this->createTcl(self::TCL_HEADER, $this->getDefaultTclLib())->createInterp();
        $tk = $this->createTk($interp, self::TK_HEADER, $this->getDefaultTkLib());
        
        $app = new TkApplication($tk, [
            '-name' => $this->appName,
        ]);

        $app->init();
        
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

    protected function getDefaultTclLib(): string
    {
        switch (OS::family()) {
            case 'WINDOWS':
                return self::WINDOWS_LIB_TCL;

            case 'LINUX':
                return self::LINUX_LIB_TCL;
        }

        throw new UnsupportedOSException();
    }

    protected function getDefaultTkLib(): string
    {
        switch (OS::family()) {
            case 'WINDOWS':
                return self::WINDOWS_LIB_TK;

            case 'LINUX':
                return self::LINUX_LIB_TK;
        }

        throw new UnsupportedOSException();
    }

    protected function getTheme(string $theme): string
    {
        return strtolower($theme) === 'auto'
            ? (OS::family() === 'WINDOWS' ? self::DEFAULT_WIN_THEME : self::DEFAULT_THEME)
            : $theme;
    }
}