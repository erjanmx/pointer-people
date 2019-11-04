<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\LinkedInProvider;

class UpdateLinkedInProfilePicturesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:linkedin-users {--sleep=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update LinkedIn profile pictures';

    /**
     * @var LinkedInProvider
     */
    protected $provider;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->provider = Socialite::driver('linkedin');
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::query()
            ->whereNotNull('linkedin_token')
            ->whereNull('avatar_blob')
            ->get();

        foreach ($users as $user) {
            $this->info($user->name);

            try {
                $linkedInUser = $this->provider->userFromToken($user->linkedin_token);
                $user->update([
                    'avatar' => data_get($linkedInUser, 'avatar_original', $linkedInUser->getAvatar()),
                ]);
            } catch (\Exception $exception) {
                $this->error($exception->getMessage());
            } finally {
                sleep($this->option('sleep'));
            }
        }

        $this->info('Done.');
    }
}
