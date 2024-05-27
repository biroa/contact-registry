<?php

namespace App\Console\Commands;

use App\Models\Address;
use App\Models\Contact;
use App\Models\Detail;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class generateExampleData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-example-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Let's generate example data for x with 2 addresses and y details";

    /**
     * @return int
     */
    public function handle(): int
    {
        $contacts = Contact::factory()
            ->has(Address::factory()->count(2))
            ->has(Detail::factory()->count(10))
            ->create();
        if(!$contacts->exists){
            $this->error('There was an issue so there are no contact yet!');
            return CommandAlias::FAILURE;
        }
        $this->info('Users with relationships are created');
        return CommandAlias::SUCCESS;
    }
}
