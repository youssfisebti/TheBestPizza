<?php

namespace App\Test\Controller;

use App\Entity\Allergies;
use App\Repository\AllergiesRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AllergiesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private AllergiesRepository $repository;
    private string $path = '/allergies/';

    protected function setUp(): void
    {
        self::ensureKernelShutdown();
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Allergies::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function loginAsClient(): KernelBrowser
    {
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByUsername('client');

        // simulate $testUser being logged in
        return $this->client->loginUser($testUser);
    }

    public function testIndex(): void
    {
        $client = $this->loginAsClient();
        $client->request('GET', $this->path);
        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Ajouter une Allergie');
    }
}
