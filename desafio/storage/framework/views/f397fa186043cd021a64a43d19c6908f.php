<?php $__env->startSection('title', 'Conta Bancária'); ?>

<?php $__env->startSection('content'); ?>

<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<?php if(session('warning')): ?>
    <div class="alert alert-warning">
        <?php echo e(session('warning')); ?>

    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

<?php if(session('success')): ?>
    <div class="alert alert-success">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Minhas Contas Bancárias</h1>
        
        <form action="<?php echo e(route('conta.criar')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-info btn-sm">Cadastrar Nova Conta</button>
        </form>
    </div>

    <?php if(sizeof($contas) == 0): ?>
        <div class="alert alert-info text-center">
            Não existem contas cadastradas.
        </div>
    <?php else: ?>
        <div class="list-group">
            <?php $__currentLoopData = $contas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="list-group-item d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Código da Conta: <?php echo e($conta->conta_id); ?></h5>
                            <p><strong>Saldo Atual:</strong> R$ <?php echo e(number_format($conta->saldo, 2, ',', '.')); ?></p>
                        </div>

                        <div>
                            <!-- Botões de Ação -->
                            <button class="btn btn-success btn-sm btn-transferir" data-id="<?php echo e($conta->conta_id); ?>">Transferir</button>
                            <button class="btn btn-success btn-sm btn-depositar" data-id="<?php echo e($conta->conta_id); ?>">Depositar</button>
                            <a href="<?php echo e(route('transferencia.index', ['conta_id' => $conta->conta_id])); ?>" class="btn btn-warning btn-sm">Visualizar operações</a>
                        </div>
                    </div>

                    <!-- Formulário de depósito -->
                    <form action="<?php echo e(route('transferencia.depositar')); ?>" method="POST" class="deposito-form" style="display: none;">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" value="<?php echo e($conta->conta_id); ?>">
                        <h4>Depositar R$</h4>
                        <div class="d-flex gap-2">
                            <input type="number" name="valor" placeholder="Informe o valor do depósito" class="form-control form-control-sm" step="0.01" min="0.01" required>
                            <button type="submit" class="btn btn-sm btn-success">Confirmar</button>
                            <button type="button" class="btn btn-sm btn-danger btn-cancelar">Cancelar</button>
                        </div>
                    </form>

                    <!-- Formulário de transferência -->
                    <form action="<?php echo e(route('transferencia.transferir', ['conta_id' => $conta->conta_id])); ?>" method="POST" class="transferir-form" style="display: none;">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="origem_conta_id" value="<?php echo e($conta->conta_id); ?>">
                        
                        <h4>Transferir R$</h4>
                        <div class="d-flex gap-2">
                            <input type="number" name="destino_conta_id" placeholder="Código da conta destino" class="form-control form-control-sm" step="1" min="1" required>
                            <input type="number" name="valor" placeholder="Informe o valor da transferência" class="form-control form-control-sm" step="0.01" min="0.01" required>
                            <input type="number" name="usuario_codigo" placeholder="Código do usuário externo (opcional)" class="form-control form-control-sm" step="1" min="1">
                            <button type="submit" class="btn btn-sm btn-success">Confirmar Transferência</button>
                            <button type="button" class="btn btn-sm btn-danger btn-cancelar">Cancelar</button>
                        </div>
                    </form>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>

<script>
    // Mostrar/Esconder o formulário de depósito
    document.querySelectorAll('.btn-depositar').forEach(button => {
        button.addEventListener('click', function () {
            const parent = this.closest('.list-group-item');
            const depositoForm = parent.querySelector('.deposito-form');
            depositoForm.style.display = depositoForm.style.display === 'none' ? 'block' : 'none';
            const transferirForm = parent.querySelector('.transferir-form');
            if (transferirForm) transferirForm.style.display = 'none';
        });
    });

    // Mostrar/Esconder o formulário de transferência
    document.querySelectorAll('.btn-transferir').forEach(button => {
        button.addEventListener('click', function () {
            const parent = this.closest('.list-group-item');
            const transferirForm = parent.querySelector('.transferir-form');
            transferirForm.style.display = transferirForm.style.display === 'none' ? 'block' : 'none';
            const depositoForm = parent.querySelector('.deposito-form');
            if (depositoForm) depositoForm.style.display = 'none';
        });
    });

    // Ação para cancelar e esconder o formulário
    document.querySelectorAll('.btn-cancelar').forEach(button => {
        button.addEventListener('click', function () {
            const parent = this.closest('.list-group-item');
            const depositoForm = parent.querySelector('.deposito-form');
            const transferirForm = parent.querySelector('.transferir-form');
            if (depositoForm) depositoForm.style.display = 'none';
            if (transferirForm) transferirForm.style.display = 'none';
        });
    });

</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /app/resources/views/conta.blade.php ENDPATH**/ ?>