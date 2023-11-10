<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\Service;

class ServiceController extends RootController
{

    public function __construct(
        private $category = new Category(),
        private $service = new Service()
    )
    {
    }

    public function index(){

        back_view('service.services',['page'=>'Services']);

    }

    public function dtService(Request $request): JsonResponse
    {

        $query = "select s.*,c.name as `category_name`  from crm_services s"
            ." left join crm_categories c on c.id = s.category_id where s.deleted=0";

        $result = $this->DoDatatable($query,$request, function($i, $row){

            $row->actions = '<ul class="list-inline user-chat-nav text-center mb-0">'
                .'<li class="list-inline-item">'
                .'<div class="dropdown">'
                .'<button class="btn nav-btn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                .'<i class="bx bx-dots-horizontal-rounded"></i>'
                .'</button>'
                .'<div class="dropdown-menu dropdown-menu-end">'
                .'<a class="dropdown-item" href="JavaScript:void(0)" data-action="edit_service" data-id="'.$row->id.'">Modifier</a>'
                .'<a class="dropdown-item" href="JavaScript:void(0)" data-action="delete_service" data-id="'.$row->id.'">Supprimer</a>'
                .'</div>'
                .' </div>'
                .'</li>'
                .'</ul>';

        });

        return response()->json($result);

    }

    public function newService($id=null){

        $service = null;

        if($id)
            $service = Service::showService($id);

        $data=[
            'service' => $service,
            'categories' => $this->category->listCategories()
        ];

        back_view('service.new_service',$data,true);

    }


    public function categories(){

        back_view('service.categories',['page'=>'Catégories']);

    }

    public function dtCategory(Request $request): JsonResponse
    {

        $query = "select * from crm_categories where deleted=0";

        $result = $this->DoDatatable($query,$request, function($i, $row){

            $row->actions = '<ul class="list-inline user-chat-nav text-center mb-0">'
                .'<li class="list-inline-item">'
                .'<div class="dropdown">'
                .'<button class="btn nav-btn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                .'<i class="bx bx-dots-horizontal-rounded"></i>'
                .'</button>'
                .'<div class="dropdown-menu dropdown-menu-end">'
                .'<a class="dropdown-item" href="JavaScript:void(0)" data-action="edit_category" data-id="'.$row->id.'">Modifier</a>'
                .'<a class="dropdown-item" href="JavaScript:void(0)" data-action="delete_category" data-id="'.$row->id.'">Supprimer</a>'
                .'</div>'
                .' </div>'
                .'</li>'
                .'</ul>';

        });

        return response()->json($result);

    }

    public function newCategory($id=null){

        $category = null;

        if($id)
            $category = $this->category->showCategory($id);

        $data=[
            'category' => $category
        ];

        back_view('service.new_category',$data,true);

    }

}
