<?php

namespace App\Http\Controllers;

use App\Models\Bill_detail;
use App\Models\City;
use App\Models\Customer;
use App\Models\Event;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\bill;
use Barryvdh\DomPDF\Facade\Pdf;

class BillController extends RootController
{

    const STATE = [
        '0' => 'ANNULER',
        '1' => 'PFORORMA',
        '2' => 'FACTURE'
    ];

    public function __construct(
        private $bill = new bill()
    )
    {
    }

    public function index(){

        back_view('bill.billes',['page'=>'Factures']);

    }

    public function dtProforma(Request $request): JsonResponse
    {

        $query = "select b.*,c.last_name as `customer`,u.name from crm_bills b"
            ." left join crm_customers c on c.id= b.customer_id and c.deleted = 0"
            ." left join crm_users u on u.id= b.user_id"
            ." where b.state = 0 and b.deleted =0";

        $result = $this->DoDatatable($query,$request, function($i, $row){

            $row->actions = '<ul class="list-inline user-chat-nav text-center mb-0">'
                .'<li class="list-inline-item">'
                .'<div class="dropdown">'
                .'<button class="btn nav-btn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                .'<i class="bx bx-dots-horizontal-rounded"></i>'
                .'</button>'
                .'<div class="dropdown-menu dropdown-menu-end">'
                .'<a class="dropdown-item" href="/bill/new-bill/'.$row->id.'">Modifier</a>'
                .'<a class="dropdown-item" href="JavaScript:void(0)" data-action="detail_bill" data-id="'.$row->id.'">Détail</a>'
                .'<a class="dropdown-item" href="JavaScript:void(0)" data-action="valid_proforma" data-id="'.$row->id.'">Valider</a>'
                .'<a class="dropdown-item" href="JavaScript:void(0)" data-action="canceled_bill" data-id="'.$row->id.'">Annuler</a>'
                .'<a class="dropdown-item" href="JavaScript:void(0)" data-action="delete_bill" data-id="'.$row->id.'">Supprimer</a>'
                .'</div>'
                .' </div>'
                .'</li>'
                .'</ul>';

        });

        return response()->json($result);

    }

    public function dtCanceled(Request $request): JsonResponse
    {

        $query = "select b.*,c.last_name as `customer`,u.name from crm_bills b"
            ." left join crm_customers c on c.id= b.customer_id and c.deleted = 0"
            ." left join crm_users u on u.id= b.user_id"
            ." where b.state = -1 and b.deleted =0";

        $result = $this->DoDatatable($query,$request, function($i, $row){

            $row->actions = '<ul class="list-inline user-chat-nav text-center mb-0">'
                .'<li class="list-inline-item">'
                .'<div class="dropdown">'
                .'<button class="btn nav-btn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                .'<i class="bx bx-dots-horizontal-rounded"></i>'
                .'</button>'
                .'<div class="dropdown-menu dropdown-menu-end">'
                .'<a class="dropdown-item" href="JavaScript:void(0)" data-action="detail_bill" data-id="'.$row->id.'">Détail</a>'
                .'<a class="dropdown-item" href="JavaScript:void(0)" data-action="delete_bill" data-id="'.$row->id.'">Supprimer</a>'
                .'</div>'
                .' </div>'
                .'</li>'
                .'</ul>';

        });

        return response()->json($result);

    }

    public function dtBill(Request $request): JsonResponse
    {

        $query = "select b.*,c.last_name as `customer`,u.name from crm_bills b"
            ." left join crm_customers c on c.id= b.customer_id and c.deleted = 0"
            ." left join crm_users u on u.id= b.user_id"
            ." where b.state = 1 and b.deleted =0";

        $result = $this->DoDatatable($query,$request, function($i, $row){

            $row->actions = '<ul class="list-inline user-chat-nav text-center mb-0">'
                .'<li class="list-inline-item">'
                .'<div class="dropdown">'
                .'<button class="btn nav-btn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                .'<i class="bx bx-dots-horizontal-rounded"></i>'
                .'</button>'
                .'<div class="dropdown-menu dropdown-menu-end">'
                .'<a class="dropdown-item" href="/bill/new-bill/'.$row->id.'">Modifier</a>'
                .'<a class="dropdown-item" href="JavaScript:void(0)" data-action="detail_bill" data-id="'.$row->id.'">Détail</a>'
                .'<a class="dropdown-item" href="JavaScript:void(0)" data-action="canceled_bill" data-id="'.$row->id.'">Annuler</a>'
                .'<a class="dropdown-item" href="JavaScript:void(0)" data-action="delete_bill" data-id="'.$row->id.'">Supprimer</a>'
                .'</div>'
                .' </div>'
                .'</li>'
                .'</ul>';

        });

        return response()->json($result);

    }

