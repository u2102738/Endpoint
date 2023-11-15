<?php

namespace App\Exports;

use App\Models\Agent;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class UsersExport implements FromCollection, WithHeadings
{
    protected $agents;

    public function __construct($agents)
    {
        $this->agents = $agents;
    }

    public function collection()
    {
        $data = new Collection();

        foreach ($this->agents as $agent) {
            $data->push([
                'UID' => $agent->username,
                'Client Key' => $agent->link_path,
            ]);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'UID',
            'Client Key',
        ];
    }
}








