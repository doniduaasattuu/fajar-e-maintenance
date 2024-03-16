<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;

use function PHPUnit\Framework\assertCount;

class OwnTest extends TestCase
{

    public function testGetSlotUniqueId()
    {
        $unique = [1, 5, 8, 9, 11, 13, 14, 15, 16];
        $normal = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16];

        function getSlot(array $unique)
        {
            $slot = [];
            for ($i = 0; $i < count($unique); $i++) {

                if (array_key_exists($i + 1, $unique)) {
                    if ($unique[$i] + 1 != $unique[$i + 1]) {
                        for ($j = $unique[$i] + 1; $j < $unique[$i + 1]; $j++) {
                            array_push($slot, $j);
                        }
                    }
                }
            }

            return $slot;
        }

        assertCount(7, getSlot($unique));
        assertCount(0, getSlot($normal));
    }

    public function testGetFirstUniqueId()
    {
        $unique = [1, 5, 8, 9, 11, 13, 14, 15, 16];
        $normal = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16];

        function getFirstSlot(array $unique)
        {
            for ($i = 0; $i < count($unique); $i++) {
                if (array_key_exists($i + 1, $unique)) {
                    if ($unique[$i] + 1 != $unique[$i + 1]) {
                        return $unique[$i] + 1;
                    }
                } else {
                    return $unique[$i] + 1;
                }
            }
        }

        self::assertEquals(2, getFirstSlot($unique));
        self::assertEquals(17, getFirstSlot($normal));
    }

    public function testDate()
    {
        $date = Carbon::now()->addDays(-1)->format('d M Y');
        echo $date;
        self::assertTrue(true);
    }
}
