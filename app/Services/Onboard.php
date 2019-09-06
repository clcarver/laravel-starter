<?php


namespace App\Services;


use App\Notifications\NewOnboardEntry;
use App\Task;
use App\Template;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Notification;

class Onboard
{
    protected $user;

    protected $request;

    protected $json;

    public function __construct($user, Request $request)
    {
        $this->user = $user instanceof User ? $user : $this->createShellUser($request);
        $this->user->load('tasks');

        $this->request = $request;
    }

    public function userHasTasks()
    {
        return !$this->user->tasks->isEmpty();
    }

    protected function createShellUser(Request $request)
    {
        $user = User::create([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'employee_id' => $request->get('employee_id'),
            'start_date' => $request->get('start_date'),
            'manager_id' => $request->get('manager_id'),
            'avatar' => '/default.png'
        ]);

        $user->assign('employee');

        return $user;
    }

    public function generateTasks() {
        if($this->userHasTasks()) {
            $this->json = [
                'status' => 'error',
                'message' => 'This user has tasks already assigned!'
            ];
            return $this;
        }

        $tasks = Template::where('type', 'onboard')->where('is_active', 1)->get()->transform(function($item) {
            return [
                'user_id' => $this->user->id,
                'template_id' => $item->id,
                'complete_by' => $this->calculateDate($item)->format('Y-m-d'),
                'accountable_role' => $item->accountable_role,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        });

        Task::insert($tasks->toArray());

        $this->user->load(['tasks']);

        $this->processNewOnboardEntry();

        $this->json = [
            'status' => 'success',
            'message' => 'Onboarding process has been initiated.',
            'user' => User::userTasks($this->user)
        ];

        return $this;
    }

    public function calculateDate($item)
    {
        $due = Carbon::parse($this->request->get('start_date'))->addDays($item->offset);

        return $due->lt(Carbon::now()) ? Carbon::tomorrow() : $due;
    }

    public static function recalculateDate($start_date, Task $task)
    {
        $task->load('template');

        $due = Carbon::parse($start_date)->addDays($task->template->offset);

        return $due->lt(Carbon::now()) ? Carbon::tomorrow() : $due;
    }

    public function getEmailsForIncompleteTasks()
    {
        return $this->user->tasks->where('status', 0)->unique('accountable_role')->transform(function($item) {
            if($item['accountable_role'] == 'manager') {
                return User::select('email')->where('id', $this->user->manager_id)->get()->pluck('email')->first();
            } else
                return User::whereIs($item['accountable_role'])->get()->pluck('email')->flatten();
        })->flatten();
    }

    protected function processNewOnboardEntry()
    {
        $users = User::whereIn('email', $this->getEmailsForIncompleteTasks())->get();

        Notification::send($users, new NewOnboardEntry($this->user));
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getResponse()
    {
        return $this->json;
    }
}