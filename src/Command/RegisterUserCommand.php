<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Uid\Factory\UuidFactory;
use Symfony\Component\Uid\Uuid;

#[AsCommand(
    name: 'RegisterUserCommand',
    description: 'Add a short description for your command',
)]
class RegisterUserCommand extends Command
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private UuidFactory $uuidFactory,
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:register-user')
            ->setDescription('Register a new user');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $usernameQuestion = new Question('Enter username: ');
        $username = $helper->ask($input, $output, $usernameQuestion);

        $passwordQuestion = new Question('Enter password: ');
        $passwordQuestion->setHidden(true);
        $passwordQuestion->setHiddenFallback(false);
        $password = $helper->ask($input, $output, $passwordQuestion);

        // Create a new User entity and set its properties
        $user = new User();
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $password
        );


        $user->setPassword($hashedPassword);

        $uuid = $this->uuidFactory->create();
//        dd($user);
        $user->setUuid($uuid->toBase58());

        // Persist the user entity
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln($user->getUuid());
        $output->writeln('User registered successfully.');

        return Command::SUCCESS;
    }
}
