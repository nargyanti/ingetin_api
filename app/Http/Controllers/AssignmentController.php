<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Assignment;
use Carbon\Carbon;
use Auth;
use DB;


class AssignmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {             
        $sortBy = $request->get('sortBy');
        $assignments = Assignment::where('user_id', Auth::user()->id)
                        ->orderByRaw("FIELD(status, 'DOING', 'DONE')")
                        ->orderBy('due_date','asc')
                        ->orderBy('due_time','asc')->get();
        switch ($sortBy) {
            case "due_date":
                $assignments = Assignment::where('user_id', Auth::user()->id)
                                ->orderByRaw("FIELD(status, 'DOING', 'DONE')")
                                ->orderBy('due_date','asc')
                                ->orderBy('due_time','asc')->get();
                break;
            case "course":
                $assignments = Assignment::where('user_id', Auth::user()->id)
                                ->orderByRaw("FIELD(status, 'DOING', 'DONE')")
                                ->orderBy('course','asc')
                                ->orderBy('due_date','asc')
                                ->orderBy('due_time','asc')->get();
                break;
            case "level":
                $assignments = Assignment::where('user_id', Auth::user()->id)
                                ->orderByRaw("FIELD(status, 'DOING', 'DONE')")
                                ->orderByRaw("FIELD(level, 'Very Easy', 'Easy', 'Medium', 'Hard', 'Very Hard')")
                                ->orderBy('due_date','asc')
                                ->orderBy('due_time','asc')
                                ->orderByRaw("FIELD(level, 'DOING', 'DONE')")->get();
                break;                
            case "priority":
                $assignments = Assignment::where('user_id', Auth::user()->id)
                                ->orderByRaw("FIELD(status, 'DOING', 'DONE')")
                                ->orderBy('due_date','asc')
                                ->orderBy('due_time','asc')
                                ->orderByRaw("FIELD(level, 'Very Easy', 'Easy', 'Medium', 'Hard', 'Very Hard')")
                                ->orderBy('estimation', 'asc')
                                ->orderByRaw("FIELD(level, 'DOING', 'DONE')")->get();
            default:
            $assignments = Assignment::where('user_id', Auth::user()->id)
                            ->orderByRaw("FIELD(status, 'DOING', 'DONE')")
                            ->orderBy('due_date','asc')
                            ->orderBy('due_time','asc')->get();
          }        
        return $assignments;
    }

    public function create()
    {        
        //        
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'course' => 'required',
            'due_time' => 'required',
            'due_date' => 'required',
            'level' => 'required',
            'estimation' => 'required',
        ]);
        
        $authUser = Auth::user();             
        $assignment = new Assignment;
        $assignment->user_id = $authUser->id;
        $assignment->name = $request->get('name');
        $assignment->course = $request->get('course');
        $assignment->description = $request->get('description');
        $assignment->submit_location = $request->get('submit_location');
        $assignment->due_date = $request->get('due_date');
        $assignment->due_time = $request->get('due_time');
        $assignment->level = $request->get('level');
        $assignment->estimation = $request->get('estimation');        

        $user = new User;
        $user->id = $assignment->user_id;
        $assignment->user()->associate($user);
        $assignment->save();         
        
        // redirect after add data
        return response()->json($assignment, 201);
    }

    public function show($id)
    {        
        $assignment = Assignment::find($id);                
        // $due_datetime = Carbon::parse($assignment->due_date . ' ' . $assignment->due_time, 'GMT+7');    
        // $timeRemaining;
        // if (Carbon::parse(Carbon::now('GMT+7'), 'GMT+7') > $due_datetime) {
        //     $timeRemaining = 0;
        // } else {
        //     $timeRemaining = Carbon::now('GMT+7')->diffInMinutes($due_datetime);
        // }        
        return $assignment;
    }

    public function edit($id)
    {
        // 
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'course' => 'required',
            'due_time' => 'required',
            'due_date' => 'required',
            'level' => 'required',
            'estimation' => 'required',
        ]);
                  
        $assignment = Assignment::find($id);        
        $assignment->name = $request->get('name');
        $assignment->course = $request->get('course');
        $assignment->description = $request->get('description');
        $assignment->submit_location = $request->get('submit_location');
        $assignment->due_date = $request->get('due_date');
        $assignment->due_time = $request->get('due_time');
        $assignment->level = $request->get('level');
        $assignment->estimation = $request->get('estimation');        

        $user = new User;
        $user->id = $assignment->user_id;
        $assignment->user()->associate($user);
        $assignment->save();         
        
        // redirect after add data
        return response()->json($assignment, 200);
    }

    public function destroy($id)
    {
        Assignment::find($id)->delete();
        return response()->json(null, 204);
    }

    public function reset_assignment($id)
    {
        Assignment::where('user_id', $id)->delete();
        return redirect()->route('reset_data')
            ->with('success', 'Assignment Successfully Reset');
    }

    public function markAsDone($id) {
        $assignment = Assignment::find($id);        
        $assignment->status = 'DONE';
        
        $user = new User;
        $user->id = $assignment->user_id;
        $assignment->user()->associate($user);
        $assignment->save();         
        
        // redirect after add data
        return redirect()->route('assignment.index');
    }
}
