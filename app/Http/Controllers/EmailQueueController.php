<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailQueue;


class EmailQueueController extends Controller
{
    public function index(Request $request, EmailQueue $emailQueue)
    {

        if ($request->ajax()) {

            $emailQueues = $emailQueue->getAllEmailQueues($request);

            $totalemailQueues = EmailQueue::count();

             $search = $request['search']['value'];

             $setFilteredRecords = $totalemailQueues;

            if(!empty($search)){

            $setFilteredRecords = $emailQueue->getAllEmailQueues($request,true);

           }

            return datatables()->of($emailQueues)
                ->addIndexColumn()
                ->addColumn('status', function ($emailQueue) {
                      return  '<span class="badge badge-'.$emailQueue->getStatusBadge().'">'.$emailQueue->getStatus().'</span>';
                })
              
                ->addColumn('created_at', function ($emailQueue) {
                    return $emailQueue->created_at;
                })

                ->addColumn('action', function ($emailQueue) {
                $btn = '';
                $btn = '<a href="' . route('email-queue.show',encrypt($emailQueue->id)) . '" title="View"><i class="fas fa-eye mr-1"></i></a>';

                // $btn .= '<a href="javascript:void(0);" delete_form="delete_customer_form"  data-id="' .$emailQueue->id. '" class="delete-datatable-record text-danger delete-email-queues-record" title="Delete"><i class="fas fa-trash ml-1"></i></a>';

                return $btn;
            })
                ->rawColumns([
                'action',
                'status'
            ])->setTotalRecords($totalemailQueues)->setFilteredRecords($setFilteredRecords)->skipPaging()
                ->make(true);
        }

        return view('email-queue.index');
    }

    public function show($id)
    {
        $model = EmailQueue::find(decrypt($id));
        return view('email-queue.view',compact("model"));
    }
}
