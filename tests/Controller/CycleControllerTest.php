<?php

namespace App\Test\Controller;

use App\Entity\Cycle;
use App\Repository\CycleRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CycleControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CycleRepository $repository;
    private string $path = '/cycle/';


    // protected function setUp(): void
    // {
    //     $this->client = static::createClient();
    //     $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Cycle::class);

    //     foreach ($this->repository->findAll() as $object) {
    //         $this->repository->remove($object, true);
    //     }
    // }

    // public function testIndex(): void
    // {
    //     $crawler = $this->client->request('GET', $this->path);

    //     self::assertResponseStatusCodeSame(200);
    //     self::assertPageTitleContains('Cycle index');

    //     // Use the $crawler to perform additional assertions e.g.
    //     // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    // }

    // public function testNew(): void
    // {
    //     $originalNumObjectsInRepository = count($this->repository->findAll());

    //     $this->markTestIncomplete();
    //     $this->client->request('GET', sprintf('%snew', $this->path));

    //     self::assertResponseStatusCodeSame(200);

    //     $this->client->submitForm('Save', [
    //         'cycle[dateBegin]' => 'Testing',
    //         'cycle[dateEnd]' => 'Testing',
    //         'cycle[solde]' => 'Testing',
    //         'cycle[isActive]' => 'Testing',
    //         'cycle[createdAt]' => 'Testing',
    //         'cycle[bankAccount]' => 'Testing',
    //     ]);

    //     self::assertResponseRedirects('/cycle/');

    //     self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    // }

    // public function testShow(): void
    // {
    //     $this->markTestIncomplete();
    //     $fixture = new Cycle();
    //     $fixture->setDateBegin('My Title');
    //     $fixture->setDateEnd('My Title');
    //     $fixture->setSolde('My Title');
    //     $fixture->setIsActive('My Title');
    //     $fixture->setCreatedAt('My Title');
    //     $fixture->setBankAccount('My Title');

    //     $this->repository->add($fixture, true);

    //     $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

    //     self::assertResponseStatusCodeSame(200);
    //     self::assertPageTitleContains('Cycle');

    //     // Use assertions to check that the properties are properly displayed.
    // }

    // public function testEdit(): void
    // {
    //     $this->markTestIncomplete();
    //     $fixture = new Cycle();
    //     $fixture->setDateBegin('My Title');
    //     $fixture->setDateEnd('My Title');
    //     $fixture->setSolde('My Title');
    //     $fixture->setIsActive('My Title');
    //     $fixture->setCreatedAt('My Title');
    //     $fixture->setBankAccount('My Title');

    //     $this->repository->add($fixture, true);

    //     $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

    //     $this->client->submitForm('Update', [
    //         'cycle[dateBegin]' => 'Something New',
    //         'cycle[dateEnd]' => 'Something New',
    //         'cycle[solde]' => 'Something New',
    //         'cycle[isActive]' => 'Something New',
    //         'cycle[createdAt]' => 'Something New',
    //         'cycle[bankAccount]' => 'Something New',
    //     ]);

    //     self::assertResponseRedirects('/cycle/');

    //     $fixture = $this->repository->findAll();

    //     self::assertSame('Something New', $fixture[0]->getDateBegin());
    //     self::assertSame('Something New', $fixture[0]->getDateEnd());
    //     self::assertSame('Something New', $fixture[0]->getSolde());
    //     self::assertSame('Something New', $fixture[0]->getIsActive());
    //     self::assertSame('Something New', $fixture[0]->getCreatedAt());
    //     self::assertSame('Something New', $fixture[0]->getBankAccount());
    // }

    // public function testRemove(): void
    // {
    //     $this->markTestIncomplete();

    //     $originalNumObjectsInRepository = count($this->repository->findAll());

    //     $fixture = new Cycle();
    //     $fixture->setDateBegin('My Title');
    //     $fixture->setDateEnd('My Title');
    //     $fixture->setSolde('My Title');
    //     $fixture->setIsActive('My Title');
    //     $fixture->setCreatedAt('My Title');
    //     $fixture->setBankAccount('My Title');

    //     $this->repository->add($fixture, true);

    //     self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

    //     $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
    //     $this->client->submitForm('Delete');

    //     self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
    //     self::assertResponseRedirects('/cycle/');
    // }

}
