<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\FaucetBOX;
use App\Transfer;
use App\Messages;
use DB;
use Datatables;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        return view('admin/dashboard');
    }

    public function address($address)
    {
        $data = Transfer::select(
            DB::raw('address,
    			MIN(created_at) as first_entry,
    			MAX(created_at) as last_entry,
    			SUM(amount) as total,
    			MAX(amount) as max,
    			MIN(amount) as min,
    			COUNT(*) as transfers
			')
        )
        ->where('address', $address)
        ->groupBy('address')
        ->get();

        return view(
            'admin/address/item',
            ['address' => $data[0]]
        );
    }

    public function addressList()
    {
        return view('admin/address/list');
    }

    public function ajaxAddressList(Request $request)
    {
        $query = Transfer::select(
            DB::raw('address,
							MIN(created_at) as first_entry,
							MAX(created_at) as last_entry,
							SUM(amount) as total,
							MAX(amount) as max_day,
							COUNT(*) as transfers
							')
        )
                        ->groupBy('address')
                        ->get();

        $datatable = Datatables::of($query)
                    ->editColumn('address', function ($item) {
                            return "<a href='/admin/address/$item->address'>$item->address</a>";
                    });
        return $datatable->make(true);
    }

    public function transactions()
    {
        return view('admin/transactions');
    }

    public function ajaxTransactions(Request $request)
    {
        $query = Transfer::select('*');
        if (!empty($request->input('address'))) {
            $query = $query->where('address', $request->input('address'));
        }

        if (!empty($request->input('orderby'))) {
            $query = $query->orderby('created_at', 'desc');
        }

        $datatable = Datatables::of($query)
                            ->editColumn('address', function ($transfer) {
                                    return "<a href='/admin/address/$transfer->address'>$transfer->address</a>";
                            })
                            ->addColumn('actions', function ($transfer) {
                                    return "<a href='https://faucetbox.com/en/check/$transfer->address'>Faucetbox</a>";
                            });

        if (!empty($request->input('limit'))) {
            $datatable->paging();
        }

        return $datatable->make(true);
    }

    public function extraAwardsList()
    {
        return view('admin/extra_awards');
    }

    public function ajaxExtraAwardsList(Request $request)
    {
        $query = DB::table('extra_awards');
        $datatable = Datatables::of($query)
                            ->editColumn('created_at', function($field){
                                if($field->created_at){
                                    if($field->created_at!=='0000-00-00 00:00:00'){
                                        return with(new Carbon($field->created_at))->format('Y-m-d H:i');
                                    }
                                }
                                return '<i>(None found)</i>';
                            });

        return $datatable->make(true);
    }

    public function messageList()
    {
        Messages::where('readed', false)
          ->update(['readed' => true]);

        return view('admin/messages/list');
    }

    public function ajaxMessageList(Request $request)
    {
        $query = Messages::select('*');
        $datatable = Datatables::of($query);

        return $datatable->make(true);
    }

}
