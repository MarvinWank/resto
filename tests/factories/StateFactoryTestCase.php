<?php


namespace factories;


use App\Daos\StateDao;
use App\Factories\StateFactory;
use App\Models\State;
use Ramsey\Uuid\Uuid;

class StateFactoryTestCase extends \FactoryTestCase
{
    private StateFactory $stateFactory;
    private StateDao $stateDao;

    public function setUp(): void
    {
        parent::setUp();
        $this->stateFactory = app(StateFactory::class);
        $this->stateDao = app(StateDao::class);
    }

    /**
     * @test
     */
    public function es_testet_erzeugung_von_neuem_state()
    {
        $state = $this->stateFactory->retrieve(null);
        $this->assertInstanceOf(State::class, $state);
    }

    /**
     * @test
     */
    public function es_testet_speichern_von_session()
    {
        $uuid = Uuid::uuid4();
        $state = $this->stateFactory->retrieve($uuid);
        $state->setUserID($this->test_user->getID());
        $this->stateFactory->save($state);

        $dao_state = $this->stateDao->find($uuid);
        $this->assertEquals(1, $dao_state->getAttribute(StateDao::PROPERTY_USER_ID));
    }
}
