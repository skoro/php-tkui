<?php declare(strict_types=1);

namespace Tkui\Tests\App;

use Tkui\TclTk\Interp;
use Tkui\TclTk\TkImageFactory;
use Tkui\Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class TkImageFactoryTest extends TestCase
{
    /** @test */
    public function can_create_image_from_file()
    {
        /** @var Interp|MockObject */
        $interp = $this->createMock(Interp::class);
        $interp->expects($this->once())
               ->method('eval')
               ->with('image create photo -file {test.png}')
        ;

        $f = new TkImageFactory($interp);
        $f->createFromFile('test.png');
    }

    /** @test */
    public function image_binary_string_must_be_base64_encoded()
    {
        $binary = openssl_random_pseudo_bytes(512);
        $encoded = base64_encode($binary);

        /** @var Interp|MockObject */
        $interp = $this->createMock(Interp::class);
        $interp->expects($this->once())
               ->method('eval')
               ->with('image create photo -data {' . $encoded . '}')
        ;

        $f = new TkImageFactory($interp);
        $f->createFromBinary($binary);
    }
}
