<?php

class Tcl
{
    public const TCL_OK = 0;
    public const TCL_ERROR = 1;
    public const TCL_RETURN = 2;
    public const TCL_BREAK = 3;
    public const TCL_CONTINUE = 4;
}

function get_result($tcl, $interp): string
{
    return $tcl->Tcl_GetString($tcl->Tcl_GetObjResult($interp));
}

// FFI::load('include/X11.h');
$tcl = FFI::load('include/tcl.h');
$tk = FFI::load('include/tk.h');

$interp = $tcl->Tcl_CreateInterp();
$x = $tcl->Tcl_Init($interp);

$proc = function ($clientData, $interp, $objc, $objv) {
    echo 'from PHP!'.PHP_EOL;
    var_dump($clientData);
};
$deleteProc = function ($clientData) {};
$tcl->Tcl_CreateObjCommand($interp, "php_tcl_test", $proc, NULL, $deleteProc);
$x = $tcl->Tcl_Eval($interp, 'php_tcl_test "val-str"'); var_dump($x);
exit;

$tclInterp = $tk->type('Tcl_Interp*');
$i=$tk->cast($tclInterp, $interp);
$tclInterp = $interp;

$x = $tk->Tk_Init($i);
// $obj = $tcl->Tcl_GetObjResult($interp);
// $str = $tcl->Tcl_GetString($obj);
// var_dump($str);

$x = $tcl->Tcl_Eval($interp, 'entry .e1');
var_dump(get_result($tcl, $interp));
$x = $tcl->Tcl_Eval($interp, 'button .b1 -text "Hello"');
var_dump(get_result($tcl, $interp));
$x = $tcl->Tcl_Eval($interp, 'pack .e1 .b1');
var_dump($x);

// var_dump($x,$interp);
$tk->Tk_MainLoop();
