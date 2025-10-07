<?php
namespace Vendor\Employee\Model;

use Vendor\Employee\Api\EmployeeRepositoryInterface;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function getList()
    {
        // You can load data from DB — this is just static for example
        return [
            ['id' => 1, 'name' => 'John Doe', 'position' => 'Developer'],
            ['id' => 2, 'name' => 'Jane Smith', 'position' => 'Designer'],
        ];
    }

    public function add($name, $position)
    {
        // Here you can save to DB; returning mock for now
        return ['message' => "Employee {$name} ({$position}) added successfully"];
    }
}
