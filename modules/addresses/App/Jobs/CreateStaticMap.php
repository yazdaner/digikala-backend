<?php

namespace Modules\addresses\App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Http;
use Modules\addresses\App\Models\Address;

class CreateStaticMap implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $address_id;

    public function __construct($address_id)
    {
        $this->address_id = $address_id;
    }

    public function handle(): void
    {
        $address = Address::find($this->address_id);
        if ($address) {
            $url = 'https://map.ir/static?width=300&height=300&zoom_level=12&markers=color:red';
            try {
                $response = Http::withHeaders([
                    'x-api-key' => env('MAP_IR_API_KEY'),
                    'markers' => 'color:red|' . $address->longitude . ',' . $address->latitude
                ])->get($url);
                $path = 'upload/address-' . $address->id . '.png';
                file_put_contents(fileDirectory($path), $response->body());
                $address->staticmap = $path;
                $address->update();
            } catch (\Exception $ex) {
            }
        }
    }
}
