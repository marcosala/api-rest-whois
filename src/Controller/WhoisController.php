<?php
declare(strict_types=1);
namespace App\Controller;
// src/Controller/RecipesController.php
use Cake\View\JsonView;

class WhoisController extends AppController
{
    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function index()
    {
        $data = [

        ];
        
        $this->set('whois', $data);
        $this->viewBuilder()->setOption('serialize', ['whois']);
    }

 
}