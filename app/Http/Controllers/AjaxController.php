<?php

namespace App\Http\Controllers;

use App\Models\Attachement;
use App\Models\bill;
use App\Models\Bill_detail;
use App\Models\City;
use App\Models\Contact;
use App\Models\Event;
use App\Models\Event_category;
use App\Models\Site_meta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\Service;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;


class AjaxController extends RootController
{
    public function saveService(Request $request): JsonResponse
    {

        $res = (object) [
            'status'=>'FAILED',
            'result'=>null,
            'message'=>'Veuillez vérifier les informations et réessayer'
        ];

        $fields = Validator::make($request->all(),[
            'name'=>'required|string',
            'price'=>'required|string',
        ]);

        if(!$fields->fails()) {

            $data = [
                'name' => $request->post('name'),
                'price' => $request->post('price'),
                'description' => $request->post('description'),
                'category_id' => $request->post('category_id'),
                'user_id' => currentUser()->user->id
            ];

            $service_model = new Service();

            if($request->post('service_id'))
                $save = $service_model->updateService($request->post('service_id'),$data);
            else
                $save = $service_model->storeService($data);

            if ($save) {

                $res->status = 'SUCCESS';
                $res->result = $save;
                $res->message = 'Les données sont enregistrées avec succès.';

            }
        }

        return response()->json($res);

    }

    public function deleteService(Request $request): JsonResponse
    {

        $res = (object) [
            'status'=>'FAILED',
            'message'=>'Veuillez vérifier les informations et réessayer'
        ];

        $service_model = new Service();
        $deleted = $service_model->deleteService($request->post('service_id'));

        if($deleted){

            $res->status = 'SUCCESS';
            $res->message = 'Les données sont supprimé avec succès.';

        }

        return response()->json($res);

    }

    public function saveCategory(Request $request): JsonResponse
    {

        $res = (object) [
            'status'=>'FAILED',
            'result'=>null,
            'message'=>'Veuillez vérifier les informations et réessayer'
        ];

        $fields = Validator::make($request->all(),[
            'name'=>'required|string',
        ]);

        if(!$fields->fails()) {

            $data = [
                'name' => $request->post('name'),
                'description' => $request->post('description'),
                'user_id' => currentUser()->user->id
            ];

            $category_model = new Category();

            if($request->post('category_id'))
                $save = $category_model->updateCategory($request->post('category_id'),$data);
            else
                $save = $category_model->storeCategory($data);

            if ($save) {

                $res->status = 'SUCCESS';
                $res->result = $save;
                $res->message = 'Les données sont enregistrées avec succès.';

            }
        }

        return response()->json($res);

    }

    public function deleteCategory(Request $request): JsonResponse
    {

        $res = (object) [
            'status'=>'FAILED',
            'message'=>'Veuillez vérifier les informations et réessayer'
        ];

        $category_modele = new Category();
        $deleted = $category_modele->deleteCategory($request->post('category_id'));

        if($deleted){

            $res->status = 'SUCCESS';
            $res->message = 'Les données sont enregistrées avec succès.';

        }

        return response()->json($res);

    }

    public function saveCustomer(Request $request): JsonResponse
    {

        $res = (object) [
            'status'=>'FAILED',
            'result'=>null,
            'message'=>'Veuillez vérifier les informations et réessayer'
        ];

        $fields = Validator::make($request->all(),[
            'last_name'=>'required|string',
        ]);

        if(!$fields->fails()) {

            $data = [
                'last_name' => $request->post('last_name'),
                'phone' => $request->post('phone'),
                'mobile' => $request->post('mobile'),
                'fax' => $request->post('fax'),
                'email' => $request->post('email'),
                'country_id' => $request->post('country_id'),
                'city_id' => $request->post('city_id'),
                'zip_code' => $request->post('zip_code'),
                'ice' => $request->post('ice'),
                'address' => $request->post('address'),
                'prospect' => $request->post('prospect')*1,
                'user_id' => currentUser()->user->id
            ];

            $customer_model = new Customer();

            if($request->post('customer_id'))
                $save = $customer_model->updateCustomer($request->post('customer_id'),$data);
            else
                $save = $customer_model->storeCustomer($data);

            $image = $request->file('image');

            $get_image = Attachement::getAttachementByTable('customers',$save);

            if($get_image)
                uploadFile($image,'customers',$save,'customers',$get_image->id);
            else
                uploadFile($image,'customers',$save,'customers');

            if ($save) {

                $res->status = 'SUCCESS';
                $res->result = $save;
                $res->message = 'Les données sont enregistrées avec succès.';

            }
        }

        return response()->json($res);

    }

