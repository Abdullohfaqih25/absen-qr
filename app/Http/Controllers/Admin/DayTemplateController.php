<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DayTemplate;
use App\Models\DaySlot;
use App\Models\Mapel;
use App\Models\Teacher;

class DayTemplateController extends Controller
{
    public function index()
    {
        $dayTemplates = DayTemplate::with('slots')->paginate(25);
        return view('admin.day-templates.index', compact('dayTemplates'));
    }

    public function create()
    {
        $mapels = Mapel::all();
        $teachers = Teacher::all();
        return view('admin.day-templates.create', compact('mapels', 'teachers'));
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'slots' => 'required|array|min:1',
            'slots.*.start_time' => 'required|date_format:H:i',
            'slots.*.end_time' => 'required|date_format:H:i',
            'slots.*.mapel_id' => 'required|exists:mapels,id',
            'slots.*.teacher_id' => 'nullable|exists:teachers,id',
            'slots.*.topic' => 'nullable|string'
        ]);

        $dayTemplate = DayTemplate::create([
            'name' => $v['name'],
            'description' => $v['description'] ?? null
        ]);

        foreach ($v['slots'] as $order => $slot) {
            DaySlot::create([
                'day_template_id' => $dayTemplate->id,
                'mapel_id' => $slot['mapel_id'],
                'teacher_id' => $slot['teacher_id'] ?? null,
                'start_time' => $slot['start_time'],
                'end_time' => $slot['end_time'],
                'slot_order' => $order + 1,
                'topic' => $slot['topic'] ?? null
            ]);
        }

        return redirect()->route('admin.day-templates.index')->with('success', 'Day template created');
    }

    public function show(DayTemplate $dayTemplate)
    {
        $dayTemplate->load('slots.mapel', 'slots.teacher');
        return view('admin.day-templates.show', compact('dayTemplate'));
    }

    public function edit(DayTemplate $dayTemplate)
    {
        $dayTemplate->load('slots');
        $mapels = Mapel::all();
        $teachers = Teacher::all();
        return view('admin.day-templates.edit', compact('dayTemplate', 'mapels', 'teachers'));
    }

    public function update(Request $request, DayTemplate $dayTemplate)
    {
        $v = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'slots' => 'required|array|min:1',
            'slots.*.start_time' => 'required|date_format:H:i',
            'slots.*.end_time' => 'required|date_format:H:i',
            'slots.*.mapel_id' => 'required|exists:mapels,id',
            'slots.*.teacher_id' => 'nullable|exists:teachers,id',
            'slots.*.topic' => 'nullable|string'
        ]);

        $dayTemplate->update([
            'name' => $v['name'],
            'description' => $v['description'] ?? null
        ]);

        // Delete old slots
        $dayTemplate->slots()->delete();

        // Create new slots
        foreach ($v['slots'] as $order => $slot) {
            DaySlot::create([
                'day_template_id' => $dayTemplate->id,
                'mapel_id' => $slot['mapel_id'],
                'teacher_id' => $slot['teacher_id'] ?? null,
                'start_time' => $slot['start_time'],
                'end_time' => $slot['end_time'],
                'slot_order' => $order + 1,
                'topic' => $slot['topic'] ?? null
            ]);
        }

        return redirect()->route('admin.day-templates.index')->with('success', 'Day template updated');
    }

    public function destroy(DayTemplate $dayTemplate)
    {
        $dayTemplate->delete();
        return back()->with('success', 'Day template deleted');
    }
}
