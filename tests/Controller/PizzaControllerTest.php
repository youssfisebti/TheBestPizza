<?php

namespace App\Test\Controller;

use App\Entity\Pizza;
use App\Repository\PizzaRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PizzaControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PizzaRepository $repository;
    private string $path = '/pizzas/';

    protected function setUp(): void
    {
        self::ensureKernelShutdown();
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Pizza::class);

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
        self::assertPageTitleContains('Pizza index');
    }

    public function testNew(): void
    {
        $client = $this->loginAsAdmin();
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('pizza_submit', [
            'pizza[name]' => 'Testing',
        ]);

        self::assertResponseRedirects('/pizzas/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $client = $this->loginAsAdmin();
        $fixture = new Pizza();
        $fixture->setName('My Title');

        $this->repository->add($fixture, true);

        $client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Pizza');

    }

    public function testEdit(): void
    {
        $client = $this->loginAsAdmin();
        $fixture = new Pizza();
        $fixture->setName('My Title');

        $this->repository->add($fixture, true);

        $client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $client->submitForm('pizza_submit', [
            'pizza[name]' => 'Something New',
        ]);

        self::assertResponseRedirects('/pizzas/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
    }
}