    public function deleteCustomer(Request $request): JsonResponse
    {

        $res = (object) [
            'status'=>'FAILED',
            'message'=>'Veuillez vérifier les informations et réessayer'
        ];

        $customer_model = new Customer();
        $deleted = $customer_model->deleteCustomer($request->post('customer_id'));

        if($deleted){

            $res->status = 'SUCCESS';
            $res->message = 'Les données sont enregistrées avec succès.';

        }

        return response()->json($res);

    }

    public function searchCity(Request $request): JsonResponse
    {

        $result = null;
        $search = $request->get('term') ? $request->get('term')['term'] : null;

        if($search)
            $result = City::searchCities($search);

        return response()->json($result);

    }

    public function searchService(Request $request): JsonResponse
    {

        $result = null;
        $search = $request->get('term') ? $request->get('term')['term'] : null;

        if($search)
            $result = Service::searchServices($search);

        return response()->json($result);

    }

    public function getService($id): JsonResponse
    {
        $service = new Service();
        $result = Service::showService($id);

        return response()->json($result);

    }

    public function searchCustomer(Request $request): JsonResponse
    {

        $result = null;
        $search = $request->get('term') ? $request->get('term')['term'] : null;

        if($search)
            $result = Customer::searchCustomer($search);

        return response()->json($result);

    }

    public function billStatis(): JsonResponse
    {
        $res = [
            'total_canceled' => 0,
            'total_proforma' => 0,
            'total_bill' => 0
        ];

        $statis = bill::stateCountBill();

        foreach ($statis as $stati){

            if($stati->state == -1)
                $res['total_canceled'] = $stati->total;

            if($stati->state == 0)
                $res['total_proforma'] = $stati->total;

            if($stati->state == 1)
                $res['total_bill'] = $stati->total;

        }

        return response()->json($res);

    }

    public function billSuivi()
    {

        $data = [
            'month' => [
                'sum' => 0,
                'sum_canceled' => 0,
                'sum_proforma' => 0,
                'sum_factures' => 0,
            ],
            'canceled_total' => 0,
            'proforma_total' => 0,
            'factures_total' => 0,
            'count_bills' => [
                'canceled' => [],
                'proforma' => [],
                'factures' => []
            ]
        ];

        $sum = bill::sumBillMonth();

        foreach ($sum as $sm){

            if($sm->state == -1)
                $data['month']['sum_canceled'] = (float)$sm->total;

            if($sm->state == 0)
                $data['month']['sum_proforma'] = (float)$sm->total;

            if($sm->state == 1)
                $data['month']['sum_factures'] = (float)$sm->total;

            $data['month']['sum']+=$sm->total;
        }

        $data['month']['percentage_canceled'] = $data['month']['sum_canceled'] ?
            number_format(($data['month']['sum_canceled']/$data['month']['sum'])*100,0) : 0;

        $data['month']['percentage_proforma'] = $data['month']['sum_proforma'] ?
            number_format(($data['month']['sum_proforma']/$data['month']['sum'])*100,0) : 0;

        $data['month']['percentage_factures'] = $data['month']['sum_factures'] ?
            number_format(($data['month']['sum_factures']/$data['month']['sum'])*100,0) : 0;

        $totals = bill::sumBill();

        foreach ($totals as $total){

            if($total->state == -1)
                $data['canceled_total'] = number_format($total->total,2);

            if($total->state == 0)
                $data['proforma_total'] = number_format($total->total,2);

            if($total->state == 1)
                $data['factures_total'] = number_format($total->total,2);

        }

        $count_bills = bill::countBillMonth();

        for($i=1;$i<=12;$i++){

            $find_canceled = 0;
            $find_proforma = 0;
            $find_factures = 0;

            foreach ($count_bills as $count_bill){

                if($i == $count_bill->mnth){

                    if($count_bill->state == -1)
                        $find_canceled = $count_bill->count;

                    if($count_bill->state == 0)
                        $find_proforma = $count_bill->count;

                    if($count_bill->state == 1)
                        $find_factures = $count_bill->count;
                }
            }

            $data['count_bills']['canceled'][] = $find_canceled;
            $data['count_bills']['proforma'][] = $find_proforma;
            $data['count_bills']['factures'][] = $find_factures;

        }

        back_view('bill.bill_suivi',$data,true);

    }

