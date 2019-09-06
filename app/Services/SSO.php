<?php


namespace App\Services;


use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SSO
{
    protected $account;

    protected $user;

    public function __construct()
    {
        if (array_key_exists('REMOTE_USER', $_SERVER) && $_SERVER['REMOTE_USER'] != '') {
            $registeredName = explode('\\', $_SERVER['REMOTE_USER']);
            $this->account = $registeredName[1];
        } else {
            if (App::isLocal()) {
                //$this->account = null;
                $this->account = 'ccarver';

//                $this->account = 'qdansie';
//                $this->account = 'dopp';
//                $this->account = 'tpowers';
//                $this->account = 'jcarlin';
//                $this->account = 'jmcnamar';
//                $this->account = 'dkorff';
//                $this->account = 'scamino';

//                $this->account = 'vdronamr'; //Deepthi

//                $this->account = 'scody';
//                $this->account = 'jmcnamar';
//                $this->account = 'fc8facmobile';
                //$this->account = 'smead';
                //$this->account = 'sgariepy';
                //$this->account = 'tburke';
                //$this->account = 'jlansfor';
                //$this->account = 'jsmalls';
                //$this->account = 'ocarbaja';
                //$this->account = 'jfeerer';
                //$this->account = 'jwilder';
                //$this->account = 'csulliva';

//                $this->account = 'kmckeon';
//                $this->account = 'jvanpatt';
//                $this->account = 'kprettym';
                //$this->account = 'dtomasky';
//                $this->account = 'e1000285'; // Linda
                //$this->account = 'tkulasin';
                //$this->account = 'mhills';
//                $this->account = 'jrawlins';
//                $this->account = 'jaboagye';
//                $this->account = 'ajesaiti';

                //IE People
//                $this->account = 'jeissere';

                //Sub Program
//                $this->account = 'e16175';

                //Layout
//                $this->account = 'lshams';

                //Finance
//                $this->account = 'mholenst';

                //Scheduling
//                $this->account = 'cjones3';

                //Admin or EPIC
//                $this->account = 'sgariepy';
//                $this->account = 'smead';
//                $this->account = 'jeissere';
            }
        }
    }

    public function login()
    {
        if (!$this->account)
            return false;

        if (!Auth::check()) {
            $this->user = $this->findUser();
        }

        return $this->user ? $this->processLogin() : $this->createUser();
    }

    public function processLogin()
    {
        $this->user->last_seen = Carbon::now();
        $this->user->save();

        Auth::login($this->user, true);

        return true;
    }

    protected function findUser()
    {
        return User::where('account', $this->account)->first();
    }

    public function createUser()
    {
        $user = (new GlobalUser())->findByAccount($this->account);

        if ($user) {
            $this->user = User::create($user->toArray());

            return $this->processLogin();
        }

        return false;
    }

}
