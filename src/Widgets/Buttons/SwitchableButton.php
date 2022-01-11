<?php declare(strict_types=1);

namespace Tkui\Widgets\Buttons;

use Tkui\Options;
use Tkui\TclTk\Variable;
use Tkui\Widgets\Container;

/**
 * The base class for buttons that can be switched.
 *
 * @property Variable $variable
 */
abstract class SwitchableButton extends GenericButton implements SelectableButton
{
    public function __construct(Container $parent, array $options = [])
    {
        $var = isset($options['variable']);

        parent::__construct($parent, $options);

        if (! $var) {
            $this->variable = $this->getEval()->registerVar($this);
        }
    }

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return parent::initWidgetOptions()->mergeAsArray([
            'variable' => null,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function select(): self
    {
        $this->setValue(true);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function deselect(): self
    {
        $this->setValue(false);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getValue()
    {
        return $this->variable->asBool();
    }

    /**
     * @inheritdoc
     */
    public function setValue($value): self
    {
        $this->variable->set($value);
        return $this;
    }
}