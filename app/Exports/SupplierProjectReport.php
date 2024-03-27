<?php

namespace App\Exports;

use App\Models\SupplierProject;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SupplierProjectReport implements FromQuery, WithMapping, WithHeadings
{
    protected $id;
    public function __construct($id)
    {
        $this->id = $id;
    }
    public function headings(): array
    {
        return [
            'PROJECT ID',
            'CPI',
            'ACTUAL LOI',
            'IR',
            'TOTAL COMPLETE',
            'PROJECT STATUS',
            'COUNTRY',
            "START DATE",
        ];
    }
    public function map($final): array
    {
        return [
            $final->project?->project_id,
            $final->project_link?->cpi,
            $final->project_link?->loi,
            $final->project_link?->ir,
            count($final->completes ?? []) ?: 0,
            $final->status == 1 ? 'Active' : 'Inactive',
            $final->supplier->country->name,
            $final->created_at,
        ];
    }
    public function query()
    {
        $projects = SupplierProject::where('supplier_id', $this->id);
        return $projects;
    }
}
