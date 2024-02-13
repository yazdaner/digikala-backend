<x-mail::message>
<div style="direction:rtl;text-align:right;">
    <span style="font-weight: bold;font-size: 20px">
        کد تایید شما در {{config('shop-info.name')}}
    </span>
    <div class="text-center green-color" style="padding:15px;font-size: 20px">
        {{$code}}
    </div>
</div>
</x-mail::message>
