<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class WhoisControllerTest extends TestCase
{
    use IntegrationTestTrait;

    public function testMissingDomainException(): void
    {
        $this->get('/whois.json'); // Nessun dominio fornito
        $this->assertResponseCode(400, 'Dovrebbe tornare un 400');
    }

    public function testInvalidDomainException(): void
    {
        $this->get('/whois.json?domain=invalid_domain');
        $this->assertResponseCode(422, 'Dovrebbe tornare un 422');
    }

    public function testDomainNotFoundException(): void
    {
        $this->get('/whois.json?domain=xxxxxnonexistentxxxxxxx.com');
        $this->assertResponseCode(406, 'Dovrebbe tornare 406');
    }
}
