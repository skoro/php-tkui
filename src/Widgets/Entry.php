<?php declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Color;
use Tkui\Font;
use Tkui\Options;
use Tkui\TclTk\Tcl;
use Tkui\TclTk\TclOptions;
use Tkui\TclTk\Variable;
use Tkui\Widgets\Common\Editable;
use Tkui\Widgets\Common\Scrollable;
use Tkui\Widgets\Common\ValueInVariable;
use Tkui\Widgets\Common\WithCallbacks;
use Tkui\Widgets\Common\WithScrollBars;
use Tkui\Widgets\Consts\Justify;
use Tkui\Widgets\Consts\Validate;

/**
 * Implementation of Tk entry widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_entry.htm
 *
 * @property Font $font
 * @property Color|string $textColor
 * @property callable $xScrollCommand
 * @property bool $exportSelection
 * @property callable|null $invalidCommand
 * @property Justify $justify
 * @property string $show
 * @property string $state
 * @property Variable $textVariable
 * @property Validate $validate
 * @property callable|null $validateCommand
 * @property int $width
 */
class Entry extends TtkWidget implements ValueInVariable, Editable, Scrollable
{
    use WithCallbacks, WithScrollBars {
        WithScrollBars::__get as private scrollbarsGet;
        WithScrollBars::__set as private scrollbarsSet;
        WithCallbacks::__get as private callbacksGet;
        WithCallbacks::__set as private callbacksSet;
    }

    protected string $widget = 'ttk::entry';
    protected string $name = 'e';

    /** @var callable|null */
    private $validateCommandCallback = null;

    /** @var callable|null */
    private $invalidCommandCallback = null;

    /**
     * @param array<string> $validateCommandArgs The additional arguments passed to validateCommand.
     * @link https://www.tcl.tk/man/tcl8.6.13/TkCmd/ttk_entry.htm#M42
     */
    public function __construct(
        Container             $parent,
        string                $value = '',
        array|Options         $options = [],
        public readonly array $validateCommandArgs = ['%P', '%s'],
    ) {
        $var = isset($options['textVariable']);

        parent::__construct($parent, $options);

        if (!$var) {
            $this->textVariable = $this->getEval()->registerVar($this);
        }

        if ($value !== '') {
            $this->setValue($value);
        }
    }

    /**
     * @inheritdoc
     */
    protected function createOptions(): TclOptions
    {
        return new TclOptions([
            'font' => null,
            'textColor' => null,
            'xScrollCommand' => null,
            'exportSelection' => null,
            'invalidCommand' => null,
            'justify' => null,
            'show' => null,
            'state' => null,
            'textVariable' => null,
            'validate' => null,
            'validateCommand' => null,
            'width' => null,
        ]);
    }

    public function __set(string $name, mixed $value): void
    {
        switch ($name) {
            case 'invalidCommand':
            case 'validateCommand':
                $this->callbacksSet($name, $value);
                break;

            case 'xScrollCommand':
                $this->scrollbarsSet($name, $value);
                break;

            default:
                parent::__set($name, $value);
        }
    }

    public function __get($name): mixed
    {
        return match ($name) {
            'invalidCommand', 'validateCommand' => $this->callbacksGet($name),
            'xScrollCommand'                    => $this->scrollbarsGet($name),
            default                             => parent::__get($name),
        };
    }

    /**
     * Sets the new entry's string.
     *
     * @param string $value
     */
    public function setValue($value): static
    {
        $this->textVariable->set($value);
        return $this;
    }

    /**
     * Delete one or more elements of the entry.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/entry.htm#M44
     *
     * @param string|int $first
     * @param string|int $last
     */
    public function delete($first, $last = null): static
    {
        if ($last) {
            $this->call('delete', $first, $last);
        } else {
            $this->call('delete', $first);
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function clear(): self
    {
        $this->textVariable->set('');
        return $this;
    }

    /**
     * Arrange for the insertion cursor to be displayed just before the character given by index.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/entry.htm#M46
     *
     * @param string|int $index
     */
    public function insertCursor($index): self
    {
        $this->call('icursor', $index);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function append(string $text): self
    {
        $this->insert('end', $text);
        return $this;
    }

    /**
     * Insert a string just before the specified index.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/entry.htm#M48
     *
     * @param string|int $index
     */
    public function insert($index, string $str): self
    {
        $this->call('insert', $index, Tcl::quoteString($str));
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getContent(): string
    {
        return $this->getValue();
    }

    /**
     * Returns the entry's string.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/entry.htm#M45
     */
    public function getValue(): string
    {
        return $this->textVariable->asString();
    }

    /**
     * @inheritdoc
     */
    public function setContent(string $text): self
    {
        $this->setValue($text);
        return $this;
    }

    /**
     * Force revalidation.
     *
     * @return bool Returns false if validation fails.
     * @link https://www.tcl.tk/man/tcl8.6.13/TkCmd/ttk_entry.htm#M33
     */
    public function validate(): bool
    {
        return (bool)$this->call('validate');
    }

    /**
     * Invokes the specified callback when Return\Enter key is pressed.
     */
    public function onSubmit(callable $callback): self
    {
        $this->bind('Return', fn() => $callback($this));
        return $this;
    }
}
