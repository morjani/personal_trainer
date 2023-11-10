<?php

namespace App\Http\Controllers;

use App\Models\Attachement;
use App\Models\Site_meta;
use Illuminate\Http\Request;

class SiteMetaController extends RootController
{
    public function Settings(){

        $metas = Site_meta::allMetas();

        $logo_site = null;
        $logo_bill = null;
        $bill_information_compl = null;
        $bill_information_verychic = null;

        foreach ($metas as $meta){

            if($meta->name == 'bill_information_complementaire')
                $bill_information_compl = $meta->value;

            if($meta->name == 'bill_information_verychic')
                $bill_information_verychic = $meta->value;

            if($meta->name == 'logo_site'){

                $attachement = Attachement::getAttachementByTable('site_metas',$meta->id);
                $logo_site = $attachement->link;

            }

            if($meta->name == 'logo_bill'){

                $attachement = Attachement::getAttachementByTable('site_metas',$meta->id);
                $logo_bill = $attachement->link;

            }

        }

        $data = [
            'page' =>'Configuration',
            'bill_information_compl' => $bill_information_compl,
            'bill_information_verychic' => $bill_information_verychic,
            'logo_site' => $logo_site,
            'logo_bill' => $logo_bill,
        ];

        back_view('site_meta.settings',$data);

    }
}
