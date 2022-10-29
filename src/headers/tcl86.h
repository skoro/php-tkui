#define FFI_SCOPE "tcl"

typedef void (Tcl_FreeProc) (char *blockPtr);

typedef int *ClientData;

typedef struct Tcl_Interp
{
    char *result;
    Tcl_FreeProc *freeProc;
    int errorLine;
} Tcl_Interp;

typedef void (Tcl_FreeInternalRepProc) (struct Tcl_Obj *objPtr);
typedef void (Tcl_DupInternalRepProc) (struct Tcl_Obj *srcPtr, struct Tcl_Obj *dupPtr);
typedef void (Tcl_UpdateStringProc) (struct Tcl_Obj *objPtr);
typedef int (Tcl_SetFromAnyProc) (Tcl_Interp *interp, struct Tcl_Obj *objPtr);

typedef struct Tcl_ObjType {
    const char *name;
    Tcl_FreeInternalRepProc *freeIntRepProc;
    Tcl_DupInternalRepProc *dupIntRepProc;
    Tcl_UpdateStringProc *updateStringProc;
    Tcl_SetFromAnyProc *setFromAnyProc;
} Tcl_ObjType;

typedef struct Tcl_Obj {
    int refCount;
    char *bytes;
    int length;
    const Tcl_ObjType *typePtr;
    union {
        long longValue;
        double doubleValue;
        void *otherValuePtr;
        long long wideValue;
        struct {
            void *ptr1;
            void *ptr2;
        } twoPtrValue;
        struct {
            void *ptr;
            unsigned long value;
        } ptrAndLongRep;
    } internalRep;
} Tcl_Obj;

Tcl_Interp* Tcl_CreateInterp(void);
int Tcl_Init(Tcl_Interp *interp);

int Tcl_GetErrorLine(Tcl_Interp *interp);
int Tcl_GetErrno(void);

int Tcl_Eval(Tcl_Interp *interp, const char *script);
int Tcl_EvalObj(Tcl_Interp *interp, Tcl_Obj *objPtr);

Tcl_Obj *Tcl_GetObjResult(Tcl_Interp *interp);
const char *Tcl_GetString(Tcl_Obj *objPtr);
Tcl_Obj *Tcl_DuplicateObj(Tcl_Obj *objPtr);
void TclFreeObj(Tcl_Obj *objPtr);
int Tcl_GetBoolean(Tcl_Interp *interp, const char *src, int *boolPtr);
int Tcl_GetBooleanFromObj(Tcl_Interp *interp, Tcl_Obj *objPtr, int *boolPtr);
unsigned char *Tcl_GetByteArrayFromObj(Tcl_Obj *objPtr, int *lengthPtr);
int Tcl_GetDouble(Tcl_Interp *interp, const char *src, double *doublePtr);
int Tcl_GetDoubleFromObj(Tcl_Interp *interp, Tcl_Obj *objPtr, double *doublePtr);
int Tcl_GetIndexFromObj(Tcl_Interp *interp, Tcl_Obj *objPtr,
	    const char *const *tablePtr, const char *msg, int flags, int *indexPtr);
int Tcl_GetInt(Tcl_Interp *interp, const char *src, int *intPtr);
int Tcl_GetIntFromObj(Tcl_Interp *interp, Tcl_Obj *objPtr, int *intPtr);
int Tcl_GetLongFromObj(Tcl_Interp *interp, Tcl_Obj *objPtr, long *longPtr);
const Tcl_ObjType *Tcl_GetObjType(const char *typeName);
const char *Tcl_GetStringFromObj(Tcl_Obj *objPtr, int *lengthPtr);
void Tcl_InvalidateStringRep(Tcl_Obj *objPtr);
int Tcl_ListObjAppendList(Tcl_Interp *interp, Tcl_Obj *listPtr, Tcl_Obj *elemListPtr);
int Tcl_ListObjAppendElement(Tcl_Interp *interp, Tcl_Obj *listPtr, Tcl_Obj *objPtr);
int Tcl_ListObjGetElements(Tcl_Interp *interp, Tcl_Obj *listPtr,
	    int *objcPtr, Tcl_Obj ***objvPtr);
int Tcl_ListObjIndex(Tcl_Interp *interp, Tcl_Obj *listPtr, int index,
	    Tcl_Obj **objPtrPtr);
int Tcl_ListObjLength(Tcl_Interp *interp, Tcl_Obj *listPtr,
	    int *lengthPtr);
int Tcl_ListObjReplace(Tcl_Interp *interp, Tcl_Obj *listPtr, int first,
	    int count, int objc, Tcl_Obj *const objv[]);
Tcl_Obj *Tcl_NewBooleanObj(int boolValue);
Tcl_Obj *Tcl_NewByteArrayObj(const unsigned char *bytes, int length);
Tcl_Obj *Tcl_NewDoubleObj(double doubleValue);
Tcl_Obj *Tcl_NewIntObj(int intValue);
Tcl_Obj *Tcl_NewStringObj(const char *bytes, int length);
Tcl_Obj *Tcl_NewListObj(int objc, Tcl_Obj *const objv[]);

const char *Tcl_GetVar(Tcl_Interp *interp, const char *varName, int flags);
const char *Tcl_GetVar2(Tcl_Interp *interp, const char *part1, const char *part2, int flags);
const char *Tcl_SetVar(Tcl_Interp *interp, const char *varName,
                        const char *newValue, int flags);
const char *Tcl_SetVar2(Tcl_Interp *interp, const char *part1, 
                        const char *part2, const char *newValue, int flags);
Tcl_Obj *Tcl_ObjSetVar2(Tcl_Interp *interp, Tcl_Obj *part1Ptr,
	    Tcl_Obj *part2Ptr, Tcl_Obj *newValuePtr, int flags);
Tcl_Obj *Tcl_ObjGetVar2(Tcl_Interp *interp, Tcl_Obj *part1Ptr,
	    Tcl_Obj *part2Ptr, int flags);
int Tcl_UnsetVar(Tcl_Interp *interp, const char *varName, int flags);
int Tcl_UnsetVar2(Tcl_Interp *interp, const char *part1, const char *part2,
	    int flags);

void TclFreeObj(Tcl_Obj *objPtr);
void Tcl_FreeResult(Tcl_Interp *interp);

typedef struct Tcl_Command_ *Tcl_Command;
typedef int (Tcl_ObjCmdProc) (ClientData clientData, Tcl_Interp *interp,
	int objc, struct Tcl_Obj *const *objv);
typedef void (Tcl_CmdDeleteProc) (ClientData clientData);

Tcl_Command Tcl_CreateObjCommand(Tcl_Interp *interp,
	    const char *cmdName,
	    Tcl_ObjCmdProc *proc, ClientData clientData,
	    Tcl_CmdDeleteProc *deleteProc);
int Tcl_DeleteCommand(Tcl_Interp *interp, const char *cmdName);

typedef struct Tcl_CmdProc_  *Tcl_CmdProc;
typedef struct Tcl_Namespace *Tcl_Namespace;
typedef struct Tcl_CmdInfo {
    int isNativeObjectProc;
    Tcl_ObjCmdProc *objProc;
    ClientData objClientData;
    Tcl_CmdProc *proc;
    ClientData clientData;
    Tcl_CmdDeleteProc *deleteProc;
    ClientData deleteData;
    Tcl_Namespace *namespacePtr;
} Tcl_CmdInfo;
int Tcl_GetCommandInfo(Tcl_Interp *interp, const char *cmdName,
	    Tcl_CmdInfo *infoPtr);