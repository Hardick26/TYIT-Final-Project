<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $employees = [
            ['schedule_id' => 1, 'department_id' => 2, 'designation_id' => 1, 'firstname' => 'Hardik', 'lastname' => 'Shettigar', 'unique_id' => 'EMP-20230811-001', 'email' => 'hardik@gmail.com', 'phone' => '+91 123456789', 'address' => 'Goregaon', 'dob' => '2004-08-13', 'gender' => 1, 'religion' => 1, 'marital' => 2, 'status' => 1 ],
            ['schedule_id' => 1, 'department_id' => 5, 'designation_id' => 2, 'firstname' => 'Jyoti', 'lastname' => 'Singh', 'unique_id' => 'EMP-20230811-002', 'email' => 'jyoti@gmail.com', 'phone' => '+91 987654321', 'address' => 'Malad', 'dob' => '2004-01-22', 'gender' => 2, 'religion' => 1, 'marital' => 2, 'status' => 1 ],
            ['schedule_id' => 1, 'department_id' => 6, 'designation_id' => 3, 'firstname' => 'Admin', 'lastname' => 'NoMan', 'unique_id' => 'EMP-20230811-003', 'email' => 'admin@email.com', 'phone' => '+91 1234554321', 'address' => 'Virar', 'dob' => '1994-03-06', 'gender' => 1, 'religion' => 1, 'marital' => 2, 'status' => 1 ],
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }
    }
}
