<?php
declare(strict_types=1);
namespace App\Controller;

use Cake\View\JsonView;
use Iodev\Whois\Factory;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Exception\InternalServerErrorException;

class WhoisController extends AppController
{
    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function index()
    {

        throw new BadRequestException('Invalid domain format');
        $whois = Factory::get()->createWhois();

        // Checking availability
        if ($whois->isDomainAvailable("google.com")) {
            print "Bingo! Domain is available! :)";
        }

        // Supports Unicode (converts to punycode)
        if ($whois->isDomainAvailable("почта.рф")) {
            print "Bingo! Domain is available! :)";
        }

        // Getting raw-text lookup
        $response = $whois->lookupDomain("google.com");
        $whoisText = $response->text;

      

        $this->set('whois', $whoisText);
        $this->viewBuilder()->setOption('serialize', ['whois']);
    }

 
}