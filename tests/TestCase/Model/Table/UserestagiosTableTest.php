<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserestagiosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserestagiosTable Test Case
 */
class UserestagiosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UserestagiosTable
     */
    protected $Userestagios;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Userestagios',
        'app.Alunos',
        'app.Supervisores',
        'app.Professores',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Userestagios') ? [] : ['className' => UserestagiosTable::class];
        $this->Userestagios = $this->getTableLocator()->get('Userestagios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Userestagios);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
