

<?php $__env->startSection('title', 'Mes Messages'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Mes Messages</h1>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <div class="p-6 text-gray-900">
                    <!-- Statistiques -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-blue-50 p-6 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-800">Messages sur propriétés</h3>
                                    <p class="text-gray-600"><?php echo e($propertyMessages->count()); ?> message(s)</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-green-50 p-6 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-800">Messages de contact</h3>
                                    <p class="text-gray-600"><?php echo e($contactMessages->count()); ?> message(s)</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-yellow-50 p-6 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-800">Réponses reçues</h3>
                                    <p class="text-gray-600"><?php echo e($propertyMessages->whereNotNull('admin_response')->count() + $contactMessages->whereNotNull('admin_response')->count()); ?> réponse(s)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Messages sur propriétés -->
                    <?php if($propertyMessages->count() > 0): ?>
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Messages sur les propriétés</h3>
                            <div class="space-y-4">
                                <?php $__currentLoopData = $propertyMessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <div class="flex items-center mb-2">
                                                    <h4 class="font-semibold text-gray-800"><?php echo e($message->subject); ?></h4>
                                                    <?php if($message->admin_response): ?>
                                                        <span class="ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                                            Répondu
                                                        </span>
                                                    <?php elseif($message->is_read): ?>
                                                        <span class="ml-2 px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                                            Lu
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="ml-2 px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">
                                                            Non lu
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                <?php if($message->property): ?>
                                                    <p class="text-sm text-gray-600 mb-2">
                                                        <strong>Propriété:</strong> <?php echo e($message->property->title); ?>

                                                    </p>
                                                <?php endif; ?>
                                                <p class="text-gray-600 mb-2"><?php echo e(Str::limit($message->message, 100)); ?></p>
                                                <p class="text-sm text-gray-500"><?php echo e($message->created_at->format('d/m/Y à H:i')); ?></p>
                                            </div>
                                            <div class="ml-4">
                                                <a href="<?php echo e(route('client.messages.show', $message)); ?>" 
                                                   class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition ease-in-out duration-150">
                                                    Voir
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Messages de contact -->
                    <?php if($contactMessages->count() > 0): ?>
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Messages de contact général</h3>
                            <div class="space-y-4">
                                <?php $__currentLoopData = $contactMessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contactMessage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <div class="flex items-center mb-2">
                                                    <h4 class="font-semibold text-gray-800"><?php echo e($contactMessage->subject); ?></h4>
                                                    <?php if($contactMessage->admin_response): ?>
                                                        <span class="ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                                            Répondu
                                                        </span>
                                                    <?php elseif($contactMessage->status === 'read'): ?>
                                                        <span class="ml-2 px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                                            Lu
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="ml-2 px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">
                                                            Non lu
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                <p class="text-gray-600 mb-2"><?php echo e(Str::limit($contactMessage->message, 100)); ?></p>
                                                <p class="text-sm text-gray-500"><?php echo e($contactMessage->created_at->format('d/m/Y à H:i')); ?></p>
                                            </div>
                                            <div class="ml-4">
                                                <a href="<?php echo e(route('client.contact-messages.show', $contactMessage)); ?>" 
                                                   class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition ease-in-out duration-150">
                                                    Voir
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($propertyMessages->count() === 0 && $contactMessages->count() === 0): ?>
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun message</h3>
                            <p class="mt-1 text-sm text-gray-500">Vous n'avez encore envoyé aucun message.</p>
                            <div class="mt-6">
                                <a href="<?php echo e(route('contact')); ?>" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Nous contacter
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\HorizonImmo\resources\views\client\messages\index.blade.php ENDPATH**/ ?>