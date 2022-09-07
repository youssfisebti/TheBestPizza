<?php

namespace App\Tests\Controller;

use App\Entity\Ingredient;
use App\Repository\IngredientRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IngredientControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private IngredientRepository $repository;
    private string $path = '/ingredients/';

    protected function setUp(): void
    {
        self::ensureKernelShutdown();
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Ingredient::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function loginAsAdmin(): KernelBrowser
    {
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByUsername('admin');

        // simulate $testUser being logged in
        return $this->client->loginUser($testUser);
    }

    public function testIndex(): void
    {
        $client = $this->loginAsAdmin();
        $client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Ingredient index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $client = $this->loginAsAdmin();
        $client->request('GET', sprintf('%screation', $this->path));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Ajout Ingredient');

        $client->submitForm('ingredient_submit', [
            'ingredient[name]' => 'Testing',
            'ingredient[price]' => 2,
        ]);

        self::assertResponseRedirects('/ingredients/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $client = $this->loginAsAdmin();
        $fixture = new Ingredient();
        $fixture->setName('My Title');
        $fixture->setPrice(2);

        $this->repository->add($fixture, true);

        $client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Ingredient');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $client = $this->loginAsAdmin();
        $fixture = new Ingredient();
        $fixture->setName('My Title');
        $fixture->setPrice(2);

        $this->repository->add($fixture, true);

        $client->request('GET', sprintf('%s%s/edition', $this->path, $fixture->getId()));

        $client->submitForm('ingredient_submit', [
            'ingredient[name]' => 'My Title',
            'ingredient[price]' => 2,
        ]);

        self::assertResponseRedirects('/ingredients/');

        $fixture = $this->repository->findAll();

        self::assertSame('My Title', $fixture[0]->getName());
        self::assertSame(2.0, $fixture[0]->getPrice());
    }
}
