<?php

/*
 * Copyright MADE/YOUR/DAY OG <mail@madeyourday.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MadeYourDay\RockSolidSlider\Test\DependencyInjection\Compiler;

use MadeYourDay\RockSolidSlider\SliderContent;
use PHPUnit\Framework\TestCase;

/**
 * Tests the SliderContent class.
 *
 * @author Christian Schiffler <c.schiffler@cyberspectrum.de>
 */
class SliderContentTest extends TestCase
{
    /**
     * Tests the object instantiation.
     */
    public function testInstantiation()
    {
        $content = new SliderContent();

        $this->assertInstanceOf('MadeYourDay\RockSolidSlider\SliderContent', $content);
    }

    /**
     * Test that empty slides are really empty.
     *
     * @return void
     */
    public function testEmptySlides()
    {
        $content = new SliderContent();

        $this->assertFalse($content->hasSlides());
        $this->assertEquals([], $content->getSlides());
    }

    /**
     * Test that slides can get added and are returned correctly.
     *
     * @return void
     */
    public function testAddSlides()
    {
        $content = new SliderContent();
        $content->addSlides([
            ['text' => 'slide 1'],
            ['text' => 'slide 2'],
            ['text' => 'slide 3'],
        ]);
        $content->addSlides([
            'some_key' => ['text' => 'slide 4'],
            ['text' => 'slide 5'],
            ['text' => 'slide 6'],
        ]);

        $this->assertTrue($content->hasSlides());
        $this->assertEquals(
            [
                 ['text' => 'slide 1'],
                 ['text' => 'slide 2'],
                 ['text' => 'slide 3'],
                 ['text' => 'slide 4'],
                 ['text' => 'slide 5'],
                 ['text' => 'slide 6'],
            ],
            $content->getSlides()
        );
    }

    /**
     * Test that invalid slides can not get added.
     *
     * @return void
     */
    public function testAddInvalidSlide()
    {
        $content = new SliderContent();
        $this->expectException('\InvalidArgumentException');
        $this->expectExceptionMessage('Slide does not contain key "text".');
        $content->addSlides([['invalid' => 'slide']]);
    }

    /**
     * Test that empty files are really empty.
     *
     * @return void
     */
    public function testEmptyFiles()
    {
        $content = new SliderContent();

        $this->assertFalse($content->hasFiles());
        $this->assertEquals([], $content->getFiles());
    }

    /**
     * Test that files can get added and are returned correctly.
     *
     * @return void
     */
    public function testAddFiles()
    {
        $content = new SliderContent();
        $content->addFiles(['file 1', 'file 2', 'file 3']);
        $content->addFiles(['file 4', 'file 5', 'file 6']);

        $this->assertTrue($content->hasFiles());
        $this->assertEquals(
            ['file 1', 'file 2', 'file 3', 'file 4', 'file 5', 'file 6'],
            $content->getFiles()
        );
        $this->assertEquals(
            ['file 1', 'file 2', 'file 3', 'file 4', 'file 5', 'file 6'],
            $content->getFilesOrder()
        );
    }

    /**
     * Test that files preserve order.
     *
     * @return void
     */
    public function testAddPreservesOrder()
    {
        $content = new SliderContent();
        $content->addFiles(['file 1', 'file 2', 'file 3']);
        $content->addFiles(['file 4', 'file 5', 'file 6'], ['file 6', 'file 4', 'file 5']);

        $this->assertEquals(
            ['file 1', 'file 2', 'file 3', 'file 6', 'file 4', 'file 5'],
            $content->getFilesOrder()
        );
    }

}
