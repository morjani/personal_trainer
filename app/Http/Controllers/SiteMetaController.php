<?php

namespace App\Http\Controllers;

use App\Models\Attachement;
use App\Models\Site_meta;
use Illuminate\Http\Request;

class SiteMetaController extends RootController
{
    public function Settings(){

        $metas = Site_meta::allMetas();

        $result = null;

        foreach ($metas as $meta){

            if($meta->is_file){

                $attachement = Attachement::getAttachementByTable('site_metas',$meta->id);
                $result[$meta->name] = $attachement->link;

            }
            else
                $result[$meta->name] = $meta->value;

        }

        $data = [
            'page' => 'Configuration',
            'result' => $result
        ];

        back_view('site_meta.settings',$data);

    }
}
