<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Transfer;
use DB;
use Datatables;
use Carbon\Carbon;
use XWhois;

class SecurityController extends Controller {

    public function bannedList()
    {
        return view('admin/banned/list');
    }

    public function ajaxBannedList(Request $request)
    {
        $query     = DB::table('banned');
        $datatable = Datatables::of($query)
            ->editColumn('created_at', function($field){
                if($field->created_at){
                    if($field->created_at!=='0000-00-00 00:00:00'){
                        return with(new Carbon($field->created_at))->format('Y-m-d H:i');
                    }
                }
                return '<i>(None found)</i>';
            })
            ->editColumn('freedom_date', function($field){
                return $field->freedom_date ? with(new Carbon($field->freedom_date))->format('Y-m-d') : '';
            })
            ->addColumn('actions', function ($row) {
                return "<a href='/admin/bans/del/$row->id' class='btn btn-primary'>Delete</a>";
            });

        return $datatable->make(true);
    }

    public function banNetByName(Request $request)
    {
        $this->validate($request, [
                'host' => 'max:120',
        ]);
        $host    = $request->host;
        $lookup  = XWhois::lookup($host);
        $network = $lookup["regrinfo"]["network"]["name"];

        $now = Carbon::now();
        $freedomDate = Carbon::now()->modify('+1 year');

        DB::table("banned")->insert([
                'network' => $network,
                'created_at' => $now,
                'updated_at' => $now,
                'freedom_date' => $freedomDate]
        );
        return redirect()->back();
    }

    public function banIP(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                    'host' => 'max:120',
            ]);
            $host = $request->host;
            $now   = Carbon::now();
            $freedomDate = Carbon::now()->modify('+1 year');
            DB::table("banned")->insert([
                    'ip' => $host,
                    'created_at' => $now,
                    'updated_at' => $now,
                    'freedom_date' => $freedomDate]
            );
            return redirect('admin/bans');
        }
        return view('admin/banned/new');
    }

    public function delBan(Request $request, $blockId)
    {
        DB::table("banned")->where('id',$blockId)->delete();
        return redirect('admin/bans');
    }

    public function bannedRangesList()
    {
        return view('admin/banned/ranges_list');
    }

    public function ajaxBannedRangesList(Request $request)
    {
        $query     = DB::table('banned_ranges');
        $datatable = Datatables::of($query)
            ->editColumn('created_at', function($field){
                if($field->created_at){
                    if($field->created_at!=='0000-00-00 00:00:00'){
                        return with(new Carbon($field->created_at))->format('Y-m-d H:i');
                    }
                }
                return '<i>(None found)</i>';
            })
            ->editColumn('freedom_date', function($field){
                return $field->freedom_date ? with(new Carbon($field->freedom_date))->format('Y-m-d') : '';
            })
            ->editColumn('start', function($field){
                return long2ip($field->start);
            })
            ->editColumn('end', function($field){
                return long2ip($field->end);
            })
            ->addColumn('actions', function ($row) {
                return "<a href='/admin/banned-ranges/del/$row->id' class='btn btn-primary'>Delete</a>";
            });
        return $datatable->make(true);
    }

    public function delBannedRange(Request $request, $bannedRangeId)
    {
        DB::table("banned_ranges")->where('id', $bannedRangeId)->delete();
        return redirect('admin/banned-ranges/');
    }

    public function searchAsns(Request $request){
        return view('admin/search-asns');
    }

    public function ajaxSearchAsns(Request $request){

        $query = DB::query()->selectRaw("count(*) as total,
                            SUBSTRING_INDEX( SUBSTRING_INDEX( ip, '.', 1 ) , '.' , -1 ) as a,
                            SUBSTRING_INDEX( SUBSTRING_INDEX( ip, '.', 2 ) , '.' , -1 ) as b
                                FROM transfers
                            GROUP BY a,b");
        $datatable = Datatables::of($query)
            ->addColumn('actions', function ($row) {
                $form = "<form action='/admin/whois/' method='POST' style='text-align:center'>";
                $form .= csrf_field();
                $form .= "<input type='hidden' name='host' value='".$row->a.".".$row->b.".0.0' />
                            <input type='submit' class='btn btn-primary' value='Whois' />
                        </form>";
                return $form;
            });
        return $datatable->make(true);
    }

    public function exportToIpTables(){
        header('Content-type: text/plain');
        $bannedAsns = DB::table("banned_ranges")->get();
        foreach($bannedAsns as $banned){
            echo "iptables -A INPUT -s ".$banned->cidr." -j DROP\n";
        }
        die;
    }

    public function whois(Request $request)
    {
        $winfo = "";
        $host  = "";
        if($request->isMethod('post'))
        {
            $this->validate($request, [
                    'host' => 'max:120',
            ]);
            $host = $request->host;
            $result = XWhois::lookup($host);
            $utils = new \Utils;
            $winfo = $utils->showHTML($result);
        }
        return view('admin/whois', ['winfo' => $winfo,
                                    'host'  => $host ]);
    }

}
