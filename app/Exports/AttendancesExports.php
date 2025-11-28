<?php
namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendancesExport implements FromCollection, WithHeadings
{
    protected $filters;
    public function __construct($filters = []){ $this->filters = $filters; }
    public function collection(){
        $q = Attendance::with('student.kelas');
        if(!empty($this->filters['date'])) $q->whereDate('absent_at', $this->filters['date']);
        if(!empty($this->filters['kelas'])) $q->whereHas('student', function($qq){ $qq->where('kelas_id',$this->filters['kelas']); });
        return $q->get()->map(function($a){ return [ $a->student->nis, $a->student->name, $a->student->kelas->name ?? '-', $a->absent_at->toDateTimeString(), $a->status ]; });
    }
    public function headings(): array{ return ['NIS','Nama','Kelas','Waktu','Status']; }
}
