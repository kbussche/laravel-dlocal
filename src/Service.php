<?php namespace Dwerp\Laravel-Dlocal;

use GuzzleHttp\Client;
use Carbon\Carbon;

class Service {

    const NEWINVOICE_URL = 'https://astropaycard.com/api_curl/streamline/newinvoice/';
    const STATUS_URL = 'https://astropaycard.com/apd/webpaystatus';
    const EXCHANGE_URL = 'https://astropaycard.com/apd/webcurrencyexchange';
    const BANKS_URL = 'https://astropaycard.com/api_curl/apd/get_banks_by_country';

	private $x_login = '***';
	private $x_trans_key = '***';

	private $x_login_for_webpaystatus = '***';
	private $x_trans_key_for_webpaystatus = '***';

	private $secret_key = '***';
    private $sandbox = true;
    private $client;

	private $url = [
		'newinvoice' => '',
		'status' => '',
		'exchange' => '',
		'banks' => ''
	];

	private $errors = 0;

	public function __construct(){
		$this->errors = 0;
        $this->client = new Client(
            ['headers' =>
                ['Content-Type' => 'application/json']
            ]
        );
        // switch all of this to config
		$this->url['newinvoice'] = 'https://astropaycard.com/api_curl/streamline/newinvoice/';
		$this->url['status'] = 'https://astropaycard.com/apd/webpaystatus';
		$this->url['exchange'] = 'https://astropaycard.com/apd/webcurrencyexchange';
		$this->url['banks'] = 'https://astropaycard.com/api_curl/apd/get_banks_by_country';

		if ($this->sandbox){
			$this->url['newinvoice'] = 'https://sandbox.astropaycard.com/api_curl/streamline/newinvoice';
			$this->url['status'] = 'https://sandbox.astropaycard.com/apd/webpaystatus';
			$this->url['exchange'] = 'https://sandbox.astropaycard.com/apd/webcurrencyexchange';
			$this->url['banks'] = 'https://sandbox.astropaycard.com/api_curl/apd/get_banks_by_country';
		}
	}

	public function newinvoice(StreamLineInvoice $invoice)
    {
		$params_array = $invoice->toArray();

		$params_array['control'] = $this->makeControl($invoice->getMessage());

		$response = $this->client->request('POST', $this->url['newinvoice'], $params_array);
		return $response;
	}



	public function get_status($invoice){
		$params_array = array(
			'x_login' => $this->x_login_for_webpaystatus,
			'x_trans_key' => $this->x_trans_key_for_webpaystatus,
			'x_invoice' => $invoice->getInvoice()
		);

		$response = $this->curl->request('GET', $this->url['status'], $params_array);
		return $response;
	}

	public function get_exchange($country = 'BR', $amount = 1){
		$params_array = array(
			'x_login' => $this->x_login_for_webpaystatus,
			'x_trans_key' => $this->x_trans_key_for_webpaystatus,
			'x_country' => $country,
			'x_amount' => $amount
		);

		$response = $this->curl($this->url['exchange'], $params_array);
		return $response;
	}

	public function get_banks_by_country($country = 'BR', $type = 'json'){
		$params_array = array(
			'x_login' => $this->x_login,
			'x_trans_key' => $this->x_trans_key,
			'country_code' => $country,
			'type' => $type
		);

		$response = $this->client->request('POST', $this->url['banks'], $params_array);
		return $response;
	}


    private function makeControl($message)
    {
        return strtoupper(hash_hmac('sha256', pack('A*', $message), pack('A*', $this->secret_key)));
    }

}
