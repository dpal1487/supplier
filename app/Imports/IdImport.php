<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\FinalId;
use App\Models\Respondent;

class IdImport implements ToCollection
{
    public $id;
    public function __construct($id)
    {
        $this->id = $id;
    }
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // $respondentIds = Respondent::where('project_id', $this->id)->get();
            // foreach ($respondentIds as $respondentId) {
            //     if ($respondentId) {
            //         $status = ($row[0] == $respondentId->id) ? 'approved' : 'rejected';
            //         $respondentId->update([
            //             'status' => $status,
            //         ]);
            //     }
            // }
            if (!empty($row[0])) {
                FinalId::create([
                    'respondent_id' => $row[0],
                    'project_id' => $this->id
                ]);
            }
        }
    }
}
