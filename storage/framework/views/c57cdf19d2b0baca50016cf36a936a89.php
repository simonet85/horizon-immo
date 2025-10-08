

<?php $__env->startSection('title', 'Détail du Message'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- En-tête -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Message de <?php echo e($contactMessage->full_name); ?></h1>
                <p class="text-gray-600 mt-1">Reçu le <?php echo e($contactMessage->created_at->format('d/m/Y à H:i')); ?></p>
            </div>
            <div class="flex items-center space-x-3">
                <?php if($contactMessage->admin_response): ?>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        Répondu le <?php echo e($contactMessage->responded_at->format('d/m/Y à H:i')); ?>

                    </span>
                <?php elseif($contactMessage->status === 'unread'): ?>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        Non lu
                    </span>
                <?php else: ?>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                        Lu
                    </span>
                <?php endif; ?>
                <a href="<?php echo e(route('admin.contact-messages.index')); ?>" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm">
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded" role="alert">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Contenu du message -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Message principal -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4"><?php echo e($contactMessage->subject); ?></h2>
                
                <div class="prose max-w-none">
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line"><?php echo e($contactMessage->message); ?></p>
                </div>

                <!-- Réponse admin -->
                <?php if($contactMessage->admin_response): ?>
                    <div class="mt-6 border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Réponse de l'administration</h3>
                        <div class="bg-blue-50 rounded-lg p-4">
                            <p class="text-gray-700 whitespace-pre-wrap"><?php echo e($contactMessage->admin_response); ?></p>
                            <p class="text-xs text-gray-500 mt-2">Envoyée le <?php echo e($contactMessage->responded_at->format('d/m/Y à H:i')); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Formulaire de réponse -->
                <?php if(!$contactMessage->admin_response): ?>
                    <div class="mt-6 border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Envoyer une réponse par email</h3>
                        <form action="<?php echo e(route('admin.contact-messages.respond', $contactMessage)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="mb-4">
                                <label for="admin_response" class="block text-sm font-medium text-gray-700 mb-2">
                                    Votre réponse (sera envoyée par email à <?php echo e($contactMessage->email); ?>)
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
                                    Envoyer la réponse par email
                                </button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Informations de contact -->
        <div class="space-y-6">
            <!-- Informations personnelles -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations de contact</h3>
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nom complet</label>
                        <p class="mt-1 text-sm text-gray-900"><?php echo e($contactMessage->full_name); ?></p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="mt-1 text-sm text-gray-900">
                            <a href="mailto:<?php echo e($contactMessage->email); ?>" class="text-blue-600 hover:text-blue-800">
                                <?php echo e($contactMessage->email); ?>

                            </a>
                        </p>
                    </div>
                    
                    <?php if($contactMessage->phone): ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                            <p class="mt-1 text-sm text-gray-900">
                                <a href="tel:<?php echo e($contactMessage->phone); ?>" class="text-blue-600 hover:text-blue-800">
                                    <?php echo e($contactMessage->phone); ?>

                                </a>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                
                <div class="space-y-3">
                    <?php if($contactMessage->admin_response): ?>
                        <div class="w-full bg-green-100 text-green-800 px-4 py-2 rounded-lg text-sm text-center">
                            Réponse envoyée le <?php echo e($contactMessage->responded_at->format('d/m/Y à H:i')); ?>

                        </div>
                    <?php else: ?>
                        <?php if($contactMessage->status === 'unread'): ?>
                            <a href="<?php echo e(route('admin.contact-messages.mark-read', $contactMessage)); ?>" 
                               class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm text-center block">
                                Marquer comme lu
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('admin.contact-messages.mark-unread', $contactMessage)); ?>" 
                               class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-sm text-center block">
                                Marquer comme non lu
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <a href="mailto:<?php echo e($contactMessage->email); ?>?subject=Re: <?php echo e($contactMessage->subject); ?>" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm text-center block">
                        Répondre par email
                    </a>
                    
                    <form method="POST" action="<?php echo e(route('admin.contact-messages.destroy', $contactMessage)); ?>" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm">
                            Supprimer le message
                        </button>
                    </form>
                </div>
            </div>

            <!-- Métadonnées -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Détails</h3>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Date de réception:</span>
                        <span class="text-gray-900"><?php echo e($contactMessage->created_at->format('d/m/Y H:i')); ?></span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Statut:</span>
                        <span class="text-gray-900">
                            <?php if($contactMessage->admin_response): ?>
                                Répondu
                            <?php else: ?>
                                <?php echo e($contactMessage->status === 'unread' ? 'Non lu' : 'Lu'); ?>

                            <?php endif; ?>
                        </span>
                    </div>
                    
                    <?php if($contactMessage->updated_at != $contactMessage->created_at): ?>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Dernière modification:</span>
                            <span class="text-gray-900"><?php echo e($contactMessage->updated_at->format('d/m/Y H:i')); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\HorizonImmo\resources\views\admin\contact-messages\show.blade.php ENDPATH**/ ?>