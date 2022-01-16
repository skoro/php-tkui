<?php declare(strict_types=1);

namespace Tkui\Dialogs;

use Tkui\Options;
use Tkui\Windows\Window;

/**
 * MessageBox pops up a message and wait for user response.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/messageBox.html
 *
 * @property string $default The default selected button.
 * @property string $detail The detailed message.
 * @property string $icon The message icon.
 * @property string $message
 * @property string $title
 * @property string $type The message box predefined type.
 */
class MessageBox extends Dialog
{
    /**
     * Predefined types for 'type' property.
     */
    const TYPE_OK = 'ok';
    const TYPE_ABORT_RETRY_IGNORE = 'abortretryignore';
    const TYPE_OK_CANCEL = 'okcancel';
    const TYPE_RETRY_CANCEL = 'retrycancel';
    const TYPE_YES_NO = 'yesno';
    const TYPE_YES_NO_CANCEL = 'yesnocancel';

    /**
     * Icons for 'icon' property.
     */
    const ICON_ERROR = 'error';
    const ICON_INFO = 'info';
    const ICON_QUESTION = 'question';
    const ICON_WARNING = 'warning';

    /**
     * Modal result.
     *
     * The value can be returned by showModal() method.
     */
    const MR_YES = 'yes';
    const MR_NO = 'no';
    const MR_OK = 'ok';
    const MR_CANCEL = 'cancel';
    const MR_ABORT = 'abort';
    const MR_RETRY = 'retry';
    const MR_IGNORE = 'ignore';

    public function __construct(Window $parent, string $title, string $message, array $options = [])
    {
        parent::__construct($parent, $options);
        $this->title = $title;
        $this->message = $message;
    }

    /**
     * @inheritdoc
     */
    protected function createOptions(): Options
    {
        return new Options([
            'default' => null,
            'detail' => null,
            'icon' => null,
            'message' => null,
            'title' => null,
            'type' => null,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function command(): string
    {
        return 'tk_messageBox';
    }
}