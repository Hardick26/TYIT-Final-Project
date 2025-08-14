<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'year',
        'month',
        'basic',
        'house_rent',
        'medical',
        'transport',
        'phone_bill',
        'internet_bill',
        'special',
        'bonus',
        'days_present',
        'days_absent',
        'gross_salary',
        'provident_fund',
        'income_tax',
        'health_insurance',
        'life_insurance',
        'deduction',
        'net_salary'
    ];

    // Define relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
