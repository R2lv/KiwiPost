<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Classes\Msge;

class MessageUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'msg:call {message?} {test?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Messages all the users';

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
        if($this->argument('message')){
            $message = $this->argument('message');
        }else{
            $message = "Kiwi Postis dzvirfaso momxmarebelo tqveni txovnit Tbilisshi, Ar.Tsagarelis N60shi mdebare chveni ofisi mogemsaxurebat yovel kvira dges 15:00 st-dan 20:00 st-mde. Madloba rom sargeblobt chveni momsaxurebit.%0a==========%0aDear Customer of Kiwi Post, at your request, our office on 60 Tsagareli Street in Tbilisi will serve you on Sunday 3:00 pm to 8:00pm.%0aKind regards from Kiwi Post.";
        }



        if($this->argument('test')){
            $users = User::query()->select('mobile')->where('mobile','LIKE','995%')->limit(2)->get();
        }else{
            $users = User::query()->select('mobile')->where('mobile','LIKE','995%')->get();
        }

        $counter = 0;

        foreach($users as $user) {
            if(strlen($user->mobile) == 12) {

                $msge = new Msge();
                $msge->message = $message;

                if($this->argument('test')){
                    $msge->to = "995599399808";
                }else{
                    $msge->to = $user->mobile;
                }

                $res = $msge->send();

                $this->info("$res ++++++ mob = $user->mobile.");
                $counter++;
            }

        }

        $this->info('Finished messaging'." counter = $counter");
    }
}
