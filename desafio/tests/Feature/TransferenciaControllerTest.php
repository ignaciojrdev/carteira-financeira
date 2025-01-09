
<?php

use App\Models\Conta;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Validation\ValidationException;
class TransferenciaControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function testTransferenciaComSucesso()
    {
        $contaOrigem = Conta::factory()->create(['saldo' => 100, 'user_id' => $this->user->id]);
        $contaDestino = Conta::factory()->create(['saldo' => 50, 'user_id' => $this->user->id]);
        $response = $this->post(route('transferencia.transferir'), [
            'origem_conta_id' => $contaOrigem->conta_id,
            'destino_conta_id' => $contaDestino->conta_id,
            'valor' => 30,
        ]);
        $response->assertRedirect(route('conta'));
        $response->assertSessionHas('success', 'Transferência realizada com sucesso.');
        $contaOrigem->refresh();
        $contaDestino->refresh();

        $this->assertEquals(70, $contaOrigem->saldo);
        $this->assertEquals(80, $contaDestino->saldo);
    }

    public function testSaldoInsuficiente()
    {
        $contaOrigem = Conta::factory()->create(['saldo' => 10, 'user_id' => $this->user->id]);
        $contaDestino = Conta::factory()->create(['saldo' => 50, 'user_id' => $this->user->id]);
        $response = $this->post(route('transferencia.transferir'), [
            'origem_conta_id' => $contaOrigem->conta_id,
            'destino_conta_id' => $contaDestino->conta_id,
            'valor' => 20,
        ]);
        //$response->assertRedirect(route('conta'));
        //$response->assertSessionHas('error', 'Saldo insuficiente para realizar a transferência!');
        $response->assertSessionHas('error', 'Saldo insuficiente para realizar a transferência!');
    }

    public function testTransferenciaContaOrigemIgualDestino()
    {
        $contaOrigem = Conta::factory()->create(['saldo' => 100, 'user_id' => $this->user->id]);
        $response = $this->post(route('transferencia.transferir'), [
            'origem_conta_id' => $contaOrigem->conta_id,
            'destino_conta_id' => $contaOrigem->conta_id,
            'valor' => 30,
        ]);
        $response->assertSessionHasErrors(['destino_conta_id'=> 'A conta de origem não pode ser a mesma da conta de destino.']);
    }

    public function testTransferenciaContaDestinoInexistente()
    {
        $contaOrigem = Conta::factory()->create(['saldo' => 100, 'user_id' => $this->user->id]);
        $response = $this->post(route('transferencia.transferir'), [
            'origem_conta_id' => $contaOrigem->conta_id,
            'destino_conta_id' => 9999, // Conta inexistente
            'valor' => 30,
        ]);
        $response->assertSessionHasErrors(['destino_conta_id' => 'A conta de destino não foi encontrada.']);
    }

    public function testTransferenciaSemValor()
    {
        $contaOrigem = Conta::factory()->create(['saldo' => 100, 'user_id' => $this->user->id]);
        $contaDestino = Conta::factory()->create(['saldo' => 50, 'user_id' => $this->user->id]);
        $response = $this->post(route('transferencia.transferir'), [
            'origem_conta_id' => $contaOrigem->conta_id,
            'destino_conta_id' => $contaDestino->conta_id,
            'valor' => 0,
        ]);
        $response->assertSessionHasErrors(['valor' => 'O valor da transferência deve ser maior que zero.']);
    }
}