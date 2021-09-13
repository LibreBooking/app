<?php

use PHPUnit\Framework\TestCase;

class TestBase extends TestCase
{
    /**
     * @var FakeDatabase
     */
    public $db;

    /**
     * @var FakeServer
     */
    public $fakeServer;

    /**
     * @var FakeConfig
     */
    public $fakeConfig;

    /**
     * @var FakeResources
     */
    public $fakeResources;

    /**
     * @var FakeEmailService
     */
    public $fakeEmailService;

    /**
     * @var UserSession
     */
    public $fakeUser;

    /**
     * @var FakePluginManager
     */
    public $fakePluginManager;

    /**
     * @var FakeFileSystem
     */
    public $fileSystem;

    public function setUp(): void
    {
        Date::_SetNow(Date::Now());
        ReferenceNumberGenerator::$__referenceNumber = null;

        $this->db = new FakeDatabase();
        $this->fakeServer = new FakeServer();
        $this->fakeEmailService = new FakeEmailService();
        $this->fakeConfig = new FakeConfig();
        $this->fakeConfig->SetKey(ConfigKeys::DEFAULT_TIMEZONE, 'America/Chicago');

        $this->fakeResources = new FakeResources();
        $this->fakeUser = $this->fakeServer->UserSession;
        $this->fakePluginManager = new FakePluginManager();
        $this->fileSystem = new FakeFileSystem();

        ServiceLocator::SetDatabase($this->db);
        ServiceLocator::SetServer($this->fakeServer);
        ServiceLocator::SetEmailService($this->fakeEmailService);
        ServiceLocator::SetFileSystem($this->fileSystem);
        Configuration::SetInstance($this->fakeConfig);
        Resources::SetInstance($this->fakeResources);
        PluginManager::SetInstance($this->fakePluginManager);
    }

    public function teardown(): void
    {
        $this->db = null;
        $this->fakeServer = null;
        Configuration::SetInstance(null);
        PluginManager::SetInstance(null);
        $this->fakeResources = null;
        Date::_ResetNow();
    }
}
