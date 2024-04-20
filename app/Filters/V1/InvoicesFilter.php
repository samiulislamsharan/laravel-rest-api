<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;
use Illuminate\Http\Request;

class InvoicesFilter extends ApiFilter
{
    protected $allowedParams = [
        'customerId' => ['eq'],
        'status' => ['eq', 'ne'],
        'amount' => ['eq', 'ne', 'gt', 'gte', 'lt', 'lte'],
        'billedDate' => ['eq', 'ne', 'gt', 'gte', 'lt', 'lte'],
        'paidDate' => ['eq', 'ne', 'gt', 'gte', 'lt', 'lte'],
    ];

    protected $columnMap = [
        'customerId' => 'customer_id',
        'billedDate' => 'billed_date',
        'paidDate' => 'paid_date',
    ];

    protected $operatorMap = [
        'eq' => '=',
        'gt' => '>',
        'gte' => '>=',
        'lt' => '<',
        'lte' => '<=',
        'ne' => '!=',
    ];
}
