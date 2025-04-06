<?php

namespace Tests\Domain\Region;

use Domain\Region\Models\SubRegion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tests\TestCase;

class SubRegionTest extends TestCase
{
    public function test_it_uses_factory(): void
    {
        $this->assertContains(
            HasFactory::class, class_uses(SubRegion::class), 'SubRegion model does not use HasFactory trait'
        );
    }

    public function test_it_has_correct_table_name(): void
    {
        $this->assertEquals('sub_regions', (new SubRegion())->getTable(), 'SubRegion model does not have the correct table name');
    }
}