

<?php $__env->startSection('title', 'Message sur propriété'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Message sur propriété</h1>
                <a href="<?php echo e(route('client.messages.index')); ?>" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm">
                    Retour à mes messages
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 text-gray-900">
                    <!-- En-tête du message -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900"><?php echo e($message->subject); ?></h1>
                                <p class="text-gray-600 mt-1">Envoyé le <?php echo e($message->created_at->format('d/m/Y à H:i')); ?></p>
                            </div>
                            <div class="flex flex-col items-end space-y-2">
                                <?php if($message->admin_response): ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        Répondu le <?php echo e($message->responded_at->format('d/m/Y à H:i')); ?>

                                    </span>
                                <?php elseif($message->is_read): ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        Lu le <?php echo e($message->read_at->format('d/m/Y à H:i')); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                        Non lu
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Informations sur la propriété -->
                    <?php if($message->property): ?>
                        <div class="bg-blue-50 rounded-lg p-6 mb-6">
                            <h3 class="text-lg font-semibold text-blue-900 mb-3">Propriété concernée</h3>
                            <div class="flex items-start space-x-4">
                                <?php if($message->property->images && count($message->property->images) > 0): ?>
                                    <img src="<?php echo e(Storage::url($message->property->images[0])); ?>" 
                                         alt="<?php echo e($message->property->title); ?>"
                                         class="w-24 h-24 object-cover rounded-lg">
                                <?php endif; ?>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900"><?php echo e($message->property->title); ?></h4>
                                    <p class="text-gray-600 mt-1"><?php echo e($message->property->address); ?></p>
                                    <p class="text-lg font-semibold text-blue-600 mt-2">
                                        <?php echo e(number_format($message->property->price, 0, ',', ' ')); ?> €
                                    </p>
                                    <a href="<?php echo e(route('property.detail', $message->property->id)); ?>" 
                                       class="inline-flex items-center mt-3 text-blue-600 hover:text-blue-800">
                                        Voir la propriété
                                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Votre message -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Votre message</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700 whitespace-pre-wrap"><?php echo e($message->message); ?></p>
                        </div>
                    </div>

                    <!-- Réponse de l'équipe (si disponible) -->
                    <?php if($message->admin_response): ?>
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Réponse de notre équipe</h3>
                            <div class="bg-green-50 rounded-lg p-4">
                                <p class="text-gray-700 whitespace-pre-wrap"><?php echo e($message->admin_response); ?></p>
                                <p class="text-sm text-gray-500 mt-3">
                                    Répondu le <?php echo e($message->responded_at->format('d/m/Y à H:i')); ?>

                                </p>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="border-t pt-6">
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="text-yellow-800">
                                        Notre équipe traite votre message. Vous recevrez une réponse par email dès que possible.
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Informations de contact -->
                    <div class="mt-8 border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Vos informations de contact</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="mt-1 text-sm text-gray-900"><?php echo e($message->email); ?></p>
                            </div>
                            <?php if($message->phone): ?>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                                    <p class="mt-1 text-sm text-gray-900"><?php echo e($message->phone); ?></p>
                                </div>
                            <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\HorizonImmo\resources\views\client\messages\show.blade.php ENDPATH**/ ?>