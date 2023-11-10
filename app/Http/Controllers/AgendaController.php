<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Event_category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AgendaController extends RootController
{

    public function __construct()
    {
    }

    public function index(){

        $events = [];
        $event_categories = Event_category::listEventCategories();
        $data_events = Event::listEvents();

        foreach ($data_events as $event){

            $events[] = [
               'id' => $event->id,
               'title' => $event->title,
               'start' => date('Y-m-d',strtotime($event->date_start)),
               'end' => date('Y-m-d',strtotime($event->date_end)),
               'allDay' => 1,
               'className' => $event->class_name,
               'description' => $event->description,
            ];

        }

        $data = [
            'page' =>'Agenda',
            'event_categories' => $event_categories,
            'events' => $events
        ];

        back_view('agenda.agenda',$data);

    }

    public function editEventCategory($id){

        $event_category = null;

        if($id)
            $event_category = Event_category::showEventCategory($id);

        $data=[
            'event_category' => $event_category
        ];

        back_view('agenda.edit_event_category',$data,true);

    }


}
