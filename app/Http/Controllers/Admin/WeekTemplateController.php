<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WeekTemplate;
use App\Models\WeekTemplateDay;
use App\Models\DayTemplate;
use App\Models\Kelas;

class WeekTemplateController extends Controller
{
    private $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

    public function index()
    {
        $weekTemplates = WeekTemplate::with(['kelas', 'days.template'])->paginate(25);
        return view('admin.week-templates.index', compact('weekTemplates'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $dayTemplates = DayTemplate::all();
        return view('admin.week-templates.create', ['kelas' => $kelas, 'dayTemplates' => $dayTemplates, 'days' => $this->days]);
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'name' => 'required|string|max:255',
            'week_type' => 'required|in:1,2',
            'days' => 'required|array',
            'days.*.day_name' => 'required|in:' . implode(',', $this->days),
            'days.*.day_template_id' => 'nullable|exists:day_templates,id'
        ]);

        $weekTemplate = WeekTemplate::create([
            'kelas_id' => $v['kelas_id'],
            'name' => $v['name'],
            'week_type' => $v['week_type']
        ]);

        foreach ($v['days'] as $order => $dayData) {
            WeekTemplateDay::create([
                'week_template_id' => $weekTemplate->id,
                'day_name' => $dayData['day_name'],
                'day_template_id' => $dayData['day_template_id'] ?? null,
                'day_order' => $order
            ]);
        }

        return redirect()->route('admin.week-templates.index')->with('success', 'Week template created');
    }

    public function show(WeekTemplate $weekTemplate)
    {
        $weekTemplate->load(['kelas', 'days.template.slots.mapel', 'days.template.slots.teacher']);
        return view('admin.week-templates.show', compact('weekTemplate'));
    }

    public function edit(WeekTemplate $weekTemplate)
    {
        $weekTemplate->load('days');
        $kelas = Kelas::all();
        $dayTemplates = DayTemplate::all();
        return view('admin.week-templates.edit', ['weekTemplate' => $weekTemplate, 'kelas' => $kelas, 'dayTemplates' => $dayTemplates, 'days' => $this->days]);
    }

    public function update(Request $request, WeekTemplate $weekTemplate)
    {
        $v = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'name' => 'required|string|max:255',
            'week_type' => 'required|in:1,2',
            'days' => 'required|array',
            'days.*.day_name' => 'required|in:' . implode(',', $this->days),
            'days.*.day_template_id' => 'nullable|exists:day_templates,id'
        ]);

        $weekTemplate->update([
            'kelas_id' => $v['kelas_id'],
            'name' => $v['name'],
            'week_type' => $v['week_type']
        ]);

        // Delete old days
        $weekTemplate->days()->delete();

        // Create new days
        foreach ($v['days'] as $order => $dayData) {
            WeekTemplateDay::create([
                'week_template_id' => $weekTemplate->id,
                'day_name' => $dayData['day_name'],
                'day_template_id' => $dayData['day_template_id'] ?? null,
                'day_order' => $order
            ]);
        }

        return redirect()->route('admin.week-templates.index')->with('success', 'Week template updated');
    }

    public function destroy(WeekTemplate $weekTemplate)
    {
        $weekTemplate->delete();
        return back()->with('success', 'Week template deleted');
    }
}
