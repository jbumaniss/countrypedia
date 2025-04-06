<?php

namespace Tests\Domain\Region;

use Domain\Region\Models\Region;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tests\TestCase;

class RegionTest extends TestCase
{
    public function test_it_uses_factory(): void
    {
        $this->assertContains(
            HasFactory::class, class_uses(Region::class), 'Region model does not use HasFactory trait'
        );
    }

    public function test_it_has_correct_table_name(): void
    {
        $this->assertEquals('regions', (new Region())->getTable(), 'Region model does not have the correct table name');
    }
}