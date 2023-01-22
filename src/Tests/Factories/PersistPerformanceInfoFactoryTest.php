<?php

namespace Potatoquality\TopCheck\Tests\Factories;

use Potatoquality\TopCheck\Exceptions\InvalidCloudCredentialsException;
use Potatoquality\TopCheck\Exceptions\InvalidCommandDriverException;
use Potatoquality\TopCheck\Factories\PersistPerformanceInfoFactory;
use Potatoquality\TopCheck\Repositories\CloudSystemPerformanceInfoRepository;
use Potatoquality\TopCheck\Repositories\LocalSystemPerformanceInfoRepository;
use Tests\TestCase;

class PersistPerformanceInfoFactoryTest extends TestCase
{
    public function test_throws_exception_if_passed_invalid_driver()
    {
        $this->expectException(InvalidCommandDriverException::class);
        PersistPerformanceInfoFactory::forDriver("not a real driver");
    }

    public function test_returns_LocalSystemPerformanceInfoRepository_for_local_driver()
    {
        $result = PersistPerformanceInfoFactory::forDriver('local');
        $this->assertIsClass(LocalSystemPerformanceInfoRepository::class, $result);
    }

    public function test_returns_CloudSystemPerformanceInfoRepository_for_local_driver()
    {
        $result = PersistPerformanceInfoFactory::forDriver('cloud', 'client', 'secret', 'url');
        $this->assertIsClass(CloudSystemPerformanceInfoRepository::class, $result);
    }

    public function test_cloud_driver_throws_error_if_no_client_string_provided()
    {
        $this->expectException(InvalidCloudCredentialsException::class);
        $result = PersistPerformanceInfoFactory::forDriver('cloud', null, "s", "a");
    }

    public function test_cloud_driver_throws_error_if_no_secret_string_provided()
    {
        $this->expectException(InvalidCloudCredentialsException::class);
        $result = PersistPerformanceInfoFactory::forDriver('cloud', 'client', null, "a");
    }

    public function test_cloud_driver_throws_error_if_no_url_string_provided()
    {
        $this->expectException(InvalidCloudCredentialsException::class);
        $result = PersistPerformanceInfoFactory::forDriver('cloud', 'client', 'secret', null);
    }
}
