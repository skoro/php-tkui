<?php declare(strict_types=1);

namespace Tkui\Tests;

use Tkui\DotEnv;
use Tkui\System\FFILoader;
use Tkui\System\OS;
use Tkui\TclTk\Interp;
use Tkui\TclTk\Tcl;
use RuntimeException;

trait TclInterp
{
    protected Tcl $tcl;
    protected Interp $interp;

    protected function setUp(): void
    {
        parent::setUp();

        $rootDir = dirname(__DIR__);
        $defaultTclH = $rootDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'headers' . DIRECTORY_SEPARATOR . 'tcl86.h';

        $env = DotEnv::create($rootDir);

        $os = OS::family();
        $hFile = $env->getValue('TCL_HEADER', $defaultTclH);
        $shared = $env->getValue($os . '_LIB_TCL');
        if (empty($shared)) {
            switch ($os) {
                case 'LINUX':
                    $shared = 'libtcl8.6.so';
                    break;
                case 'WINDOWS':
                    $shared = 'tcl86t.dll';
                    break;
                default:
                    throw new RuntimeException("Couldn't load Tcl shared lib for OS: " . $os);
            }
        }

        $loader = new FFILoader($hFile, $shared);
        $this->tcl = new Tcl($loader->load());
        $this->interp = $this->tcl->createInterp();
    }
}
