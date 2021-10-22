<?php

namespace App\Phone\Services\Classes;


use App\Enums\CountriesEnum;
use App\Phone\Repositories\Interfaces\PhoneRepositoryInterface;
use App\Phone\Services\Interfaces\FilterPhonesInterface;

class FilterPhones implements FilterPhonesInterface
{
    private $phoneRepository;

    public function __construct(PhoneRepositoryInterface $phoneRepositoryI)
    {
        $this->phoneRepository = $phoneRepositoryI;
    }

    public function filterPhonesByCountry(array $params)
    {
        $phones = $this->phoneRepository->getPhones($params);

        $countriesCode = CountriesEnum::COUNTRIES_CODES;


        $filteredPhones = [];
        foreach ($phones['data'] as $row) {

            preg_match('#\((.*?)\)#', $row['phone'], $countryCodeMatch);
            $regex = $countriesCode[$countryCodeMatch[1]]['regex'];

            $phoneNumber = str_replace($countryCodeMatch[0] . ' ', '', $row['phone']);
            $state = preg_match("/$regex/", $row['phone'], $match);

            $filteredPhones[] = [
                'country' => $countriesCode[$countryCodeMatch[1]]['country'],
                'state' => $state,
                'country_code' => "+" . $countryCodeMatch[1],
                'phone_number' => $phoneNumber
            ];
        }
        return [
            'data' => $filteredPhones,
            'pagination' => $phones['pagination'],
        ];
    }
}
