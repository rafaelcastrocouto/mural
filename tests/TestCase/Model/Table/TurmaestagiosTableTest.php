<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TurmasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TurmasTable Test Case
 */
class TurmasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TurmasTable
     */
    protected $Turmas;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Turmas',
        'app.Estagiarios',
        'app.Muralestagios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Turmas') ? [] : ['className' => TurmasTable::class];
        $this->Turmas = $this->getTableLocator()->get('Turmas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Turmas);

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
