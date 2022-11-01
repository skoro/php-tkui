<?php declare(strict_types=1);

namespace Tkui\Tests;

use Tkui\DotEnv;
use Tkui\System\FFILoader;
use Tkui\TclTk\Interp;
use Tkui\TclTk\Tcl;
use Tkui\System\OSDetection;

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

        $os = OSDetection::detect();
        $hFile = $env->getValue('TCL_HEADER', $defaultTclH);
        $shared = $env->getValue("{$os->family()}_LIB_TCL", $os->tclSharedLib());

        $loader = new FFILoader($hFile, $shared);
        $this->tcl = new Tcl($loader->load());
        $this->interp = $this->tcl->createInterp();
    }
}
