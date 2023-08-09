<?php

namespace App\Command;

use App\Service\User\Form\UserCreateData;
use App\Service\User\UserService;
use DateTime;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

#[AsCommand(
    name: 'RegisterUserCommand',
    description: 'Add a short description for your command',
)]
class RegisterUserCommand extends Command
{
    public function __construct(private readonly UserService $userService)
    {
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

        $nameQuestion = new Question('Enter name: ');
        $name = $helper->ask($input, $output, $nameQuestion);

        $passwordQuestion = new Question('Enter password: ');
        $passwordQuestion->setHidden(true);
        $passwordQuestion->setHiddenFallback(false);
        $password = $helper->ask($input, $output, $passwordQuestion);

        // Create a new User entity and set its properties
        $data = new UserCreateData();
        $data->setDescription($name);
        $data->setPassword($password);
        $data->setLastSeen(new DateTime());

        // Persist the user entity
        $user = $this->userService->createByData($data);
        $output->writeln($user->getUuid());
        $output->writeln('User registered successfully.');

        return Command::SUCCESS;
    }
}
