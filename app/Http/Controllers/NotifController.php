<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class NotifController extends RootController
{

    public static function notifsRappel(): array
    {

        $notifs = [];

        $events = Event::eventsForBill();
        $start = time();

        foreach ($events as $event){

            $end = strtotime($event->date_start);

            $days_between = (int)(($end- $start)/24/3600);

            if (in_array($days_between, [1, 5])) {

                $notifs[] = $event;

            }

        }

        return $notifs;


    }
}
