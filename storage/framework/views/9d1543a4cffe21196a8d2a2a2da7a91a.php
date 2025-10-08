

<?php $__env->startSection('title', 'Détail demande d\'accompagnement #' . $application->id); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- En-tête avec navigation -->
    <div class="flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <a href="<?php echo e(route('admin.applications.index')); ?>" 
               class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Demande #<?php echo e($application->id); ?></h1>
                <p class="text-gray-600 mt-1"><?php echo e($application->fullName); ?> - <?php echo e($application->created_at->format('d/m/Y H:i')); ?></p>
            </div>
        </div>
        <div class="flex space-x-3">
            <a href="<?php echo e(route('admin.applications.edit', $application)); ?>" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Modifier
            </a>
            <form action="<?php echo e(route('admin.applications.destroy', $application)); ?>" 
                  method="POST" 
                  class="inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" 
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium flex items-center"
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette demande ?')">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Supprimer
                </button>
            </form>
        </div>
    </div>

    <!-- Statut et actions rapides -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-700">Statut actuel :</span>
                <?php switch($application->status):
                    case ('pending'): ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                            En attente
                        </span>
                        <?php break; ?>
                    <?php case ('processing'): ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            En cours
                        </span>
                        <?php break; ?>
                    <?php case ('completed'): ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Terminée
                        </span>
                        <?php break; ?>
                    <?php case ('rejected'): ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            Rejetée
                        </span>
                        <?php break; ?>
                <?php endswitch; ?>
            </div>
            
            <!-- Actions de changement de statut -->
            <div class="flex space-x-2">
                <?php if($application->status !== 'processing'): ?>
                    <form action="<?php echo e(route('admin.applications.update-status', $application)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <input type="hidden" name="status" value="processing">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                            Marquer en cours
                        </button>
                    </form>
                <?php endif; ?>
                
                <?php if($application->status !== 'completed'): ?>
                    <form action="<?php echo e(route('admin.applications.update-status', $application)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                            Marquer terminée
                        </button>
                    </form>
                <?php endif; ?>
                
                <?php if($application->status !== 'rejected'): ?>
                    <form action="<?php echo e(route('admin.applications.update-status', $application)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm"
                                onclick="return confirm('Êtes-vous sûr de vouloir rejeter cette demande ?')">
                            Rejeter
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Informations personnelles -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Informations personnelles</h2>
        </div>
        <div class="px-6 py-4">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nom complet</dt>
                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($application->fullName); ?></dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <a href="mailto:<?php echo e($application->email); ?>" class="text-blue-600 hover:text-blue-700">
                            <?php echo e($application->email); ?>

                        </a>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Téléphone</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <?php if($application->phone): ?>
                            <a href="tel:<?php echo e($application->phone); ?>" class="text-blue-600 hover:text-blue-700">
                                <?php echo e($application->phone); ?>

                            </a>
                        <?php else: ?>
                            <span class="text-gray-400">Non renseigné</span>
                        <?php endif; ?>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Âge</dt>
                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($application->age ?? 'Non renseigné'); ?></dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Pays de résidence</dt>
                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($application->country_residence ?? 'Non renseigné'); ?></dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Profession</dt>
                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($application->profession ?? 'Non renseignée'); ?></dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Projet immobilier -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Projet immobilier</h2>
        </div>
        <div class="px-6 py-4">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Type de bien</dt>
                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($application->property_type ?? 'Non renseigné'); ?></dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Ville souhaitée</dt>
                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($application->desired_city ?? 'Non renseignée'); ?></dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Budget</dt>
                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($application->budget_range ?? 'Non renseigné'); ?></dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Type d'investissement</dt>
                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($application->investment_type ?? 'Non renseigné'); ?></dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Situation financière</dt>
                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($application->financial_situation ?? 'Non renseignée'); ?></dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Objectif d'investissement</dt>
                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($application->investment_goal ?? 'Non renseigné'); ?></dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Informations complémentaires -->
    <?php if($application->message): ?>
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Message du demandeur</h2>
            </div>
            <div class="px-6 py-4">
                <p class="text-sm text-gray-900 whitespace-pre-wrap"><?php echo e($application->message); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Métadonnées -->
    <div class="bg-gray-50 rounded-lg p-4">
        <dl class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-2 text-sm">
            <div>
                <dt class="font-medium text-gray-500">Créée le</dt>
                <dd class="text-gray-900"><?php echo e($application->created_at->format('d/m/Y à H:i')); ?></dd>
            </div>
            <div>
                <dt class="font-medium text-gray-500">Dernière modification</dt>
                <dd class="text-gray-900"><?php echo e($application->updated_at->format('d/m/Y à H:i')); ?></dd>
            </div>
            <div>
                <dt class="font-medium text-gray-500">ID de la demande</dt>
                <dd class="text-gray-900">#<?php echo e($application->id); ?></dd>
            </div>
        </dl>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\HorizonImmo\resources\views\admin\applications\show.blade.php ENDPATH**/ ?>