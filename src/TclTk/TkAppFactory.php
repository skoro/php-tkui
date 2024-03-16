<?php

declare(strict_types=1);

namespace Tkui\TclTk;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Tkui\AppFactory;
use Tkui\Environment;
use Tkui\Exceptions\UnsupportedOSException;
use Tkui\System\FFILoader;
use Tkui\System\OS;
use Tkui\System\OSDetection;

/**
 * Tk implementation of Application Factory.
 */
class TkAppFactory implements AppFactory
{
    const TCL_HEADER = 'tcl86.h';
    const TK_HEADER = 'tk86.h';

    private readonly string $defaultTclHeader;
    private readonly string $defaultTkHeader;
    private readonly OS $os;

    /**
     * @param string $appName The application name (or class name in some desktop environments).
     * @param OS|null $os The operation system instance or detection will be used.
     * @throws UnsupportedOSException
     */
    public function __construct(
        private readonly string $appName,
        ?OS $os = null
    ) {
        $this->os = $os ?? OSDetection::detect();
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
        $osFamily = strtoupper($this->os->family());

        if (($libTcl = $env->getValue("{$osFamily}_LIB_TCL")) === null) {
            $libTcl = $this->getDefaultTclLib();
        }
        if (($libTk = $env->getValue("{$osFamily}_LIB_TK")) === null) {
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
        
        $app = $this->createTkApplication($tk, $env->getValue('APP_NAME', $this->appName));

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
        
        $app = $this->createTkApplication($tk, $this->appName);
        $app->init();
        
        return $app;
    }

    protected function createTkApplication(Tk $tk, string $appName): TkApplication
    {
        return new TkApplication($tk, [
            '-name' => $appName,
        ]);
    }

    protected function createLogger(string $file): Logger
    {
        $log = new Logger('php-gui');
        $formatter = new LineFormatter(dateFormat: 'Y-m-d H:i:s', ignoreEmptyContextAndExtra: true);
        $stream = new StreamHandler($file, Logger::DEBUG);
        $stream->setFormatter($formatter);
        $log->pushHandler($stream);
        return $log;
    }

    protected function getDefaultTclLib(): string
    {
        return $this->os->tclSharedLib();
    }

    protected function getDefaultTkLib(): string
    {
        return $this->os->tkSharedLib();
    }

    protected function getTheme(string $theme): string
    {
        return strtolower($theme) === 'auto'
            ? $this->os->defaultThemeName() : $theme;
    }
}
