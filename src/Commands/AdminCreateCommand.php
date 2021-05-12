<?php


namespace ZhyuVueCurd\Commands;


use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {name} {email} {--S|super} {--exist}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '建立一個管理用戶，若是要超級管理員請加 -S，若是指定已存在的--exist';

    public function handle()
    {
        $count = DB::table('teams')->where('id', 1)->where('user_id', 0)->count();
        if($count == 0){
            $this->error('Please run migrate first to inital teams table!!!');
            exit;
        }

        $name = $this->argument('name');
        $email = trim($this->argument('email'));
        $is_super_admin = (bool) $this->option('super');
        $is_exist = (bool) $this->option('exist');

        $admin = $is_super_admin === true ? 'super admin' : 'admin';
        $confirm_text = 'Do you wish to assign this user \''.$email.'\' to '.$admin.'?';

        if($is_exist===false) {
            $count = DB::table('users')->where('email', $email)->count();
            if ($count > 0) {
                $this->error('This email have been registered!!!');
                exit;
            }
            $password = $this->secret('Please enter password?');

            $confirm_text = 'Do you wish to create this user \''.$email.'\'?';
        }

        $now = Carbon::now();

        if ($this->confirm($confirm_text)) {
            if($is_exist===false) {
                DB::table('users')->insert([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'current_team_id' => $is_super_admin === true ? 1 : 2,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            $user = DB::table('users')->where('email', $email)->first();

            //--超級管理者
            if($is_super_admin===true) {
                DB::table('team_user')->insert([
                    'team_id' => 1,
                    'user_id' => $user->id,
                    'role' => 'super_admin',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

            }

            //--管理者
            DB::table('team_user')->insert([
                'team_id' => 2,
                'user_id' => $user->id,
                'role' => 'admin',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

}
