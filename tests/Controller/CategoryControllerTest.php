<?php

namespace App\Test\Controller;

use App\Entity\Category;
use App\Entity\User;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CategoryRepository $repository;
    private string $path = '/category/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Category::class);

        // foreach ($this->repository->findAll() as $object) {
        //     $this->repository->remove($object, true);
        // }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Categories');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'category[Label]' => 'Testing',
            'category[Color]' => 'Testing',
            'category[User]' => new User(),
        ]);

        self::assertResponseRedirects('/category/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    // public function testShow(): void
    // {
    //     $this->markTestIncomplete();
    //     $fixture = new Category();
    //     $fixture->setLabel('My Title');
    //     $fixture->setColor('My Title');
    //     $fixture->setUser('My Title');

    //     $this->repository->add($fixture, true);

    //     $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

    //     self::assertResponseStatusCodeSame(200);
    //     self::assertPageTitleContains('Category');

    //     // Use assertions to check that the properties are properly displayed.
    // }

    // public function testEdit(): void
    // {
    //     $this->markTestIncomplete();
    //     $fixture = new Category();
    //     $fixture->setLabel('My Title');
    //     $fixture->setColor('My Title');
    //     $fixture->setUser('My Title');

    //     $this->repository->add($fixture, true);

    //     $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

    //     $this->client->submitForm('Update', [
    //         'category[Label]' => 'Something New',
    //         'category[Color]' => 'Something New',
    //         'category[User]' => 'Something New',
    //     ]);

    //     self::assertResponseRedirects('/category/');

    //     $fixture = $this->repository->findAll();

    //     self::assertSame('Something New', $fixture[0]->getLabel());
    //     self::assertSame('Something New', $fixture[0]->getColor());
    //     self::assertSame('Something New', $fixture[0]->getUser());
    // }

    // public function testRemove(): void
    // {
    //     $this->markTestIncomplete();

    //     $originalNumObjectsInRepository = count($this->repository->findAll());

    //     $fixture = new Category();
    //     $fixture->setLabel('My Title');
    //     $fixture->setColor('My Title');
    //     $fixture->setUser('My Title');

    //     $this->repository->add($fixture, true);

    //     self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

    //     $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
    //     $this->client->submitForm('Delete');

    //     self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
    //     self::assertResponseRedirects('/category/');
    // }
}
