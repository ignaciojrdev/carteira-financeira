<?php
use App\Models\User;
use App\Models\Conta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\DataProvider;

class CadastroControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_loads_the_registration_page()
    {
        $response = $this->get('/Cadastro');
        $response->assertStatus(200);
    }

    #[Test]
    public function it_creates_a_user_and_account_successfully()
    {
        $response = $this->post('/Cadastro', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // Verifica se o usuário foi criado e se foi redirecionado para a página inicial
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
        $this->assertDatabaseHas('conta', ['user_id' => 1]);

        $response->assertRedirect(route('home'));
    }

    #[Test]
    public function it_displays_validation_errors_for_invalid_data()
    {
        $response = $this->post('/Cadastro', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'mismatch',
        ]);

        $response->assertSessionHasErrors([
            'name', 'email', 'password'
        ]);
    }

    #[Test]
    public function it_shows_error_if_email_is_already_taken()
    {
        // Cria um usuário para que o e-mail seja ocupado
        User::create([
            'name' => 'Jane Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/Cadastro', [
            'name' => 'John Doe',
            'email' => 'john@example.com', // E-mail já registrado
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
    }
}
