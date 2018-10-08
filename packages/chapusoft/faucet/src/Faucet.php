<?php namespace Chapusoft\Faucet;

use Chapusoft\Faucet\FaucetBOX;
use Cache;

class Faucet
{

    protected $service;
    protected $config = array();

    public function __construct($config)
    {
        $this->config = $config;
        $apikey       = $config['faucets']['faucetbox']['api_key'];
        $this->faucetbox = new FaucetBOX($apikey);
    }

    public function getMaxDaily()
    {
        return $this->convertToShatoshi($this->config['max_transfer_daily']);
    }

    public function getReferralCommision($shatoshis)
    {
        return round($shatoshis / (100/$this->config['referral_comission']));
    }

    public function sendReferralEarnings($address, $shatoshis)
    {
        return $this->faucetbox->sendReferralEarnings($address, $shatoshis);
    }

    public function send($address, $shatoshis)
    {
        return $this->faucetbox->send($address, $shatoshis);
    }

    public function getBalance()
    {
        return $this->faucetbox->getBalance();
    }

    public function getMinBalance()
    {
        return round($this->convertToShatoshi($this->config['max_transfer_payment']));
    }

    public function getMaxTransfer()
    {
        return round($this->convertToShatoshi($this->config['max_transfer_payment']));
    }

    public function getDirectPayment()
    {
        return round($this->convertToShatoshi($this->config['direct_payment']));
    }

    protected function convertToShatoshi($amount)
    {
        if ($this->config['currency_control']!='BTC') {
            $amount = $this->convertToBTC($amount, $this->config['currency_control']);
        }
        return $amount * 100000000;
    }

    protected function convertToBTC($amount, $currencyType)
    {
        $exchangeType = $this->getCurrencyExchange($currencyType);
        $change = $amount / $exchangeType;
        return $change;
    }

    protected function getCurrencyExchange($currencyType)
    {
        $currencyType = strtoupper(trim($currencyType));

        if (null === $changeRates = Cache::get('faucet_exchange_rates')) {
            $changeRates  = json_decode(file_get_contents("https://bitpay.com/api/rates"));
            Cache::put('faucet_exchange_rates', $changeRates, 1440);
        }

        $size = sizeOf($changeRates);
        for ($i=0; $i<$size; $i++) {
            if ($changeRates[$i]->code == $currencyType) {
                return $changeRates[$i]->rate;
            }
        }
        return false;
    }
}