    public function saveBill(Request $request): JsonResponse
    {
        $res = (object) [
            'status'=>'FAILED',
            'message'=>'Veuillez vérifier les informations et réessayer'
        ];

        $fields = Validator::make($request->all(),[
            'customer_id'=>'required|integer',
            'date'=>'required|string',
            'payment_method'=>'required|string'
        ]);

        if(!$fields->fails()) {

            $last_bill = bill::lastBill();
            $reference = $last_bill ? $last_bill->id+1 : 1;

            $data = [
                'customer_id' => $request->post('customer_id'),
                'date' => $request->post('date'),
                'event_date' => $request->post('event_date'),
                'payment_method' => $request->post('payment_method'),
                'total_ht' => $request->post('total_ht'),
                'total_ttc' => $request->post('total_ttc'),
                'reference' => '#'.$reference,
                'number' => str_pad($reference, 7, "0", STR_PAD_LEFT),
                'description' => $request->post('description'),
                'additional_information' => $request->post('additional_information'),
                'state' => $request->post('state') == '' ? 0 : $request->post('state'),
                'user_id' => currentUser()->user->id
            ];

            $bill_model = new bill();

            if($request->post('bill_id')){
                unset($data['reference']);
                unset($data['number']);
                $updated = $bill_model->updateBill($request->post('bill_id'),$data);
                $inserted_id = null;

                if($updated){
                    $inserted_id = $request->post('bill_id');
                    Bill_detail::deleteDetailByBill($inserted_id);
                }

            }

            else{
                $inserted = $bill_model->storeBill($data);
                $inserted_id = $inserted?->id;
            }

            if ($inserted_id) {

                if($request->post('event_date')){

                    $event_check = Event::checkEventBill('bill',$inserted_id);

                    $data_event = [
                        'title' => $request->post('event_title'),
                        'class_name' => 'bg-info',
                        'description' => '',
                        'event_for' => 'bill',
                        'bill_id' => $inserted_id,
                        'date_start' => $request->post('event_date'),
                        'date_end' => $request->post('event_date'),
                        'user_id' => currentUser()->user->id
                    ];

                    $event_model = new Event();

                    if(!$event_check)
                        $event_model->storeEvent($data_event);

                    else
                        $event_model->updateEvent($event_check->id,$data_event);

                    }
                else
                    Event::deleteEventBill('bill',$inserted_id);


                $services = $request->get('services');

                $customer = new Customer();
                $customer->updateCustomer($request->post('customer_id'),['prospect'=>1]);

                $bill_detail_model = new Bill_detail();

                foreach ($services as $service){

                    $detail = [
                      'bill_id' => $inserted_id,
                      'service_id' => $service['service']['id'],
                      'price' => $service['price'],
                      'quantity' => $service['qty'],
                      'description' => $service['description'],
                      'total' => $service['total'],
                      'with_tva' => $service['with_tva'],
                      'user_id' => currentUser()->user->id
                    ];

                    $bill_detail_model->storeBillDetail($detail);

                }

                $res->status = 'SUCCESS';
                $res->message = 'Les données sont enregistrées avec succès.';

            }
        }

        return response()->json($res);
    }

    public function validProforma(Request $request): JsonResponse
    {

        $res = (object) [
            'status'=>'FAILED',
            'message'=>'Veuillez vérifier les informations et réessayer'
        ];

        $bill_model = new bill();

        $updated = $bill_model->updateBill($request->post('bill_id'),['state'=>1]);

        if($updated){

            $res->status = 'SUCCESS';
            $res->message = 'Les données sont enregistrées avec succès.';

        }

        return response()->json($res);

    }

    public function canceledBill(Request $request): JsonResponse
    {

        $res = (object) [
            'status'=>'FAILED',
            'message'=>'Veuillez vérifier les informations et réessayer'
        ];

        $bill_model = new bill();

        $updated = $bill_model->updateBill($request->post('bill_id'),['state'=>-1]);

        if($updated){

            $res->status = 'SUCCESS';
            $res->message = 'Les données sont enregistrées avec succès.';

        }


        return response()->json($res);

    }

