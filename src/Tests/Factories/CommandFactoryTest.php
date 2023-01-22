<?php

namespace Potatoquality\TopCheck\Tests\Factories;

use Potatoquality\TopCheck\Exceptions\CommandNotFoundException;
use Potatoquality\TopCheck\Factories\CommandFactory;
use Potatoquality\TopCheck\ShellCommands\DarwinTopCommand;
use Potatoquality\TopCheck\ShellCommands\FakeTopCommand;
use Potatoquality\TopCheck\ShellCommands\LinuxTopCommand;
use Tests\TestCase;

class CommandFactoryTest extends TestCase
{
    public function test_returns_LinuxTopCommand_on_linux_os()
    {
        $this->assertIsClass(LinuxTopCommand::class, CommandFactory::forOperatingSystem("Linux"));
    }

    public function test_returns_DarwinTopCommand_on_mac_os()
    {
        $this->assertIsClass(DarwinTopCommand::class, CommandFactory::forOperatingSystem("Darwin"));
    }

    public function test_returns_FakeTopCommand_if_provided_Fake()
    {
        $this->assertIsClass(FakeTopCommand::class, CommandFactory::forOperatingSystem("Fake"));
    }

    public function test_throws_exception_if_command_not_found()
    {
        $this->expectException(CommandNotFoundException::class);
        CommandFactory::forOperatingSystem("Any string that isnt a real OS");
    }
}
