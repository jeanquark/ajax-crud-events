<?php namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Validator;
use Response;
use App\Event;
use View;




class EventsController extends Controller
{
    protected $rules=[
        'name'=>'required|min:4|max:32|regex:/^[a-z ,.\'-]+$/i'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();

        return view('events.index', ['events' =>  $events]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(Input::all(),$this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors'=>$validator->getMessageBag()->toArray()));
        } else {
            $event = new Event();
            $event->name = $request->name;
            $event->date = $request->date;
            $event->start_time = $request->start_time;
            $event->end_time = $request->end_time;
            $event->type = $request->type;
            $event->audience = $request->audience;
            $event->save();
            return response()->json($event);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('event.show', ['event' => $event]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(Input::all(),$this->rules);

        if ($validator->fails()) {
            return Response::json(array('errors'=>$validator->getMessageBag()->toArray()));
        } else {
            $event = Event::findOrFail($id);
            $event->name = $request->name;
            $event->type = $request->type;
            $event->date = $request->date;
            $event->start_time = $request->start_time;
            $event->end_time = $request->end_time;
            $event->audience = $request->audience;
            $event->save();
            return response()->json($event);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return response()->json($event);

    }

    /**
     * Change status of the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatus()
    {
        $id = Input::get('id');
        $event = Event::findOrFail($id);
        $event->is_published = !$event->is_published;
        $event->save();
        return response()->json($event);
    }
}