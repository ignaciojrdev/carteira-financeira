<?php
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_loads_the_login_page()
    {
        $response = $this->get('/Login');
        $response->assertStatus(200);
    }

    #[Test]
    public function it_allows_a_user_to_login_with_valid_credentials()
    {
        // Cria um usuário para testar o login
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/Login', [
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/Conta');  // Redirecionamento para a página de contas
        $this->assertAuthenticatedAs($user); // Verifica se o usuário está autenticado
    }

    #[Test]
    public function it_shows_validation_errors_for_invalid_login_data()
    {
        $response = $this->post('/Login', [
            'email' => '',  // E-mail vazio
            'password' => '', // Senha vazia
        ]);

        $response->assertSessionHasErrors(['email', 'password']);
    }

    #[Test]
    public function it_shows_error_if_invalid_credentials_are_provided()
    {
        // Cria um usuário válido
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/Login', [
            'email' => 'john@example.com',
            'password' => 'wrongpassword', // Senha incorreta
        ]);

        $response->assertSessionHasErrors(['email']);  // Verifica se o erro de e-mail foi retornado
    }

    #[Test]
    public function it_logs_out_the_user()
    {
        // Cria e autentica um usuário
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($user);

        // Realiza o logout
        $response = $this->post('/Logout');
        $response->assertRedirect('/');  // Redirecionamento para a página inicial
        $this->assertGuest();  // Verifica se o usuário foi deslogado
    }
}