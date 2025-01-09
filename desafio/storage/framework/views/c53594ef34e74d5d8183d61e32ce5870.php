

<?php $__env->startSection('title', 'Transferências Bancárias'); ?>

<?php $__env->startSection('content'); ?>
    <?php if(sizeof($transferencias) == 0): ?>
        <div class="alert alert-info text-center">
            Não existem transferências cadastradas para essa conta.
        </div>
    <?php else: ?>
        <div class="list-group">
            <?php $__currentLoopData = $transferencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transferencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <?php if(!$transferencia->conta_id_envio): ?>
                        <div>
                            <h5>Deposito</h5>
                            <p><strong>Conta de destino:</strong> <?php echo e($transferencia->conta_id_recebimento); ?></p>
                            <p><strong>Valor da transferência:</strong> R$ <?php echo e(number_format($transferencia->saldo_transferencia, 2, ',', '.')); ?></p>
                        </div>
                        <div>
                            <form action="<?php echo e(route('transferencia.desfazer', $transferencia->transferencia_id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-danger btn-sm">Desfazer</button>
                            </form>
                        </div>
                    <?php else: ?>
                        <div>
                            <h5>Transferência</h5>
                            <p><strong>Conta de origem:</strong> <?php echo e($transferencia->conta_id_envio); ?></p>
                            <p><strong>Conta de destino:</strong> <?php echo e($transferencia->conta_id_recebimento); ?></p>
                            <p><strong>Valor da transferência:</strong> R$ <?php echo e(number_format($transferencia->saldo_transferencia, 2, ',', '.')); ?></p>
                        </div>
                        <div>
                            <form action="<?php echo e(route('transferencia.desfazer', $transferencia->transferencia_id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-danger btn-sm">Desfazer</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        .list-group-item {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            padding: 15px;
            border-radius: 8px;
        }

        .list-group-item:hover {
            background-color: #e9ecef;
        }

        .list-group-item p {
            margin: 5px 0;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /app/resources/views/Transferencia.blade.php ENDPATH**/ ?>