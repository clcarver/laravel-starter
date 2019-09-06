<?php


namespace App\Services;

use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class GlobalUser
{
    protected $user;

    protected $externalIds;
    protected $relations;
    protected $org;

    protected function find($searchString): Collection
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://gfpeoplesearch.appspot.com/api/users/' . $searchString,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; MSIE 9.0; WIndows NT 9.0; en-US))',
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPPROXYTUNNEL => true,
            CURLOPT_PROXY => App::isLocal() ? 'uswwwp1.gfoundries.com' : 'uswwwp1.gfoundries.com',
            CURLOPT_PROXYPORT => App::isLocal() ? '74' : null,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
                'app-identifier-name:' . env('GF_NAME'),
                'app-identifier-key:' . env('GF_ID'),
                'Access-Control-Allow-Origin:' . env("GF_HEADER")
            ]
        ]);

        $directoryUser = curl_exec($curl);

        if (curl_error($curl)) {
            throw new Exception(curl_error($curl));
        }

        curl_close($curl);

//        if (!$directoryUser)
//            dd($searchString);

        return collect(json_decode($directoryUser, true))->transform(function ($item) {
            return collect($item['externalIds'])->contains('type', 'account') ? $item : null;
        })->filter();
    }

    public function search($search)
    {
        if($search != '')
        return $this->find($search)->transform(function($user) {
            return $this->formatUser($user);
        })->sortBy('last_name')->values()->take(20);

        return [];
    }

    public function findByAccount(string $account)
    {
        return $this->formatUser($this->find("externalId:" . $account)->first());
    }

    public function findOrCreateByAccount(string $account)
    {
        $user = User::where('account', $account)->first();

        if (is_null($user)) {
            $user = $this->find("externalId:" . $account)->first();

            if ($user) {
                $formattedUser = $this->formatUser($user);
            } else {
                $formattedUser = $this->createShellUser($account);
            }

            $user = $this->createUser($formattedUser);
        }

        return $user;
    }

    public function findByBadge(string $badge)
    {
        $user = User::where('employee_id', $badge)->first();

        return $user ? $user : $this->formatUser($this->find("externalId:" . $badge)->first());
    }

    public function findByEmail(string $email) : User
    {
        $user = User::where('email', $email)->first();

        return $user ? $user : $this->createUser($this->formatUser($this->find("email:" . $email)->first()));
    }

    public function findByDepartment(string $department)
    {
        return $this->find("orgDepartment:'" . rawurlencode($department) . "'")->transform(function ($user) {
            return $this->formatUser($user);
        });
    }

    public function getManager($user)
    {
        if (!key_exists('relations', $user))
            return NULL;
        return collect($user['relations'])->where('type', 'manager')->pluck('value')->first();
    }

    public function getAccount($user)
    {
        return collect($user['externalIds'])->where('type', 'account')->pluck('value')->first();
    }

    public function getBadgeId($user)
    {
        return collect($user['externalIds'])->where('type', 'organization')->pluck('value')->first();
    }

    public function getAvatar($user)
    {
        return isset($user['thumbnailPhotoUrl']) ? $user['thumbnailPhotoUrl'] : '/default.png';
    }

    public function getTitle($user)
    {
        return collect($user['organizations'])->pluck('title')->first();
    }

    public function getDepartment($user)
    {
        return collect($user['organizations'])->pluck('department')->first();
    }

    public function getCostCenter($user)
    {
        return collect($user['externalIds'])->where('customType', 'costcenter')->pluck('value')->first();
    }

    public function createUser(Collection $user)
    {
        return $user->isEmpty() ? false : User::create($user->toArray());
    }

    protected function formatUser($user)
    {
        if (!$user) {
            return $this->createShellUser($user);
        }

        return collect([
            'first_name' => $user['name']['givenName'],
            'last_name' => preg_replace("/\([^)]+\)/", "", $user['name']['familyName']),
            'email' => strtolower($user['primaryEmail']),
            'account' => $this->getAccount($user),
            'employee_id' => $this->getBadgeId($user),
            'avatar' => $this->getAvatar($user),
            'manager_email' => strtolower($this->getManager($user)),
            'title' => $this->getTitle($user),
            'department' => $this->getDepartment($user),
            'is_synced' => 1,
            'sync_date' => Carbon::now()->format('Y-m-d'),
            'cost_center' => $this->getCostCenter($user)
        ]);
    }

    protected function createShellUser($account)
    {
        return collect([
            'first_name' => $account,
            'last_name' => $account,
            'email' => $account . '@doesNotWorkHere.com',
            'account' => $account,
            'employee_id' => rand(200000, 900000),
            'avatar' => $this->getAvatar($account),
            'manager_email' => null,
            'title' => null,
            'department' => null,
            'is_synced' => 2,
            'sync_date' => Carbon::now()->format('Y-m-d'),
        ]);
    }
}
