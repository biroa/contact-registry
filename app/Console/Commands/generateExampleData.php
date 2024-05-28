<?php

namespace App\Console\Commands;

use App\Models\Address;
use App\Models\Contact;
use App\Models\Detail;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class generateExampleData extends Command
{

    const MAX_ADDRESS_NUM = 2;


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-example-data {contactsNum} {detailsNum}';

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
        $createdContacts = 0;
        $contactsNum = (int)$this->argument('contactsNum');
        for ($i = 0; $i < $contactsNum; $i++) {
        $contacts = Contact::factory()
            ->has(Address::factory()->count(self::MAX_ADDRESS_NUM))
            ->has(Detail::factory()->count((int)$this->argument('detailsNum')))
            ->create();
            if(!$contacts->exists){
                $this->error('There was an issue so there are no contact yet!');
                return CommandAlias::FAILURE;
            }
            $createdContacts++;
        }
        if($createdContacts === $contactsNum){
            $this->info('Contacts are successfully generated!');
            return CommandAlias::SUCCESS;
        }
    }
}