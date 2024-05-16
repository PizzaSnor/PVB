<?php

namespace Tests\Unit;

use App\Models\Occasion;
use App\Models\Role;
use App\Models\OccasionImage;
use Tests\TestCase;

class OccasionImageTest extends TestCase
{
    private array $createdOccasions = [];
    private array $createdImages = [];

    protected function tearDown(): void
    {
        foreach($this->createdOccasions as $occasion) {
            $occasion->delete();
        }

        foreach($this->createdImages as $image) {
            $image->delete();
        }
        parent::tearDown();
    }

    /**
     * @return void
     */
    public function test_creeer_nieuwe_occasion_foto(): void
    {
        $occasion = Occasion::factory()->create();

        $this->createdOccasions[] = $occasion;

        $image = OccasionImage::create([
            'occasion_id' => $occasion->id,
            'path' => '../../images/test.jpg'
        ]);

        $this->createdImages[] = $image;

        $this->assertDatabaseHas('occasion_images', [
            'occasion_id' => $image->occasion_id,
            'path' => $image->path
        ]);

    }
}
