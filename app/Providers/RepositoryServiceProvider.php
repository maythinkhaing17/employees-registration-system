<?php

namespace App\Providers;

use App\Interfaces\EmployeeInterface;
use App\Repositories\EmployeeRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider.
 * 
 * @author May Thin Khaing
 * @created 22/6/2023 
 */

class RepositoryServiceProvider extends ServiceProvider
{
    public $bindings = [
        EmployeeInterface::class => EmployeeRepository::class,
    ];
    public function register()
    {
        $this->app->bind(EmployeeInterface::class, EmployeeRepository::class);
    }
}
