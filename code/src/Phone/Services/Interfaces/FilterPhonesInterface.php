<?php

namespace App\Phone\Services\Interfaces;

interface FilterPhonesInterface
{
    public function filterPhonesByCountry(array $params);
}
