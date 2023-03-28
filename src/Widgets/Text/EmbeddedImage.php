<?php declare(strict_types=1);

namespace Tkui\Widgets\Text;

use Tkui\Image;
use Tkui\Options;
use Tkui\TclTk\TclOptions;
use Tkui\Widgets\Consts\Align;

/**
 * @property Align $align
 * @property Image $image
 * @property string $name
 * @property int $padx
 * @property int $pady
 */
class EmbeddedImage
{
    private TextApiMethodBridge $apiBridge;
    private TextIndex $index;
    private Options $options;
    private string $id;

    public function __construct(TextApiMethodBridge $apiBridge, TextIndex $index, Image $image, array|Options $options = [])
    {
        $this->apiBridge = $apiBridge;
        $this->index = $index;
        $options['image'] = $image;
        $this->options = $this->createOptions()->with($options);
        $this->id = $this->create();
    }

    protected function createOptions(): Options
    {
        return new TclOptions([
            'align' => null,
            'image' => null,
            'name' => null,
            'padx' => null,
            'pady' => null,
        ]);
    }

    protected function create(): string
    {
        return (string) $this->apiCallMethod('create');
    }

    public function id(): string
    {
        return $this->id;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->options->$name;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->options->$name = $value;
        $this->configure();
    }

    protected function configure(): void
    {
        $this->apiCallMethod('configure');
    }

    protected function apiCallMethod(string $method)
    {
        return $this->apiBridge->callMethod($method, (string) $this->index, ...$this->options->toStringList());
    }
}
