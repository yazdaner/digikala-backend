<?php

namespace Tests\Feature\favourites;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Modules\users\App\Models\User;
use Modules\brands\App\Models\Brand;

class FavouriteTest extends TestCase
{
    protected User|null $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = getAdminForTest();
    }

    public function test_add_favourite(): void
    {
        // 
    }
}
