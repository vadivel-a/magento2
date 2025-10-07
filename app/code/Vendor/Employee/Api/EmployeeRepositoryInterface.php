<?php
namespace Vendor\Employee\Api;

interface EmployeeRepositoryInterface
{
    /**
     * Get employee list
     * @return array
     */
    public function getList();

    /**
     * Add employee (optional)
     * @param string $name
     * @param string $position
     * @return array
     */
    public function add($name, $position);
}
