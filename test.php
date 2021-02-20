<?php

use TclTk\App;
use TclTk\Widgets\Button;
use TclTk\Widgets\Entry;
use TclTk\Widgets\Frame;
use TclTk\Widgets\Label;
use TclTk\Widgets\Window;

require __DIR__ . '/vendor/autoload.php';
$app = App::create();
$win = new Window($app, 'PHP & Tcl/Tk');
$f = new Frame($win);
$f->pack(['expand' => 1, 'fill' => 'both']);
$lab1 = new Label($f, 'Label');
$lab1->pack(['side' => 'top']);
$e = new Entry($f);
$e->pack(['expand' => 1, 'fill' => 'x']);
$e->focus();
$btn1 = new Button($win, 'Button 1');
$btn1->pack(['side' => 'left']);
$win2 = new Window($app, 'Win2');
$btn1->onClick(function () use ($lab1, $app, $win2) {
    $lab1->text = 'button1 clicked';
    $w = $app->tk()->mainWindow();
    $x = $app->tk()->nameToWindow($win2->path(), $w);
    var_dump($win2->path(),$x);
});
$btn1->takeFocus = 0;
$btn2 = new Button($win, 'Button 2');
$btn2->pack(['side' => 'right']);
$btn2->onClick(function () use ($lab1, $e) {
    $lab1->text = 'button 2 clicked';
    var_dump($e->get());
});

// $app->tk()->interp()->eval('update idletasks');
// $app->tk()->interp()->eval('winfo height .');
// $w = $app->tk()->mainWindow();
// var_dump($w);
// $x = $app->tk()->nameToWindow('.', $w);
// var_dump($x, $app->tk()->interp()->getStringResult());
// $app->tk()->destroy($x);

$app->mainLoop();
exit;
////////////////////////////////////////////////////////////////////////////////////////

function get_result($tcl, $interp): string
{
    return $tcl->Tcl_GetString($tcl->Tcl_GetObjResult($interp));
}

// FFI::load('include/X11.h');
$tcl = FFI::load('include/tcl.h');
$tk = FFI::load('include/tk.h');

$interp = $tcl->Tcl_CreateInterp();
$x = $tcl->Tcl_Init($interp);

// $proc = function ($clientData, $interp, $objc, $objv) use ($tcl) {
//     echo 'from PHP!'.PHP_EOL;
//     $s = $tcl->Tcl_GetString($objv[1]);
//     var_dump($s);
// };
// $deleteProc = function ($clientData) {};
// $tcl->Tcl_CreateObjCommand($interp, "php_tcl_test", $proc, NULL, $deleteProc);
// $x = $tcl->Tcl_Eval($interp, 'php_tcl_test {val-str 123}');
// exit;

$tclInterp = $tk->type('Tcl_Interp*');
$i=$tk->cast($tclInterp, $interp);
$tclInterp = $interp;

$x = $tk->Tk_Init($i);
// $obj = $tcl->Tcl_GetObjResult($interp);
// $str = $tcl->Tcl_GetString($obj);
// var_dump($str);
$win = $tk->Tk_MainWindow($i);
var_dump($win);

$x = $tcl->Tcl_Eval($interp, 'entry .e1');
var_dump(get_result($tcl, $interp));
$x = $tcl->Tcl_Eval($interp, 'button .b1 -text "Hello"');
var_dump(get_result($tcl, $interp));
$x = $tcl->Tcl_Eval($interp, 'pack .e1 .b1');
var_dump($x);

// var_dump($x,$interp);
$tk->Tk_MainLoop();
