<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;
use App\Role;

class RefreshAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refreshAccounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh Accounts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $remote_users = $this->retrieveUsers();
        foreach($remote_users as $remote_user)
        {
            $remote_roles = [];
            foreach($remote_user->roles as $role)
                $remote_roles[] = $role->name;
            
            $full_remote_roles = Role::whereIn('name', $remote_roles)->pluck('id');

            $user = User::where('username', $remote_user->username)->first();
            if($user)
            {
                $user->name = $remote_user->name;
                $user->password = $remote_user->password;
                $user->email = $remote_user->email;

                if(count($full_remote_roles) > 0)
                    $user->roles()->sync($full_remote_roles);
                else
                    $user->roles()->detach();
                $user->save();
            }
            else
            {
                if(count($full_remote_roles) > 0)
                {
                    $user = new User;
                    $user->name = $remote_user->name;
                    $user->username = $remote_user->username;
                    $user->password = $remote_user->password;
                    $user->email = $remote_user->email;

                    $user->save();
                    $user->roles()->sync($full_remote_roles);
                    $user->save();
                }
            }
        }
    }

    private function retrieveUsers()
    {
        try
        {
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET',
                                    env('HTTP_API_USERS', 'http://panel.alamedamaipu.cl/api/v2/user'),
                                    [
                                        'headers' => [
                                            'Authorization' => env('API_KEY', '-')
                                        ]
                                    ]
                                    )->getBody();
            echo "Get: ";
            echo $res;
            echo "\n";
            return json_decode($res);
        }
        catch(\Exception $e)
        {
            echo "Exception";
            return [];
        }
    }
}
