<?php

namespace App\Http\Controllers;

use App\Models\Attachement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Customer;
use App\Models\Country;
use App\Models\City;

class CustomerController extends RootController
{
    public function __construct(
        private $customer = new Customer()
    )
    {
    }

    public function index(){

        back_view('customer.customers',['page'=>'Clients']);

    }

    public function prospect(){

        back_view('customer.prospect',['page'=>'Prospect']);

    }

    public function dtCustomer(Request $request): JsonResponse
    {

        $query = "select c.*,o.name as `country_name`,t.name as `city_name`  from crm_customers c"
            ." left join crm_countries o on o.id = c.country_id"
            ." left join crm_cities t on t.id = c.city_id"
            ." where c.prospect =1 and c.deleted=0";

        $result = $this->DoDatatable($query,$request, function($i, $row){

            $row->actions = '<ul class="list-inline user-chat-nav text-center mb-0">'
                .'<li class="list-inline-item">'
                .'<div class="dropdown">'
                .'<button class="btn nav-btn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                .'<i class="bx bx-dots-horizontal-rounded"></i>'
                .'</button>'
                .'<div class="dropdown-menu dropdown-menu-end">'
                .'<a class="dropdown-item" href="JavaScript:void(0)" data-action="edit_customer" data-id="'.$row->id.'">Modifier</a>'
                .'<a class="dropdown-item" href="JavaScript:void(0)" data-action="delete_customer" data-id="'.$row->id.'">Supprimer</a>'
                .'</div>'
                .' </div>'
                .'</li>'
                .'</ul>';

        });

        return response()->json($result);

    }
    public function dtProspect(Request $request): JsonResponse
    {

        $query = "select c.*,o.name as `country_name`,t.name as `city_name`  from crm_customers c"
            ." left join crm_countries o on o.id = c.country_id"
            ." left join crm_cities t on t.id = c.city_id"
            ." where c.prospect =0 and c.deleted=0";

        $result = $this->DoDatatable($query,$request, function($i, $row){

            $row->actions = '<ul class="list-inline user-chat-nav text-center mb-0">'
                .'<li class="list-inline-item">'
                .'<div class="dropdown">'
                .'<button class="btn nav-btn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                .'<i class="bx bx-dots-horizontal-rounded"></i>'
                .'</button>'
                .'<div class="dropdown-menu dropdown-menu-end">'
                .'<a class="dropdown-item" href="JavaScript:void(0)" data-action="edit_customer" data-id="'.$row->id.'">Modifier</a>'
                .'<a class="dropdown-item" href="JavaScript:void(0)" data-action="delete_customer" data-id="'.$row->id.'">Supprimer</a>'
                .'</div>'
                .' </div>'
                .'</li>'
                .'</ul>';

        });

        return response()->json($result);

    }

    public function newCustomer(Request $request,$id=null){

        $customer = null;
        $city = null;
        $attachement = null;

        $prospect = $request->get('prospect');

        if($id){

            $customer = Customer::showCustomer($id);
            $prospect = $customer->prospect;
            $city = City::showCity($customer->city_id);
            $attachement = Attachement::getAttachementByTable('customers',$id);

        }

        $data=[
            'customer' => $customer,
            'prospect' => $prospect,
            'countries' => Country::listCountries(),
            'cities' => City::listCities(),
            'city' => $city,
            'attachement' => $attachement
        ];

        back_view('customer.new_customer',$data,true);

    }
}