    public function deletedBill(Request $request): JsonResponse
    {

        $res = (object) [
            'status'=>'FAILED',
            'message'=>'Veuillez vérifier les informations et réessayer'
        ];

        $bill_model = new bill();

        $deleted = $bill_model->deletedBill($request->post('bill_id'));

        if($deleted){

            $res->status = 'SUCCESS';
            $res->message = 'Les données sont supprimer avec succès.';

        }


        return response()->json($res);

    }

    public function saveEvent(Request $request): JsonResponse
    {

        $res = (object) [
            'status'=>'FAILED',
            'result'=>null,
            'message'=>'Veuillez vérifier les informations et réessayer'
        ];

        $fields = Validator::make($request->all(),[
            'title'=>'required|string',
            'class_name'=>'required|string',
        ]);

        if(!$fields->fails()) {

            $data = [
                'title' => $request->post('title'),
                'class_name' => $request->post('class_name'),
                'description' => $request->post('description'),
                'date_start' => date('Y-m-d',strtotime($request->post('start'))),
                'date_end' => date('Y-m-d',strtotime($request->post('end').'+ 1 day')),
                'user_id' => currentUser()->user->id
            ];

            $event_model = new Event();

            $save = null;

            if($request->post('event_id')){

              /*  unset($data['date_start']);
                unset($data['date_end']);*/
                $updated = $event_model->updateEvent($request->post('event_id'),$data);

                if($updated)
                    $save = $event_model->showEvent($request->post('event_id'));
            }
            else
                $save = $event_model->storeEvent($data);

            if ($save) {

                $res->status = 'SUCCESS';
                $res->result = $save;
                $res->message = 'Les données sont enregistrées avec succès.';

            }
        }

        return response()->json($res);

    }

    public function deleteEvent(Request $request): JsonResponse
    {
        $res = (object) [
            'status'=>'FAILED',
            'message'=>'Veuillez vérifier les informations et réessayer'
        ];

        $event_model = new Event();
        $deleted = $event_model->deleteEvent($request->post('event_id'));

        if($deleted){

            $res->status = 'SUCCESS';
            $res->message = 'Les données sont supprimé avec succès.';

        }

        return response()->json($res);
    }

    public function saveProfile(Request $request): JsonResponse
    {

        $res = (object) [
            'status'=>'FAILED',
            'result'=>null,
            'message'=>'Veuillez vérifier les informations et réessayer'
        ];

        $fields = Validator::make($request->all(),[
            'first_name'=>'required|string',
            'last_name'=>'required|string',
        ]);

        if(!$fields->fails()) {

            $data = [
                'first_name' => $request->post('first_name'),
                'last_name' => $request->post('last_name'),
                'email' => $request->post('email'),
                'name' => $request->post('name'),
            ];

            $user_model = new User();

            if($request->post('id')){

                if(!User::profileByEmail($request->post('email'),$request->post('id'))){

                    if(!User::profileByName($request->post('name'),$request->post('id'))){

                        $save = $user_model->updateUser($request->post('id'),$data);

                        if($save){

                            $image = $request->file('image');

                            $get_image = Attachement::getAttachementByTable('users',$request->post('id'));

                            if($get_image)
                                uploadFile($image,'users',$request->post('id'),'users',$get_image->id);
                            else
                                uploadFile($image,'users',$request->post('id'),'users');

                            $session = new Session();
                            $session->set('current_user', User::showProfile($request->post('id')));

                            $res->status = 'SUCCESS';
                            $res->result = $save;
                            $res->message = 'Les données sont enregistrées avec succès.';
                        }



                    }
                    else
                        $res->message = "Le nom d'utilisateur est déja existe";

                }

                else
                    $res->message = "L'adresse email est déja existe";

            }


        }

        return response()->json($res);

    }

    public function updatePassword(Request $request): JsonResponse
    {
        $res = (object) [
            'status'=>'FAILED',
            'message'=>'Veuillez vérifier les informations et réessayer'
        ];

        $password = Hash::make($request->post('new_password'));

        if(Hash::isHashed($password)){

            $user_model = new User();
            $updated = $user_model->updateUser($request->post('id'),['password'=>$password]);

            if($updated){

                $res = (object) [
                    'status'=>'SUCCESS',
                    'message'=>'Les données sont enregistrées avec succès.'
                ];

            }

        }

        return response()->json($res);
    }

    public function checkPassword($id,Request $request)
    {
        $user = User::showProfile($id);

        if(Hash::check($request->post('current_password'),$user->password))
            echo 'true';
        else
            echo 'false';
    }

