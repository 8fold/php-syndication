<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Tests\Rss;

use PHPUnit\Framework\TestCase;

use Eightfold\Syndication\Rss\SkipHours;

class SkipHoursTest extends TestCase
{
    /**
     * @test
     */
    public function has_hours(): void
    {
        $expected = '';

        $result = (string) SkipHours::create();

        $this->assertSame(
            $expected,
            $result
        );

        $expected = '<skipHours><hour>0</hour></skipHours>';

        $result = (string) SkipHours::create(0);

        $this->assertSame(
            $expected,
            $result
        );
    }

    /**
     * @test
     */
    public function no_more_than_24_hours(): void
    {
        $expected = '<skipHours><hour>0</hour><hour>1</hour><hour>2</hour><hour>3</hour><hour>4</hour><hour>5</hour><hour>6</hour><hour>7</hour><hour>8</hour><hour>9</hour><hour>10</hour><hour>11</hour><hour>12</hour><hour>13</hour><hour>14</hour><hour>15</hour><hour>16</hour><hour>17</hour><hour>18</hour><hour>19</hour><hour>20</hour><hour>21</hour><hour>22</hour><hour>23</hour></skipHours>';

        $result = (string) SkipHours::create(...range(0, 30));

        $this->assertSame(
            $expected,
            $result
        );
    }

    /**
     * @test
     */
    public function no_duplicate_hours(): void
    {
        $expected = '<skipHours><hour>0</hour><hour>1</hour><hour>2</hour><hour>3</hour><hour>4</hour><hour>5</hour></skipHours>';

        $result = (string) SkipHours::create(
            0,
            1,
            2,
            2,
            3,
            4,
            5
        );

        $this->assertSame(
            $expected,
            $result
        );
    }
}
