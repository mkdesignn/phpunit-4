<?php


class PaymentTest extends \PHPUnit\Framework\TestCase
{

    private $data;

    public function setUp(): void
    {
        parent::setUp();
        $this->data = ['token'=>bin2hex(random_bytes(120)), 'amount'=>1000];
    }

    public function testAddToWalletShouldCallChargeWithSpecificArguments()
    {

        // Mocking Payment service
        $mockPaymentClass = Mockery::mock();
        $mockPaymentClass->shouldReceive('charge')
            ->with($this->data['token'], $this->data['amount'])
            ->andReturn(['status'=>200]);

        // Mocking ServiceFactory
        $mockedService = Mockery::mock('alias:'.\App\Api\V1\Factories\ServiceFactory::class);
        $mockedService->shouldReceive('build')->with('Adyen')->andReturn($mockPaymentClass);

        $paymentController = new \App\Controllers\PaymentController(new \App\Models\User());
        $request = new \Symfony\Component\HttpFoundation\Request([], $this->data);
        $paymentController->addToWallet('adyen', $request);
    }


    public function testAddToWalletShouldReturnSuccessIfAllGoesWell()
    {

        // Mocking Payment service
        $mockPaymentClass = Mockery::mock();
        $mockPaymentClass->shouldReceive('charge')
            ->with($this->data['token'], $this->data['amount'])
            ->andReturn(['status'=>200]);

        // Mocking ServiceFactory
        $mockedService = Mockery::mock('alias:'.\App\Api\V1\Factories\ServiceFactory::class);
        $mockedService->shouldReceive('build')->with('Adyen')->andReturn($mockPaymentClass);

        $paymentController = new \App\Controllers\PaymentController(new \App\Models\User());
        $request = new \Symfony\Component\HttpFoundation\Request([], $this->data);
        $response = $paymentController->addToWallet('adyen', $request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testAddToWalletShouldThrowAnErrorIfSomethingGoesWrong()
    {

        // Mocking Payment service
        $mockPaymentClass = Mockery::mock();
        $mockPaymentClass->shouldReceive('charge')
            ->with($this->data['token'], $this->data['amount'])
            ->andReturn(['status'=>500]);

        // Mocking ServiceFactory
        $mockedService = Mockery::mock('alias:'.\App\Api\V1\Factories\ServiceFactory::class);
        $mockedService->shouldReceive('build')->with('Adyen')->andReturn($mockPaymentClass);

        $paymentController = new \App\Controllers\PaymentController(new \App\Models\User());
        $request = new \Symfony\Component\HttpFoundation\Request([], $this->data);
        $response = $paymentController->addToWallet('adyen', $request);

        $this->assertEquals(502, $response->getStatusCode());

    }

    public function tearDown(): void
    {
        parent::tearDown();

        $container = Mockery::getContainer();
        $this->addToAssertionCount($container->mockery_getExpectationCount());

        Mockery::close();

    }

}