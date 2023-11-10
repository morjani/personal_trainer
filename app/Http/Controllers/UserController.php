<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Attachement;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends RootController
{

    public function index(){

        back_view('user.users',['page'=>'Utilisateurs']);

    }

    public function dtUser(Request $request): JsonResponse
    {

        $query = "select u.*,CONCAT(u.first_name,' ',u.last_name) as 'fullname',a.link as 'image'  from crm_users u"
            ." left join crm_attachements a on u.id = a.relation_id and a.relation_text = 'users' and a.deleted = 0";

        $result = $this->DoDatatable($query,$request, function($i, $row){

            $row->image = '<img src="'.( $row->image ? $row->image : defaultImageProfile() ).'" style="width: 70px;">';

            $row->actions = '<ul class="list-inline user-chat-nav text-center mb-0">'
                .'<li class="list-inline-item">'
                .'<div class="dropdown">'
                .'<button class="btn nav-btn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" '
                .'aria-expanded="false">'
                .'<i class="bx bx-dots-horizontal-rounded"></i>'
                .'</button>'
                .'<div class="dropdown-menu dropdown-menu-end">'
                .'<a class="dropdown-item" href="JavaScript:void(0)" data-action="show_profile" '
                .'data-id="'.$row->id.'">Modifier</a>'
                .'<a class="dropdown-item" href="JavaScript:void(0)" data-action="change_password" '
                .'data-id="'.$row->id.'">Modifier le mot de passe</a>'
                .'</div>'
                .' </div>'
                .'</li>'
                .'</ul>';

        });

        return response()->json($result);

    }

    public function showProfile($id)
    {
        $profile = User::showProfile($id);

        $data=[
            'profile' => $profile,
            'attachement' => Attachement::getAttachementByTable('users',$id)
        ];

        back_view('user.show_profile',$data,true);
    }

    public function changePassword($id)
    {
        back_view('user.change_password',[],true);
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login')->with(['msg_body' => 'You signed out!']);
    }

    public function newUser(){

        back_view('user.new_user',['page'=>'Nouveau ulilisateur'],true);

    }


}
