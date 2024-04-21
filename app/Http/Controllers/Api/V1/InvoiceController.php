<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Models\Invoice;
use App\Filters\V1\InvoicesFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BulkStoreInvoiceRequest;
use App\Http\Requests\V1\UpdateInvoiceRequest;
use App\Http\Resources\V1\InvoiceResource;
use App\Http\Resources\V1\InvoiceCollection;
use Illuminate\Support\Arr;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $filter = new InvoicesFilter();
        $queryItems = $filter->transform($request);

        if (empty($queryItems)) {
            return new InvoiceCollection(Invoice::paginate());
        } else {
            $invoices = Invoice::where($queryItems)->paginate();
            return new InvoiceCollection($invoices -> appends($request->query()));
        }

        Invoice::where($queryItems);

        $filter = new InvoicesFilter();
        $queryItems = $filter->transform($request);

        if (empty($queryItems)) {
            return new InvoiceCollection(Invoice::paginate());
        } else {
            $invoices = Invoice::where($queryItems)->paginate();
            return new InvoiceCollection($invoices -> appends($request->query()));
        }

        Invoice::where($queryItems);

        return new InvoiceCollection(Invoice::paginate());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // create one or more invoices

        $invoices = collect($request->all())->map(function ($arr, $key) {
            return Arr::except($arr, ['customerId', 'billedDate', 'paidDate']);
        });

        Invoice::insert($invoices->toArray());

        return response()->json(['message' => 'Invoices created successfully'], 201);
    }

    public function bulkStore(BulkStoreInvoiceRequest $request)
    {
        $bulk = collect($request->all())->map(function ($arr, $key) {
            return Arr::except($arr, ['customerId', 'billedDate', 'paidDate']);
        });

        Invoice::insert($bulk->toArray());

        return response()->json(['message' => 'Invoice(s) inserted successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
    }
}