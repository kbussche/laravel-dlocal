<?php namespace Dwerp\Dlocal-Laravel;

class Invoice
{
    public $params = [
    	'x_login' => null,
    	'x_trans_key' => null,
    	'x_invoice' => null,
    	'x_amount' => null,
    	'x_bank' => null,
    	'type'=>'json',
    	'x_country' => null,
    	'x_iduser' => null,
    	'x_cpf' => null,
    	'x_name' => null,
    	'x_email' => null,
        'x_currency' => '', // optionals
        'x_description' => '',
        'x_bdate' => '',
        'x_address' => '',
        'x_zip' => '',
        'x_city' => '',
        'x_state' => '',
        'x_return' => '',
        'x_confirmation' => '',
    ];

    public function __construct($login, $trans_key)
    {
        $this->params['x_login'] = $login;
        $this->params['x_trans_key'] = $trans_key;
        $this->params['type'] = 'json';
    }

    public function toArray()
    {
        return $this->params;
    }

    public function getMessage()
    {
        return $this->params['x_invoice'] .'V' .
                $this->params['x_amount'] .'I' .
                $this->params['x_iduser'] .'2' .
                $this->params['x_bank'] .'1' .
                $this->params['x_cpf'] .'H' .
                $this->params['x_bdate'] .'G' .
                $this->params['x_email'] .'Y' .
                $this->params['x_zip'] .'A' .
                $this->params['x_address'] .'P' .
                $this->params['x_city'] .'S' .
                $this->params['x_state'] . 'P';
    }
    
    public function setInvoice($invoice)
    {
        $this->params['x_invoice'] = $invoice;
        return $this;
    }

    public function setAmount($amount)
    {
        $this->params['x_amount'] = $amount;
        return $this;
    }

    public function setBank($bank)
    {
        $this->params['x_bank'] = $bank;
        return $this;
    }

    public function setCountry($country)
    {
        $this->params[''] = $country;
        return $this;
    }


    public function setUser($user)
    {
        $this->params['x_iduser'] = $user;
        return $this;
    }

    public function setCpf($cpf)
    {
        $this->params['x_cpf'] = $cpf;
        return $this;
    }

    public function setName($name)
    {
        $this->params['x_name'] = $name;
        return $this;
    }

    public function setName($email)
    {
        $this->params['x_email'] = $email;
        return $this;
    }
}
