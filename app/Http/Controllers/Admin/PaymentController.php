<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function index() {
        return view('admin.payments.index');
    }

    public function fetchPaymentsWithAjax(Request $request)
    {
//        Define all column names
        $columns = [
            'id', 'reference', 'id', 'type', 'amount', 'created_at', 'status', 'action'
        ];
//        Find data
        $payments = Payment::query();
//        Set helper variables from request and DB
        $totalData = $totalFiltered = $payments->count();
        $limit = $request['length'];
        $start = $request['start'];
        $order = $columns[$request['order.0.column']];
        $dir = $request['order.0.dir'];
        $search = $request['search.value'];
//        Check if request wants to search or not and fetch data
        if(empty($search))
        {
            $payments = $payments->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $payments = $payments->where('reference','LIKE',"%{$search}%")
                ->orWhereHas('user',function ($q) use ($search) { $q->where('name', 'LIKE',"%{$search}%"); })
                ->orWhereHas('user',function ($q) use ($search) { $q->where('email', 'LIKE',"%{$search}%"); })
                ->orWhere('type', 'LIKE',"%{$search}%")
                ->orWhere('created_at', 'LIKE',"%{$search}%")
                ->orWhere('status', 'LIKE',"%{$search}%")
                ->orWhere('amount', 'LIKE',"%{$search}%");
            $totalFiltered = $payments->count();
            $payments = $payments->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
//        Loop through all data and mutate data
        $data = [];
        $i = $start + 1;
        foreach ($payments as $payment)
        {
            $status = $action = $disabled = null;
            if($payment['status'] == 'success'){
                $status = '<span class="badge badge-pill badge-success">Success</span>';
                $disabled = 'disabled';
            }elseif ($payment['status'] == 'pending'){
                $status = '<span class="badge badge-pill badge-warning">Pending</span>';
                if (auth()->user()->can('Resolve Payments')) {
                    $action .= '<a class="dropdown-item d-flex align-items-center" onclick="event.preventDefault(); confirmFormSubmit(\'resolvePayment' . $payment['id'] . '\')" href="' . route('admin.payments.resolve', $payment['id']) . '"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-check mr-2"></i> <span class="">Resolve</span></a>
                           <form id="resolvePayment' . $payment['id'] . '" action="' . route('admin.payments.resolve', $payment['id']) . '" method="POST">
                               <input type="hidden" name="_token" value="' . csrf_token() . '">
                               <input type="hidden" name="_method" value="POST">
                           </form>';
                }
                if (!auth()->user()->can('Resolve Payments')){
                    $disabled = 'disabled';
                }
            }elseif ($payment['status'] == 'failed'){
                $status = '<span class="badge badge-pill badge-danger">Failed</span>';
                $disabled = 'disabled';
            }
            $datum['sn'] = $i;
            if ($payment->user && auth()->user()->can('View Users')){
                $datum['email'] = '<a href="'.route('admin.users.show', $payment->user['id']).'">'.$payment->user['email'].'</a>';
            }else{
                $datum['email'] = $payment->user['email'] ?? '---';
            }
            $datum['reference'] = $payment['reference'];
            $datum['type'] = $payment['type'];
            $datum['amount'] = '₦ '.number_format($payment['amount']);
            $datum['date'] = $payment['created_at']->format('M d, Y H:i');
            $datum['status'] = $status;
            $datum['action'] = '<div class="dropdown">
                                        <button class="btn btn-sm btn-primary" '.$disabled.' type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action <i class="icon-lg fa fa-angle-down"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                            '.$action.'
                                        </div>
                                    </div>';
            $data[] = $datum;
            $i++;
        }
//      Ready results for datatable
        $res = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        echo json_encode($res);
    }

    public function resolve(Payment $payment): \Illuminate\Http\RedirectResponse
    {
        $paymentDetails = Http::withHeaders([
            'Authorization' => 'Bearer '.env('PAYSTACK_SECRET_KEY')
        ])->get('https://api.paystack.co/transaction/verify/'.$payment['reference']);
        if ($payment['status'] == 'pending' && isset($paymentDetails['status'])) {
            $res = $paymentDetails['data'] ?? null;
            if (isset($res) && $res["status"] == 'success') {
                \App\Http\Controllers\PaymentController::processTransaction($payment, $res['metadata']);
            }
        }
        if ($payment['status'] != "success") {
            $payment->update(['status' => 'failed']);
        }
        return back()->with('success', 'Payment resolved successfully');
    }
}
