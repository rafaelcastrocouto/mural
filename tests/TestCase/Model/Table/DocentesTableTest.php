<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocentesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocentesTable Test Case
 */
class DocentesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DocentesTable
     */
    protected $Docentes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Docentes',
        'app.Estagiarios',
        'app.Muralestagios',
        'app.Userestagios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Docentes') ? [] : ['className' => DocentesTable::class];
        $this->Docentes = $this->getTableLocator()->get('Docentes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Docentes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
