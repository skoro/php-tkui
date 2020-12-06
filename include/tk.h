#define FFI_SCOPE "tk"
#define FFI_LIB   "libtk8.6.so"

typedef struct Tk_Window_ Tk_Window;
typedef struct Tcl_Interp_ Tcl_Interp;
typedef int *ClientData;

int Tk_Init(Tcl_Interp *interp);
void Tk_MainLoop(void);

Tk_Window Tk_MainWindow(Tcl_Interp *interp);
int Tk_GetNumMainWindows(void);
Tk_Window Tk_CreateWindowFromPath(Tcl_Interp *interp, Tk_Window tkwin,
	    const char *pathName, const char *screenName);
Tk_Window Tk_CreateWindow(Tcl_Interp *interp,
                          Tk_Window parent, const char *name, const char *screenName);
