<?php

use App\Models\Attachement;
use App\Models\Site_meta;
use App\Http\Controllers\NotifController;
use Symfony\Component\HttpFoundation\Session\Session;

function back_view($view, $data=array(), $no_assets=false, $return = false): bool|string
{


    if(!isset($data['page'])) $data['page'] = 'Accueil';

    $default = array(
        'page_title'     => $data['page'] . " | CRM",
        'notifs'     => NotifController::notifsRappel(),
    );

    $data = array_merge($data, $default);

    $output = '';

    if(!$no_assets) $output .= view('layouts/header',$data);
    if(!$no_assets) $output .= view('layouts/topbar',$data);
    if(!$no_assets) $output .= view('layouts/sidebar',$data);
    $output .= view($view,$data);
    if(!$no_assets) $output .= view('layouts/footer',$data);

    if(!$return) echo $output;

    return $return ? $output : TRUE;
}

function frontView($view, $data=array(), $no_assets=false, $return = false): bool|string
{


    if(!isset($data['page'])) $data['page'] = 'Accueil';

    $default = array(
        'page_title'     => $data['page'] . " | CRM",
    );

    $data = array_merge($data, $default);

    $output = '';

    if(!$no_assets) $output .= view('front/layouts/header',$data);
    $output .= view($view,$data);
    if(!$no_assets) $output .= view('front/layouts/footer',$data);

    if(!$return) echo $output;

    return $return ? $output : TRUE;
}

function currentUser(){

    $session = new Session();

    $current_user = (object) [
        'user' => null,
        'image' => null
    ];

    if($session->has('current_user')){

        $user = $session->get('current_user');
        $attachement = Attachement::getAttachementByTable('users',$user->id);

        $current_user->user = $user;
        $current_user->image = $attachement ? $attachement->link : defaultImageProfile();

    }

    return $current_user;

}

function defaultImageProfile(){

    return '/assets/images/users/user.png';

}

function defaultLogoSite(){

    return '/assets/images/verychic_logo.png';

}

function defaultLogo(){

    return url('/assets/images/example-logo-light.png');

}

function uploadFile($file,$table,$id_table,$path,$id=null) {

    if($file){

        $file_name = $file->getClientOriginalName();
        $file_ext = $file->extension();
        $file_type = $file->getType();
        $file->move(public_path('uploads/'.$path), $file_name);

        $data_attachement = [
            'relation_text' => $table,
            'relation_id' => $id_table,
            'name' => $file_name,
            'type' => $file_type,
            'mime_type' => $file_ext,
            'link' => '/uploads/'.$path.'/'.$file_name
        ];

        if($id)
            Attachement::updateAttachement($id,$data_attachement);
        else
            Attachement::storeAttachement($data_attachement);

    }

}

function getMetaByName($name){

    $meta = Site_meta::metaByName($name);

    return $meta ? $meta->value : '';

}

function getSiteLogo(){

    $meta = Site_meta::metaByName('site_logo');

    $attachement = Attachement::getAttachementByTable('site_metas',$meta->id);

    return $attachement ? $attachement->link : defaultLogo();

}

function getSiteImage($image){

    $meta = Site_meta::metaByName($image);

    $attachement = Attachement::getAttachementByTable('site_metas',$meta->id);

    return $attachement ? $attachement->link : '';

}

function getLogoBill(){

    $meta = Site_meta::metaByName('site_logo');

    $attachement = Attachement::getAttachementByTable('site_metas',$meta->id);

    return $attachement ? url($attachement->link) : defaultLogo();

}

function crmCurreny(): string
{

    return 'DH';

}

function stateBill($state): string
{

    $data_state = [
        '-1' => 'ANNULER',
        '0' => 'PROFORMA',
        '1' => 'FACTURE'
    ];

    return $data_state[$state];

}


