

<?php $__env->startSection('title', 'Demandes d\'accompagnement'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Demandes d'accompagnement</h1>
            <p class="text-gray-600 mt-1">
                Gestion des demandes d'accompagnement immobilier
                <?php if($pendingCount > 0): ?>
                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                        <?php echo e($pendingCount); ?> en attente
                    </span>
                <?php endif; ?>
                <?php if($processingCount > 0): ?>
                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        <?php echo e($processingCount); ?> en cours
                    </span>
                <?php endif; ?>
            </p>
        </div>
        <a href="<?php echo e(route('admin.applications.create')); ?>" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Nouvelle demande
        </a>
    </div>

    <!-- Filtres de statut -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex space-x-4">
            <a href="<?php echo e(route('admin.applications.index')); ?>" 
               class="px-4 py-2 text-sm font-medium rounded-md <?php echo e(!request('status') ? 'bg-blue-100 text-blue-700' : 'text-gray-500 hover:text-gray-700'); ?>">
                Toutes
            </a>
            <a href="<?php echo e(route('admin.applications.index', ['status' => 'pending'])); ?>" 
               class="px-4 py-2 text-sm font-medium rounded-md <?php echo e(request('status') === 'pending' ? 'bg-orange-100 text-orange-700' : 'text-gray-500 hover:text-gray-700'); ?>">
                En attente (<?php echo e($pendingCount); ?>)
            </a>
            <a href="<?php echo e(route('admin.applications.index', ['status' => 'processing'])); ?>" 
               class="px-4 py-2 text-sm font-medium rounded-md <?php echo e(request('status') === 'processing' ? 'bg-blue-100 text-blue-700' : 'text-gray-500 hover:text-gray-700'); ?>">
                En cours (<?php echo e($processingCount); ?>)
            </a>
            <a href="<?php echo e(route('admin.applications.index', ['status' => 'completed'])); ?>" 
               class="px-4 py-2 text-sm font-medium rounded-md <?php echo e(request('status') === 'completed' ? 'bg-green-100 text-green-700' : 'text-gray-500 hover:text-gray-700'); ?>">
                Terminées
            </a>
            <a href="<?php echo e(route('admin.applications.index', ['status' => 'rejected'])); ?>" 
               class="px-4 py-2 text-sm font-medium rounded-md <?php echo e(request('status') === 'rejected' ? 'bg-red-100 text-red-700' : 'text-gray-500 hover:text-gray-700'); ?>">
                Rejetées
            </a>
        </div>
    </div>

    <!-- Liste des demandes -->
    <?php if($applications->count() > 0): ?>
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Demandeur
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Projet
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Budget
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $application): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                <span class="text-sm font-medium text-gray-700">
                                                    <?php echo e(strtoupper(substr($application->first_name, 0, 1) . substr($application->last_name, 0, 1))); ?>

                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900"><?php echo e($application->fullName); ?></div>
                                            <div class="text-sm text-gray-500"><?php echo e($application->email); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?php echo e($application->property_type); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo e($application->desired_city); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo e($application->budget_range); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php switch($application->status):
                                        case ('pending'): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                En attente
                                            </span>
                                            <?php break; ?>
                                        <?php case ('processing'): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                En cours
                                            </span>
                                            <?php break; ?>
                                        <?php case ('completed'): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Terminée
                                            </span>
                                            <?php break; ?>
                                        <?php case ('rejected'): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Rejetée
                                            </span>
                                            <?php break; ?>
                                    <?php endswitch; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo e($application->created_at->format('d/m/Y H:i')); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="<?php echo e(route('admin.applications.show', $application)); ?>" 
                                           class="text-blue-600 hover:text-blue-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="<?php echo e(route('admin.applications.edit', $application)); ?>" 
                                           class="text-indigo-600 hover:text-indigo-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="<?php echo e(route('admin.applications.destroy', $application)); ?>" 
                                              method="POST" 
                                              class="inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette demande ?')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            <?php echo e($applications->links()); ?>

        </div>
    <?php else: ?>
        <div class="text-center py-12 bg-white rounded-lg shadow">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune demande</h3>
            <p class="mt-1 text-sm text-gray-500">Aucune demande d'accompagnement pour le moment.</p>
            <div class="mt-6">
                <a href="<?php echo e(route('admin.applications.create')); ?>"
                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Créer une demande de test
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\HorizonImmo\resources\views\admin\applications\index.blade.php ENDPATH**/ ?>