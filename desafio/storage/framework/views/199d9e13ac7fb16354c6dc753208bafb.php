<?php $__env->startSection('title', 'Desafio Full Stack - Grupo Adriano Cobuccio'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="bg-dark card-header text-center bg-primary text-white">
                        <h1 class="mb-0">Desafio para Full Stack</h1>
                        <h2>Grupo Adriano Cobuccio</h2>
                    </div>

                    <div class="card-body">
                        <h4>Tecnologias desejadas:</h4>
                        <ul>
                            <li>PHP</li>
                            <li>Laravel</li>
                            <li>SQL</li>
                        </ul>

                        <h4>Para o dia da entrevista técnica:</h4>
                        <ul>
                            <li>Na data marcada pelo recrutador, tenha sua aplicação rodando para a execução de testes e para apresentação do desenvolvimento.</li>
                            <li>Faremos um code review como se você já fosse do nosso time, você poderá explicar o que pensou.</li>
                        </ul>

                        <h4>Objetivo:</h4>
                        <p>O objetivo consiste na criação de uma interface funcional equivalente a uma carteira financeira, em que os usuários possam realizar transferência de saldo e depósito.</p>

                        <h4>Requisitos:</h4>
                        <ul>
                            <li>Criar cadastro</li>
                            <li>Criar autenticação</li>
                            <li>Usuários podem enviar, receber e depositar dinheiro</li>
                            <li>Validar se o usuário tem saldo antes da transferência e, caso o saldo da pessoa esteja negativo, no depósito deve acrescentar ao valor.</li>
                            <li>A operação de transferência ou depósito deve ser passível de reversão em qualquer caso de inconsistência ou por solicitação do usuário.</li>
                        </ul>

                        <h4>Avaliação:</h4>
                        <p>Apresente sua solução utilizando o framework que você desejar, justificando a escolha. Atente-se a cumprir a maioria dos requisitos, pois você pode cumpri-los parcialmente e, durante a avaliação, vamos bater um papo a respeito do que faltou.</p>

                        <h4>O que será avaliado:</h4>
                        <ul>
                            <li>Segurança</li>
                            <li>Uso de código limpo</li>
                            <li>Domínio da arquitetura</li>
                            <li>Tratamentos de erros</li>
                            <li>Saber argumentar suas escolhas</li>
                            <li>Conhecimento de padrões (design patterns, SOLID)</li>
                            <li>Modelagem de dados</li>
                        </ul>

                        <h4>O que será um diferencial:</h4>
                        <ul>
                            <li>Uso de Docker</li>
                            <li>Testes de integração</li>
                            <li>Testes unitários</li>
                            <li>Documentação</li>
                            <li>Observabilidade</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /app/resources/views/Home.blade.php ENDPATH**/ ?>