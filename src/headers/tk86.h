#define FFI_SCOPE "tk"

typedef struct Tcl_Interp_ Tcl_Interp;
typedef int *ClientData;
typedef struct Display_ Display;
typedef struct TkDisplay_ TkDisplay;
typedef struct Visual_ Visual;
typedef struct TkMainInfo_ TkMainInfo;
typedef struct TkEventHandler_ TkEventHandler;
typedef struct Tk_GeomMgr_ Tk_GeomMgr;
typedef struct Tk_ClassProcs_ Tk_ClassProcs;

typedef const char *Tk_Uid;

typedef unsigned long XID;
typedef XID Window;
typedef XID Drawable;
typedef XID Font;
typedef XID Pixmap;
typedef XID Cursor;
typedef XID Colormap;
typedef XID GContext;
typedef XID KeySym;
typedef unsigned long VisualID;
typedef unsigned long KeyCode;
typedef int Bool;
typedef int Status;
typedef struct _XIC *XIC;

typedef struct {
    int x, y;
    int width, height;
    int border_width;
    Window sibling;
    int stack_mode;
} XWindowChanges;

typedef struct {
    Pixmap background_pixmap;
    unsigned long background_pixel;
    Pixmap border_pixmap;
    unsigned long border_pixel;
    int bit_gravity;
    int win_gravity;
    int backing_store;
    unsigned long backing_planes;
    unsigned long backing_pixel;
    Bool save_under;
    long event_mask;
    long do_not_propagate_mask;
    Bool override_redirect;
    Colormap colormap;
    Cursor cursor;
} XSetWindowAttributes;

typedef struct TkWindow {
    Display *display;
    TkDisplay *dispPtr;
    int screenNum;
    Visual *visual;
    int depth;
    Window window;
    struct TkWindow *childList;
    struct TkWindow *lastChildPtr;
    struct TkWindow *parentPtr;
    struct TkWindow *nextPtr;
    TkMainInfo *mainPtr;
    char *pathName;
    Tk_Uid nameUid;
    Tk_Uid classUid;
    XWindowChanges changes;
    unsigned int dirtyChanges;
    XSetWindowAttributes atts;
    unsigned long dirtyAtts;
    unsigned int flags;
    TkEventHandler *handlerList;
    XIC inputContext;
    ClientData *tagPtr;
    int numTags;
    int optionLevel;
    struct TkSelHandler *selHandlerList;
    Tk_GeomMgr *geomMgrPtr;
    ClientData geomData;
    int reqWidth, reqHeight;
    int internalBorderLeft;
    struct TkWmInfo *wmInfoPtr;
    Tk_ClassProcs *classProcsPtr;
    ClientData instanceData;
    struct TkWindowPrivate *privatePtr;
    int internalBorderRight;
    int internalBorderTop;
    int internalBorderBottom;
    int minReqWidth;
    int minReqHeight;
    int ximGeneration;
    char *geomMgrName;
    struct TkWindow *maintainerPtr;
} *Tk_Window;

int Tk_Init(Tcl_Interp *interp);
void Tk_MainLoop(void);

Tk_Window Tk_MainWindow(Tcl_Interp *interp);
void Tk_DestroyWindow(Tk_Window tkwin);
int Tk_GetNumMainWindows(void);
Tk_Window Tk_CreateWindowFromPath(Tcl_Interp *interp, Tk_Window tkwin,
        const char *pathName, const char *screenName);
Tk_Window Tk_CreateWindow(Tcl_Interp *interp,
        Tk_Window parent, const char *name, const char *screenName);
Tk_Window Tk_NameToWindow(Tcl_Interp *interp,
	    const char *pathName, Tk_Window tkwin);
