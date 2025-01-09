<?php
namespace Tests\Feature;

use App\Models\User;
use App\Models\Conta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ContaControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa o carregamento da página de conta.
     *
     * @return void
     */
    public function test_it_loads_the_account_page()
    {
        // Criação de um usuário
        $user = User::factory()->create();

        // Criação de conta para esse usuário
        Conta::factory()->create(['user_id' => $user->id]);
        Conta::factory()->create(['user_id' => $user->id]);

        // Login do usuário
        $this->actingAs($user);

        // Acessando a página de conta
        $response = $this->get(route('conta'));

        // Verifica se a resposta é bem-sucedida (status 200)
        $response->assertStatus(200);

        // Verifica se as conta do usuário estão sendo passadas para a view
        $response->assertViewHas('contas');
    }

    /**
     * Testa a criação de uma nova conta.
     *
     * @return void
     */
    public function test_it_creates_a_new_account()
    {
        // Criação de um usuário
        $user = User::factory()->create();

        // Login do usuário
        $this->actingAs($user);

        // Acessando a rota para criar a conta
        $response = $this->post(route('conta.criar'));

        // Verifica se a conta foi criada
        $this->assertDatabaseHas('conta', [
            'user_id' => $user->id,
            'saldo' => 0
        ]);

        // Verifica o redirecionamento após a criação
        $response->assertRedirect(route('conta'));
    }

    /**
     * Testa se a sessão é limpa após a criação de uma conta.
     *
     * @return void
     */
    public function test_session_is_cleared_after_account_creation()
    {
        // Criação de um usuário
        $user = User::factory()->create();

        // Configurando uma mensagem de sucesso na sessão
        session()->put('success', 'Conta criada com sucesso');

        // Login do usuário
        $this->actingAs($user);

        // Acessando a rota para criar a conta
        $response = $this->post(route('conta.criar'));

        // Verifica se as mensagens da sessão foram limpas
        $this->assertNull(session('success'));
        $this->assertNull(session('error'));
        $this->assertNull(session('warning'));
    }
}