<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProfessionalsExport implements FromCollection , WithHeadings
{
    public $fields = [];
    public function __construct($data)
    {
        $this->fields = $data['fields'];
    }

    public function headings(): array
    {
        $data = [];
        foreach($this->fields as $field){
            $data[] = ucfirst(str_replace('_', ' ', $field));
        }
        return $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $medicals = User::whereHas("roles", function($q){ $q->where("name", "medical"); })->with('professionalDetails.professions','professionalDetails.ranks')->get();
        $data = [];
        foreach($medicals as $medical){
            $temp = [];
            foreach($this->fields as $field){
                if($field == 'rank'){
                    $temp[$field] = $medical->professionalDetails->ranks->name;
                    continue;
                }
                if($field == 'profession'){
                    $temp[$field] = $medical->professionalDetails->professions->name;
                    continue;
                }
                $temp[$field] = $medical->$field;
            }
            $data[] = $temp;
        }
        return collect($data);
    }
}