    public function newBill($id=null)
    {
        $bill = null;
        $customer = null;
        $data_details = null;
        $event_title = null;

        if($id){

            $bill = $this->bill->showBill($id);

            if($bill){

                $event_check = Event::checkEventBill('bill',$id);
                $event_title = $event_check ? $event_check->title : '';
                $customer = Customer::showCustomer($bill->customer_id);
                $services = Bill_detail::listBillDetails($id);

                foreach ($services as $service){

                    $get_service = Service::showService($service->service_id);

                    $data_details[] = [
                      'service' => [
                          'id' => $service->service_id,
                          'name' => $get_service->name
                      ],
                      'price' => (float)$service->price,
                      'qty' =>  $service->quantity,
                      'total' => (float)$service->total,
                      'with_tva' => $service->with_tva,
                      'description' => $service->description
                    ];

                }
            }

        }

        $data = [
            'page'=>'Nouvelle proforma',
            'bill' => $bill,
            'event_title' => $event_title,
            'customer' => $customer,
            'data_details' => $data_details
        ];

        back_view('bill.new_bill',$data);

    }

    public function newBillService(Request $request)
    {
        $data = [
            'page'=>'Nouvelle proforma'
        ];

        back_view('bill.new_bill_service',$data,true);

    }

    public static function proformaToBill($bill_id)
    {
        $result = (object)['status'=>false,'bill_id'=>null];

        $get_bill =bill::showBill($bill_id);
        $last_bill = bill::lastBill();
        $reference = $last_bill ? $last_bill->id+1 : 1;

        $data_bill = [
            'customer_id' => $get_bill->customer_id,
            'date' => date('Y-m-d H:i:s'),
            'payment_method' => $get_bill->payment_method,
            'total_ht' => $get_bill->total_ht,
            'total_ttc' => $get_bill->total_ttc,
            'reference' => '#'.$reference,
            'number' => str_pad($reference, 7, "0", STR_PAD_LEFT),
            'description' => $get_bill->description,
            'state' => 1,
            'proforma_id' => $bill_id,
            'user_id' => currentUser()->user->id
        ];

        $save = bill::storeBill($data_bill);

        if ($save) {

            $services = Bill_detail::listBillDetails($bill_id);

            $bill_detail_model = new Bill_detail();

            foreach ($services as $service){

                $detail = [
                    'bill_id' => $save->id,
                    'service_id' => $service->service_id,
                    'price' => $service->price,
                    'quantity' => $service->quantity,
                    'description' => $service->description,
                    'total' => $service->total,
                    'user_id' => currentUser()->user->id
                ];

                $bill_detail_model->storeBillDetail($detail);

            }

            $result->status = true;
            $result->bill_id = $save->id;

        }

        return $result;

    }

    public function detailBill($bill_id)
    {
        $bill = bill::showBill($bill_id);
        $customer = null;
        $city = null;
        $details = null;
        $other_details = null;
        $date_event = null;

        if($bill){

            setlocale(LC_TIME, 'fr_FR.utf8','fra');
            $event = Event::checkEventBill('bill',$bill_id);
            $date_event = $event ? strftime("le %d %B %Y", strtotime( $event->date_start )) : '';
            $customer = Customer::showCustomer($bill->customer_id);
            $details = Bill_detail::listBillDetails($bill_id,1);
            $other_details = Bill_detail::listBillDetails($bill_id,0);
            $city = $customer ? City::showCity($customer->city_id) : null;

            foreach ($details as $detail){

                $service = Service::showService($detail->service_id);
                $detail->service = $service ? $service->name : '';

            }

            foreach ($other_details as $other_detail){

                $service = Service::showService($other_detail->service_id);
                $other_detail->service = $service ? $service->name : '';

            }

        }

        $data=[
            'bill' => $bill,
            'date_event' => $date_event,
            'customer' => $customer,
            'details' => $details,
            'other_details' => $other_details,
            'city' => $city,
        ];

        back_view('bill.detail_bill',$data,true);
    }

    public function billExportPdf($bill_id) {

        $bill = bill::showBill($bill_id);
        $customer = null;
        $city = null;
        $details = null;
        $other_details = null;
        $date_event = null;

        if($bill){

            setlocale(LC_TIME, 'fr_FR.utf8','fra');
            $event = Event::checkEventBill('bill',$bill_id);
            $date_event = $event ? strftime("le %d %B %Y", strtotime( $event->date_start )) : '';
            $customer = Customer::showCustomer($bill->customer_id);
            $details = Bill_detail::listBillDetails($bill_id,1);
            $other_details = Bill_detail::listBillDetails($bill_id,0);
            $city = $customer ? City::showCity($customer->city_id) : null;

            foreach ($details as $detail){

                $service = Service::showService($detail->service_id);
                $detail->service = $service ? $service->name : '';

            }

            foreach ($other_details as $othder_detail){

                $service = Service::showService($othder_detail->service_id);
                $othder_detail->service = $service ? $service->name : '';

            }

        }

        $data=[
            'bill' => $bill,
            'date_event' => $date_event,
            'customer' => $customer,
            'details' => $details,
            'other_details' => $other_details,
            'city' => $city,
        ];

        //back_view('bill.bill_pdf',$data,true);

        $pdf = PDF::loadView('bill.bill_pdf',$data);

        return $pdf->download(strtoupper(stateBill($bill->state)).'-'.$bill->number.'.pdf');
    }
}
