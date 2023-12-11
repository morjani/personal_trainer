<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Session\Session;

class RootController extends Controller
{
    public function __construct(){

        $session = new Session();

        if(!$session->has('current_user'))
            return redirect('/login');

    }
    public function DoDatatable($query,$request,$callback = null){

        $callback = $callback ?: function () {};

        $length = $request->get('length') ?: 10;

        $offset=$request->get('start') ?: 0;

        $order = $request->get('columns')[intval($request->get('order')[0]['column'])]['name'];

        $dir = $request->get('order')[0]['dir'];

        $search = $request->get('search')['value'] ?: '';

        $sfilter = '';

        foreach ($request->get('columns') as $col) {

            $col = (object)$col;

            if ($col->searchable === "false") continue;

            $sfilter .= ($sfilter ? ' OR ' : ' ') . "{$col->name} like '%$search%' ";


        }

        $query_str = "SELECT * FROM ($query) t WHERE 1=1 AND $sfilter";

        $query = DB::select($query_str . " ORDER BY $order $dir LIMIT $length offset $offset");

        $totals = DB::select("SELECT COUNT(*) total FROM ($query_str) t");

        foreach ($query as $i => $row) {


            $callback($i, $row, $query);

        }

        $return = array(

            'draw' => $request->get('draw') ?: 0,

            'recordsTotal' => count($totals),

            'recordsFiltered' => count($query),

            'data' => $query,

        );

        return ((object)$return);

    }

    public function index(){


        frontView('front.index',[]);
    }

}
