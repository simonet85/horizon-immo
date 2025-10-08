

<?php $__env->startSection('title', 'Détails de la demande'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <a href="<?php echo e(route('client.applications.index')); ?>" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                ← Retour aux applications
            </a>
            <div class="flex justify-between items-start mt-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Demande d'accompagnement</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                        Soumise le <?php echo e($application->created_at->format('d/m/Y à H:i')); ?>

                    </p>
                </div>
                <div class="flex items-center space-x-4">
                    <?php switch($application->status):
                        case ('pending'): ?>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                En attente
                            </span>
                            <?php break; ?>
                        <?php case ('approved'): ?>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                Approuvée
                            </span>
                            <?php break; ?>
                        <?php case ('rejected'): ?>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                Refusée
                            </span>
                            <?php break; ?>
                    <?php endswitch; ?>

                    <?php if($application->status === 'pending'): ?>
                        <div class="flex space-x-2">
                            <a href="<?php echo e(route('client.applications.edit', $application)); ?>" 
                               class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                Modifier
                            </a>
                            <form action="<?php echo e(route('client.applications.destroy', $application)); ?>" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette demande ?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" 
                                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <!-- Informations personnelles -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Informations personnelles</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nom complet</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white"><?php echo e($application->first_name); ?> <?php echo e($application->last_name); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Email</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white"><?php echo e($application->email); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Pays de résidence</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white"><?php echo e($application->country_residence); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Âge</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white"><?php echo e($application->age); ?> ans</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Profession</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white"><?php echo e($application->profession); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Téléphone</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white"><?php echo e($application->phone); ?></p>
                    </div>
                </div>
            </div>

            <!-- Projet immobilier -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Projet immobilier</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Ville désirée</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white"><?php echo e($application->desired_city); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Type de bien</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white"><?php echo e($application->property_type); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Budget</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white"><?php echo e($application->budget_range); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Apport personnel</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white"><?php echo e($application->personal_contribution_percentage); ?>%</p>
                    </div>
                </div>
            </div>

            <!-- Informations complémentaires -->
            <?php if($application->additional_info || $application->message): ?>
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Informations complémentaires</h2>
                    
                    <?php if($application->additional_info): ?>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Informations supplémentaires</label>
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-md">
                                <p class="text-sm text-gray-900 dark:text-white whitespace-pre-wrap"><?php echo e($application->additional_info); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($application->message): ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Message personnel</label>
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-md">
                                <p class="text-sm text-gray-900 dark:text-white whitespace-pre-wrap"><?php echo e($application->message); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Réponse administrative -->
            <?php if($application->admin_response): ?>
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Réponse de l'administration</h2>
                    <div class="p-4 rounded-md <?php echo e($application->status === 'approved' ? 'bg-green-50 dark:bg-green-900/20' : 'bg-red-50 dark:bg-red-900/20'); ?>">
                        <p class="text-sm <?php echo e($application->status === 'approved' ? 'text-green-900 dark:text-green-100' : 'text-red-900 dark:text-red-100'); ?> whitespace-pre-wrap"><?php echo e($application->admin_response); ?></p>
                        <?php if($application->updated_at != $application->created_at): ?>
                            <p class="text-xs <?php echo e($application->status === 'approved' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'); ?> mt-2">
                                Répondu le <?php echo e($application->updated_at->format('d/m/Y à H:i')); ?>

                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Timeline des événements -->
        <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Historique</h2>
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Demande soumise</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($application->created_at->format('d/m/Y à H:i')); ?></p>
                    </div>
                </div>

                <?php if($application->updated_at != $application->created_at && $application->admin_response): ?>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 <?php echo e($application->status === 'approved' ? 'bg-green-100' : 'bg-red-100'); ?> rounded-full flex items-center justify-center">
                                <?php if($application->status === 'approved'): ?>
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                <?php else: ?>
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                Demande <?php echo e($application->status === 'approved' ? 'approuvée' : 'refusée'); ?>

                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($application->updated_at->format('d/m/Y à H:i')); ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\HorizonImmo\resources\views\client\applications\show.blade.php ENDPATH**/ ?>