    public function saveSetting(Request $request): JsonResponse
    {

        $res = (object) [
            'status'=>'FAILED',
            'message'=>'Veuillez vérifier les informations et réessayer'
        ];

        foreach ($request->post() as $key=>$value){
            Site_meta::updateSiteMeta($key,['value'=>$value]);
        }

        foreach ($request->file() as $key=>$value){

            $get_meta = Site_meta::metaByName($key);

            $get_attachement = null;

            if($get_meta)
                $get_attachement = Attachement::getAttachementByTable('site_metas',$get_meta->id);

            if($get_attachement)
                uploadFile($value,'site_metas',$get_meta->id,'site_metas',$get_attachement->id);
            else
                uploadFile($value,'site_metas',$get_meta->id,'site_metas');

        }

        $res->status = 'SUCCESS';
        $res->message = 'Les données sont enregistrées avec succès.';

        return response()->json($res);

    }

    public function getEvent($id): JsonResponse
    {

        $res = (object) [
            'status'=>'FAILED',
            'result'=>'FAILED',
            'message'=>'Veuillez vérifier les informations et réessayer'
        ];

        $event = Event::showEvent($id);

        if($event){

            $res = (object) [
                'status'=>'SUCCESS',
                'result'=>$event,
                'message'=>''
            ];

        }

        return response()->json($res);

    }

    public function saveUser(Request $request): JsonResponse
    {

        $res = (object) [
            'status'=>'FAILED',
            'result'=>null,
            'message'=>'Veuillez vérifier les informations et réessayer'
        ];

        $fields = Validator::make($request->all(),[
            'first_name'=>'required|string',
            'last_name'=>'required|string',
            'name'=>'required|string',
            'email'=>'required|string',
            'password'=>'required|string',
        ]);

        if(!$fields->fails()) {

            $password_hash = Hash::make($request->post('password'));

            $data = [
                'first_name' => $request->post('first_name'),
                'last_name' => $request->post('last_name'),
                'email' => $request->post('email'),
                'name' => $request->post('name'),
                'password' => $password_hash,
            ];

            $user_model = new User();

            if(!User::profileByEmail($request->post('email'))){

                if(!User::profileByName($request->post('name'))){

                    $save = $user_model->storeUser($data);

                    if($save){

                        $image = $request->file('image');

                        uploadFile($image,'users',$save->id,'users');

                        $res->status = 'SUCCESS';
                        $res->result = $save;
                        $res->message = 'Les données sont enregistrées avec succès.';
                    }

                }
                else
                    $res->message = "Le nom d'utilisateur est déja existe";

            }

            else
                $res->message = "L'adresse email est déja existe";



        }

        return response()->json($res);

    }

    public function updateEventCategory(Request $request): JsonResponse
    {

        $res = (object) [
            'status'=>'FAILED',
            'result'=>null,
            'message'=>'Veuillez vérifier les informations et réessayer'
        ];

        $fields = Validator::make($request->all(),[
            'name'=>'required|string',
        ]);

        if(!$fields->fails()) {

            $data = [
                'name' => $request->post('name'),
            ];

            $event_category_model = new Event_category();

            $save = null;

            if($request->post('id'))
                $save = $event_category_model->updateEventCategory($request->post('id'),$data);

            if ($save) {

                $res->status = 'SUCCESS';
                $res->result = $save;
                $res->message = 'Les données sont enregistrées avec succès.';

            }
        }

        return response()->json($res);

    }

    public function saveContact(Request $request): JsonResponse
    {
        $res = (object) [
            'status'=>'FAILED',
            'result'=>null,
            'message'=>'Veuillez vérifier les informations et réessayer'
        ];

        $fields = Validator::make($request->all(),[
            'name'=>'required|string',
            'email'=>'required|string',
            'phone'=>'required|string',
            'subject'=>'required|string',
            'message'=>'required|string',
        ]);

        if(!$fields->fails()) {

            $data = [
                'name' => $request->post('name'),
                'email' => $request->post('email'),
                'phone' => $request->post('phone'),
                'subject' => $request->post('subject'),
                'message' => $request->post('message')
            ];

            $contact_model = new Contact();
            $save = $contact_model->storeContact($data);


            if ($save) {

                $res->status = 'SUCCESS';
                $res->result = $save;
                $res->message = 'Votre message a bien été envoyé.';

            }
        }

        return response()->json($res);

    }

}
