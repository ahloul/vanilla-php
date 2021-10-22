<?php

use App\infra\ServiceContainer;

require './bootstrap.php';


$container = new ServiceContainer();
$container->bind(\App\Phone\Repositories\Interfaces\PhoneRepositoryInterface::class,
    \App\Phone\Repositories\Classes\PhoneRepository::class);
$container->bind(\App\Phone\Services\Interfaces\FilterPhonesInterface::class,
    \App\Phone\Services\Classes\FilterPhones::class);
$app = $container->make(\App\Phone\Controllers\PhoneController::class);
$app->index();



