<?php

namespace GildedRose\Tests\Console;

use GildedRose\Console\Item;
use GildedRose\Console\Program;

class ProgramTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldDecreaseByOneTheQualityWhenSellInIsMoreThanZero()
    {
        $item = $this->buildItem(Program::CONJURED_MANA_CAKE, 4, 5);
        $app = new Program([$item]);

        $app->UpdateQuality();
        $this->assertSame(4, $item->quality);
        $this->assertSame(3, $item->sellIn);
        $app->UpdateQuality();
        $this->assertSame(3, $item->quality);
        $this->assertSame(2, $item->sellIn);
        $app->UpdateQuality();
        $this->assertSame(2, $item->quality);
        $this->assertSame(1, $item->sellIn);

    }

    /**
     * @test
     */
    public function itShouldDecreaseTwiceAsFastWhenTheSellInDateHasExpire()
    {
        $item = $this->buildItem(Program::CONJURED_MANA_CAKE, 0, 5);
        $app = new Program([$item]);

        $app->UpdateQuality();
        $this->assertSame(3, $item->quality);
        $this->assertSame(-1, $item->sellIn);
        $app->UpdateQuality();
        $this->assertSame(1, $item->quality);
        $this->assertSame(-2, $item->sellIn);
    }

    /**
     * @test
     */
    public function itShouldDecreaseQuantityUntilTheValueIsZero()
    {
        $item = $this->buildItem(Program::CONJURED_MANA_CAKE, 1, 2);
        $app = new Program([$item]);

        $app->UpdateQuality();
        $this->assertSame(1, $item->quality);
        $this->assertSame(0, $item->sellIn);
        $app->UpdateQuality();
        $this->assertSame(0, $item->quality);
        $this->assertSame(-1, $item->sellIn);
        $app->UpdateQuality();
        $this->assertSame(0, $item->quality);
        $this->assertSame(-2, $item->sellIn);
    }

    /**
     * @test
     */
    public function itShouldIncreaseTheQualityWhenTheItemIsAnAgedBrie()
    {
        $item = $this->buildItem(Program::AGED_BRIE, 2, 2);
        $app = new Program([$item]);

        $app->UpdateQuality();
        $this->assertSame(3, $item->quality);
        $this->assertSame(1, $item->sellIn);
        $app->UpdateQuality();
        $this->assertSame(4, $item->quality);
        $this->assertSame(0, $item->sellIn);
    }

    /**
     * @test
     */
    public function itShouldIncreaseTheQualityByTwoOnceTheSellInHasExpiredWhenTheItemIsAnAgedBrie()
    {
        $item = $this->buildItem(Program::AGED_BRIE, 2, 2);
        $app = new Program([$item]);

        $app->UpdateQuality();
        $this->assertSame(3, $item->quality);
        $this->assertSame(1, $item->sellIn);
        $app->UpdateQuality();
        $this->assertSame(4, $item->quality);
        $this->assertSame(0, $item->sellIn);
        $app->UpdateQuality();
        $this->assertSame(6, $item->quality);
        $this->assertSame(-1, $item->sellIn);
        $app->UpdateQuality();
        $this->assertSame(8, $item->quality);
        $this->assertSame(-2, $item->sellIn);
    }


    /**
     * @test
     */
    public function itShouldIncreaseTheQualityWithAMaximumOfFifty()
    {
        $item = $this->buildItem(Program::AGED_BRIE, 5, 48);
        $app = new Program([$item]);

        $app->UpdateQuality();
        $this->assertSame(49, $item->quality);
        $this->assertSame(4, $item->sellIn);
        $app->UpdateQuality();
        $this->assertSame(50, $item->quality);
        $this->assertSame(3, $item->sellIn);
        $app->UpdateQuality();
        $this->assertSame(50, $item->quality);
        $this->assertSame(2, $item->sellIn);
    }

    /**
     * @test
     */
    public function itShouldNeverDecreaseTheQualityOrHaveASellInDateWhenTheItemIsASulfuras()
    {
        $item = $this->buildItem(Program::SULFURAS_HAND_OF_RAGNAROS, 0, 80);
        $app = new Program([$item]);

        $app->UpdateQuality();
        $this->assertSame(80, $item->quality);
        $this->assertSame(0, $item->sellIn);
        $app->UpdateQuality();
        $this->assertSame(80, $item->quality);
        $this->assertSame(0, $item->sellIn);
        $app->UpdateQuality();
        $this->assertSame(80, $item->quality);
        $this->assertSame(0, $item->sellIn);
    }

    /**
     * @test
     */
    public function itShouldIncreaseQualityByTwoWhenSellInIsLessThanElevenAndTheItemIsABackstagePasses()
    {
        $item = $this->buildItem(Program::BACKSTAGE_PASSES, 12, 20);
        $app = new Program([$item]);

        $app->UpdateQuality();
        $this->assertSame(21, $item->quality);
        $this->assertSame(11, $item->sellIn);
        $app->UpdateQuality();
        $this->assertSame(22, $item->quality);
        $this->assertSame(10, $item->sellIn);
        $app->UpdateQuality();
        $this->assertSame(24, $item->quality);
        $this->assertSame(9, $item->sellIn);
        $app->UpdateQuality();
        $this->assertSame(26, $item->quality);
        $this->assertSame(8, $item->sellIn);
    }

    /**
     * @test
     */
    public function itShouldIncreaseQualityByThreeWhenSellInIsLessThanSixAndTheItemIsABackstagePasses()
    {
        $item = $this->buildItem(Program::BACKSTAGE_PASSES, 7, 20);
        $app = new Program([$item]);

        $app->UpdateQuality();
        $this->assertSame(22, $item->quality);
        $this->assertSame(6, $item->sellIn);
        $app->UpdateQuality();
        $this->assertSame(24, $item->quality);
        $this->assertSame(5, $item->sellIn);
        $app->UpdateQuality();
        $this->assertSame(27, $item->quality);
        $this->assertSame(4, $item->sellIn);
        $app->UpdateQuality();
        $this->assertSame(30, $item->quality);
        $this->assertSame(3, $item->sellIn);
    }

    /**
     * @test
     */
    public function itShouldResetTheQualityAtZeroOnceTheSellInHasExpire()
    {
        $item = $this->buildItem(Program::BACKSTAGE_PASSES, 2, 20);
        $app = new Program([$item]);

        $app->UpdateQuality();
        $this->assertSame(23, $item->quality);
        $this->assertSame(1, $item->sellIn);
        $app->UpdateQuality();
        $this->assertSame(26, $item->quality);
        $this->assertSame(0, $item->sellIn);
        $app->UpdateQuality();
        $this->assertSame(0, $item->quality);
        $this->assertSame(-1, $item->sellIn);
    }

    private function buildItem(string $name, int $sellIn, int $quantity):Item
    {
        return new Item(array('name' => $name, 'sellIn' => $sellIn, 'quality' => $quantity));
    }
}

/*
* "Backstage passes", like "Aged Brie", increases in Quality as it's SellIn value approaches;
   Quality increases by 2 when there are 10 days or less and by 3 when there are 5 days or less
   but Quality drops to 0 after the concert

 */
