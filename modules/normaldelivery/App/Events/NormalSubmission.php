<?php

namespace Modules\normaldelivery\App\Events;

class NormalSubmission
{
    protected array $intervals;
    protected array $filteredProducts = [];
    protected int $perparation_time = 0;
    protected int $totalPrice = 0;
    protected int $finalPrice = 0;
    protected array $selectedKeys = [];
    protected int $sender;

    public function handle($data)
    {
    }
}
