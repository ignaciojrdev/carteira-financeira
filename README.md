# Carteira Financeira

Este repositório contém o projeto **Carteira Financeira**, desenvolvido com Laravel e utilizando Docker para gerenciamento do ambiente.

## Pré-requisitos

Antes de começar, certifique-se de ter instalado em sua máquina:

- [Git](https://git-scm.com/)
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- [Composer](https://getcomposer.org/)

## Passos para execução

Siga os passos abaixo para configurar e executar o projeto:

1. Clone o repositório:
```bash
git clone https://github.com/v1ncer3/carteira-financeira.git
```

2. Navegue até o diretório do desafio:
```bash
cd .\carteira-financeira\desafio\
```

3. Inicie o Docker e depois inicie os containers Docker:
```bash
docker compose up -d
```

Caso utilize o linux, verifique se o Docker está ativo com o comando e ai inicie os containers com o mesmo comando do tópico 3:
```bash
sudo systemctl start docker
```

4. Acesse o container da API Laravel:
```bash
docker exec -it api-laravel-back sh
```

5. Navegue até o diretório da aplicação dentro do container:
```bash
cd app
```

6. Instale as dependências do projeto:
```bash
composer install
```

7. Crie o arquivo `.env` na raiz do projeto:
- Copie o conteúdo do arquivo `.env.example` e renomeie para `.env`.

8. Gere a chave da aplicação:
```bash
php artisan key:generate
```

9. Execute as migrações para configurar o banco de dados:
```bash
php artisan migrate
```

10. Inicie o servidor de desenvolvimento:
```bash
php artisan serve
```

## Acesso à aplicação

Após executar o comando `php artisan serve`, a aplicação estará disponível em [http://localhost:80](http://localhost:80).

## Observações
- Será necessário cadastra-se para utilizar a aplicação.
- Certifique-se de que as portas necessárias para o Docker e o Laravel não estejam em uso por outros serviços.
- Para quaisquer dúvidas ou problemas, consulte a documentação oficial do [Laravel](https://laravel.com/docs) ou do [Docker](https://docs.docker.com/).

# Laravel

### 1. Facilidade de Uso
O Laravel possui uma sintaxe expressiva e intuitiva, permitindo um desenvolvimento rápido e sem complicações. A estrutura organizada e os recursos como roteamento, autenticação e validação prontos para uso ajudam a manter o código limpo e fácil de manter.

### 2. Padrão Arquitetural MVC
O Laravel adota o padrão **Model-View-Controller (MVC)**, o que facilita a organização do código e promove a separação clara de responsabilidades. Isso resulta em um código mais modular, escalável e fácil de entender.

### 3. Eloquent ORM
Com o **Eloquent ORM**, o Laravel proporciona uma maneira simples e poderosa de interagir com o banco de dados. Ele permite operações complexas com o banco de dados sem a necessidade de escrever SQL complexo, acelerando o desenvolvimento e minimizando erros comuns.

### 4. Segurança
Laravel integra diversas funcionalidades de segurança, como proteção contra SQL Injection, Cross-Site Request Forgery (CSRF), Cross-Site Scripting (XSS) e muito mais. Isso torna o desenvolvimento mais seguro, reduzindo significativamente o risco de vulnerabilidades.

### SQL Injection (Injeção de SQL)

**SQL Injection** é uma vulnerabilidade de segurança que permite que um atacante insira ou "injete" código SQL malicioso em uma consulta SQL legítima. Isso ocorre quando os dados fornecidos pelo usuário (como entradas em formulários) não são devidamente validados ou filtrados antes de serem usados em uma consulta ao banco de dados.

### Como Funciona:
- O atacante pode manipular as entradas para alterar o comportamento da consulta SQL, executando comandos maliciosos no banco de dados.
- Por exemplo, se um aplicativo concatenar diretamente a entrada do usuário em uma consulta SQL sem validá-la corretamente, o atacante pode injetar comandos SQL que podem excluir, modificar ou acessar dados sem autorização.

### Exemplo:
```sql
SELECT * FROM users WHERE username = '$username' AND password = '$password'
```

## Cross-Site Request Forgery (CSRF)

**Cross-Site Request Forgery (CSRF)** é um tipo de ataque em que um atacante induz um usuário autenticado a executar ações indesejadas em um aplicativo web onde ele está autenticado. O atacante cria um pedido malicioso (por exemplo, uma solicitação de alteração de senha ou de transação) que é enviado automaticamente ao servidor sem o conhecimento ou consentimento do usuário.

### Como Funciona:
- O atacante cria um link ou script malicioso que faz uma requisição HTTP (como uma mudança de senha ou transferência de fundos) em nome do usuário autenticado.
- Como o usuário já está autenticado no aplicativo, o servidor aceita a requisição como se fosse legítima, sem que o usuário perceba.

### Exemplo:
Um atacante envia um link para o usuário, que ao clicar, faz uma requisição para transferir dinheiro da conta do usuário para a conta do atacante, sem que o usuário saiba.

### Prevenção:
- Usar **tokens CSRF**: Cada formulário enviado pelo aplicativo deve incluir um token único, que é validado pelo servidor para garantir que a requisição é legítima.
- Validar **cabeçalhos de origem** e **referenciadores** para garantir que a requisição vem do domínio esperado.

## Cross-Site Scripting (XSS)

**Cross-Site Scripting (XSS)** é um ataque onde um atacante injeta scripts maliciosos em páginas web visualizadas por outros usuários. O código malicioso é executado no navegador da vítima, o que pode permitir o roubo de dados sensíveis, como cookies de sessão ou informações de autenticação.

### Como Funciona:
- O atacante insere código JavaScript malicioso em um campo de entrada (como um formulário de comentários ou um campo de pesquisa) que é posteriormente exibido em uma página web.
- Quando outros usuários visualizam essa página, o código malicioso é executado em seu navegador, podendo roubar informações ou manipular o comportamento da página.

### Exemplo:
Um atacante pode inserir um script malicioso em um campo de comentário, como:
```html
<script>alert('XSS Attack!');</script>
```

### 5. Suporte à Testabilidade
Laravel facilita a criação de testes automatizados com integração fácil ao PHPUnit, permitindo que desenvolvedores escrevam testes unitários e de integração de forma simples. Isso garante maior confiabilidade e ajuda a manter a qualidade do código a longo prazo.

# PostgreSQL

### 1. Robustez e Escalabilidade
O PostgreSQL é um sistema de gerenciamento de banco de dados relacional altamente confiável e robusto, com suporte a grandes volumes de dados e a operações complexas. Ele é ideal para sistemas em crescimento, oferecendo alta escalabilidade sem perda de performance.

### 2. Suporte a SQL Padrão e Extensões
PostgreSQL segue rigorosamente o padrão SQL e oferece suporte a extensões, como JSONB e Full-Text Search, que permitem trabalhar com tipos de dados não relacionais e realizar buscas avançadas de forma eficiente.

### 3. Consistência e Integridade
Com suporte completo a transações ACID (Atomicidade, Consistência, Isolamento e Durabilidade), o PostgreSQL garante integridade dos dados e um ambiente seguro para realizar operações críticas.

### 4. Comunidade Ativa e Suporte
PostgreSQL tem uma comunidade muito ativa e vasta documentação, facilitando a resolução de problemas e a implementação de soluções avançadas. Além disso, sua popularidade garante um grande ecossistema de ferramentas e extensões.

### 5. Desempenho
O PostgreSQL é otimizado para consultas complexas e de alto desempenho, com suporte a índices avançados, como índices GIN, GiST e BRIN, garantindo uma performance excelente mesmo em bases de dados muito grandes.

# Docker

O **Docker** é uma plataforma open-source que automatiza o processo de construção, envio e execução de aplicações dentro de containers. Um container é uma unidade leve, portátil e autossuficiente que inclui tudo o que a aplicação precisa para rodar, como código, bibliotecas, dependências e configurações. Isso garante que a aplicação tenha o mesmo comportamento em diferentes ambientes, desde desenvolvimento até produção.

### Como o Docker Funciona

- **Container**: O container Docker é uma instância isolada que contém tudo o que a aplicação precisa para ser executada. Ele compartilha o mesmo sistema operacional do host, mas é isolado de outros containers e do próprio sistema.
  
- **Imagem**: A imagem Docker é um arquivo imutável que contém a configuração do container, incluindo o sistema operacional, dependências e o código da aplicação. As imagens podem ser versionadas e compartilhadas, facilitando a reutilização e a padronização de ambientes.

- **Docker Engine**: O Docker Engine é o motor de execução dos containers. Ele pode ser instalado em diferentes sistemas operacionais como Linux, Windows e macOS.

Utilizar o Docker oferece várias vantagens, tanto para desenvolvedores quanto para equipes de operações (DevOps):

#### 1. **Portabilidade**
- **Consistência entre ambientes**: O Docker garante que a aplicação será executada da mesma maneira em qualquer lugar, seja em máquinas locais, servidores de teste ou produção. Isso resolve problemas de inconsistência entre ambientes, como a famosa frase "funcionou na minha máquina".
- **Imagens reutilizáveis**: As imagens Docker podem ser versionadas e compartilhadas facilmente, facilitando a colaboração entre equipes e a padronização dos ambientes de desenvolvimento.

#### 2. **Isolamento**
- **Ambientes isolados**: Cada container é executado de maneira isolada, o que permite rodar múltiplos containers com diferentes versões de dependências ou até diferentes aplicações, sem interferência entre eles.
- **Redução de conflitos**: Isso evita conflitos de dependências ou versões de software entre projetos diferentes.

#### 3. **Eficiência e Escalabilidade**
- **Menor consumo de recursos**: Containers são mais leves que máquinas virtuais, pois compartilham o mesmo kernel do sistema operacional, permitindo rodar mais containers no mesmo hardware.
- **Escalabilidade facilitada**: O Docker torna fácil a criação de arquiteturas escaláveis. Ferramentas como **Docker Compose** e **Kubernetes** podem ser usadas para orquestrar containers em larga escala.

#### 4. **Automação de Desenvolvimento e Deploy**
- **Ambientes de desenvolvimento consistentes**: O Docker permite que todos os desenvolvedores tenham o mesmo ambiente, garantindo que a aplicação se comporte de maneira consistente em todas as máquinas.
- **Facilidade no deploy**: A automação de ambientes de produção e a criação de pipelines de CI/CD são facilitadas, tornando o processo de entrega de software mais rápido e confiável.

Com o Docker, as equipes podem simplificar o desenvolvimento, garantir consistência em diferentes ambientes e aumentar a eficiência de suas operações.