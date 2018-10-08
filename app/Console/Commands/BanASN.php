<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;

class BanASN extends Command
{
    protected $signature = 'ban:asn';
    protected $description = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $total = 0;
        $asnId = $this->getAsn();
        $asnInfo = $this->getAsnInfo($asnId);
        $this->comment("ASN Encontrado:".$asnInfo['name']);
        $cidrs = $this->getCidrsFor($asnId);
        foreach($cidrs as $index => $cidr){
            $this->line("Baneando CIDR:".$cidr);
            $data = explode("/",$cidr);
            $initLongIp = ip2long($data[0]);
            $range = pow(2, (32-$data[1]));
            $total += $range;
            $endLongIp = $initLongIp + $range;
            $this->comment("Baneando $range ips: From $initLongIp to $endLongIp");
            DB::table('banned_ranges')->insert([
                'asn_name' => $asnInfo['name'],
                'asn_id' => $asnInfo['id'],
                'cidr' => $cidr,
                'start' => $initLongIp,
                'end' => $endLongIp,
                'freedom_date' => Carbon::now()->addYear(1),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        $this->info("$total ips baneadas");
    }

    public function getAsn(){
        $asnId = (int) $this->ask('Introduce el ID del ASN:');
        if(!is_integer($asnId)){
            $this->line("No has introducido un número correcto.");
            return $this->getAsn();
        }
        $asnIdConfirm = (int) $this->ask('Confirma ID del ASN:');
        if(!is_integer($asnIdConfirm)){
            $this->line("No has introducido un número correcto.");
            return $this->getAsn();
        }
        if($asnId!=$asnIdConfirm){
            $this->line("Confirmación incorrecta");
            return $this->getAsn();
        }
        return $asnId;
    }

    public function getCidrsFor($asnId)
    {
        $path = base_path('resources/asn_data/routes.csv');
        $cidrLines = explode("\n", shell_exec("cat $path | grep -e '\s$asnId$' "));
        if(!empty($cidrLines)){
            foreach($cidrLines as $index => $value){
                if(!empty($value)){
                    $cidr = explode(" ", $value);
                    $cidrs[] = $cidr[0];
                }
            }
        }
        return $cidrs;
    }

    public function getAsnInfo($asnId)
    {
        $path = base_path('resources/asn_data/asn-ctl.csv');
        $asn  = explode("\t", shell_exec("cat $path | grep -e '^$asnId\s' "));
        if(!empty($asn[0])){
            return [
                'id' => $asn[0],
                'rir' => $asn[1],
                'name' => $asn[2]
            ];
        }else{
            $this->error("El ASN indicado no existe.");
            exit;
        }
    }

}
