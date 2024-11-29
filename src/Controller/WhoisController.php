<?php
declare(strict_types=1);
namespace App\Controller;

use Cake\View\JsonView;
use Iodev\Whois\Factory;
use Cake\Http\Exception\BadRequestException;
use App\Validation\DomainValidator;
use Cake\Http\Exception\HttpException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Exception\MethodNotAllowedException;
use Cake\Http\Exception\NotAcceptableException;
use Cake\Http\Exception\ServiceUnavailableException;

class WhoisController extends AppController
{
    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function index()
    {
      
        $domain = $this->request->getQuery('domain');

        if (empty($domain)) {
            throw new BadRequestException("Il parametro 'domain' deve essere fornito e non deve essere vuoto");
        }

        $validator = DomainValidator::buildValidator();
        $data = ['domain' => $domain];
        
        // Esegui la validazione
        $errors = $validator->validate($data);

        if (!empty($errors)) {
            throw new HttpException($errors['domain']['validDomain'],422);
        }

        if (!preg_match('/\.com$/', $domain)) {
            throw new NotAcceptableException('Solo i domini .com sono supportati');
        }
    
        $whois = Factory::get()->createWhois();

        if($whois->isDomainAvailable($domain)){
            throw new NotAcceptableException('Il dominio non è registrato');
        }

        $response = null;
        try {
            $response = $whois->lookupDomain($domain);
        } catch (\Exception $e) {
            throw new ServiceUnavailableException('Errore di connessione al servizio WHOIS');
        }

        
      
        $whoisText = $response->text;

    
        $this->set('whois', $whoisText);
        $this->viewBuilder()->setOption('serialize', ['whois']);
    }

 
}