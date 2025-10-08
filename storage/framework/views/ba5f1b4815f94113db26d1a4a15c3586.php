

<?php $__env->startSection('title', 'Message de ' . $message->name); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Message de <?php echo e($message->name); ?></h1>
            <p class="text-gray-600 mt-1">Détails du message de contact</p>
        </div>
        <div class="flex space-x-2">
            <a href="<?php echo e(route('admin.messages.edit', $message)); ?>" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                Modifier
            </a>
            <a href="<?php echo e(route('admin.messages.index')); ?>" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium">
                Retour
            </a>
        </div>
    </div>
    <!-- Contenu du message -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
                    <!-- Informations du message -->
                    <div class="mb-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nom</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($message->name); ?></dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <a href="mailto:<?php echo e($message->email); ?>" class="text-blue-600 hover:text-blue-500">
                                        <?php echo e($message->email); ?>

                                    </a>
                                </dd>
                            </div>
                            <?php if($message->phone): ?>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Téléphone</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <a href="tel:<?php echo e($message->phone); ?>" class="text-blue-600 hover:text-blue-500">
                                            <?php echo e($message->phone); ?>

                                        </a>
                                    </dd>
                                </div>
                            <?php endif; ?>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Date de réception</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($message->created_at->format('d/m/Y à H:i')); ?></dd>
                            </div>
                            <?php if($message->property): ?>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Propriété concernée</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <a href="<?php echo e(route('admin.properties.show', $message->property)); ?>" class="text-blue-600 hover:text-blue-500">
                                            <?php echo e($message->property->title); ?>

                                        </a>
                                    </dd>
                                </div>
                            <?php endif; ?>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Statut</dt>
                                <dd class="mt-1">
                                    <?php if($message->admin_response): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Répondu le <?php echo e($message->responded_at->format('d/m/Y à H:i')); ?>

                                        </span>
                                    <?php elseif($message->is_read): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Lu le <?php echo e($message->read_at->format('d/m/Y à H:i')); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Non lu
                                        </span>
                                    <?php endif; ?>
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Sujet -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Sujet</h3>
                        <p class="text-gray-700"><?php echo e($message->subject); ?></p>
                    </div>

                    <!-- Message -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Message</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700 whitespace-pre-wrap"><?php echo e($message->message); ?></p>
                        </div>
                    </div>

                    <!-- Réponse admin -->
                    <?php if($message->admin_response): ?>
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Réponse de l'administration</h3>
                            <div class="bg-blue-50 rounded-lg p-4">
                                <p class="text-gray-700 whitespace-pre-wrap"><?php echo e($message->admin_response); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Formulaire de réponse -->
                    <?php if(!$message->admin_response): ?>
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Ajouter une réponse</h3>
                            <form action="<?php echo e(route('admin.messages.respond', $message)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="mb-4">
                                    <label for="admin_response" class="block text-sm font-medium text-gray-700 mb-2">
                                        Votre réponse
                                    </label>
                                    <textarea name="admin_response" 
                                              id="admin_response" 
                                              rows="6" 
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Tapez votre réponse ici..."></textarea>
                                    <?php $__errorArgs = ['admin_response'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Envoyer la réponse
                                    </button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\HorizonImmo\resources\views\admin\messages\show.blade.php ENDPATH**/ ?>