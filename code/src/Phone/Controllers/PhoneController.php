<?php

namespace App\Phone\Controllers;


use App\infra\Controller;
use App\Phone\Services\Interfaces\FilterPhonesInterface;


class PhoneController extends Controller
{
    private $filterPhone;

    public function __construct(FilterPhonesInterface $filterPhone)
    {
        parent::__construct();
        $this->filterPhone = $filterPhone;

    }

    public function index()
    {
        $phones = $this->filterPhone->filterPhonesByCountry($this->params);

        header("Content-type: application/json");

        echo json_encode($phones);


    }
}
