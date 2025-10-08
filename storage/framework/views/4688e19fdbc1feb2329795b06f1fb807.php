

<?php $__env->startSection('title', 'Détails de l\'Utilisateur'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="<?php echo e(route('admin.users.index')); ?>" 
               class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900"><?php echo e($user->name); ?></h1>
                <p class="text-gray-600 mt-1">Détails de l'utilisateur</p>
            </div>
        </div>
        <div class="flex space-x-3">
            <a href="<?php echo e(route('admin.users.edit', $user)); ?>" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Modifier
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informations principales -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informations personnelles -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Informations personnelles</h2>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 h-16 w-16">
                            <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center">
                                <span class="text-xl font-medium text-gray-700">
                                    <?php echo e(strtoupper(substr($user->name, 0, 2))); ?>

                                </span>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900"><?php echo e($user->name); ?></h3>
                            <p class="text-sm text-gray-500">ID: <?php echo e($user->id); ?></p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Email</label>
                            <p class="mt-1 text-sm text-gray-900"><?php echo e($user->email); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Statut de vérification</label>
                            <p class="mt-1">
                                <?php if($user->email_verified_at): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        ✓ Email vérifié
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        ✗ Email non vérifié
                                    </span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Date de création</label>
                            <p class="mt-1 text-sm text-gray-900"><?php echo e($user->created_at->format('d/m/Y à H:i')); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Dernière modification</label>
                            <p class="mt-1 text-sm text-gray-900"><?php echo e($user->updated_at->format('d/m/Y à H:i')); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permissions directes -->
            <?php if($user->permissions->count() > 0): ?>
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Permissions directes</h2>
                    <p class="text-sm text-gray-500">Permissions assignées directement à cet utilisateur</p>
                </div>
                <div class="px-6 py-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        <?php $__currentLoopData = $user->permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="inline-flex items-center px-3 py-2 rounded-md text-sm font-medium bg-blue-100 text-blue-800">
                                <?php echo e($permission->name); ?>

                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Rôles -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Rôles</h2>
                </div>
                <div class="px-6 py-4">
                    <?php if($user->roles->count() > 0): ?>
                        <div class="space-y-2">
                            <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900"><?php echo e(ucfirst($role->name)); ?></h4>
                                        <p class="text-xs text-gray-500">
                                            <?php if($role->name === 'admin'): ?>
                                                Accès administrateur complet
                                            <?php elseif($role->name === 'client'): ?>
                                                Accès client standard
                                            <?php else: ?>
                                                Rôle personnalisé
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        <?php echo e($role->name === 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800'); ?>">
                                        <?php echo e(ucfirst($role->name)); ?>

                                    </span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-sm text-gray-500 text-center py-4">Aucun rôle assigné</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Actions rapides</h2>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <a href="<?php echo e(route('admin.users.edit', $user)); ?>" 
                       class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Modifier l'utilisateur
                    </a>
                    
                    <?php if(!$user->email_verified_at): ?>
                    <button type="button" 
                            class="w-full flex items-center justify-center px-4 py-2 border border-green-300 rounded-md text-sm font-medium text-green-700 hover:bg-green-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Vérifier l'email
                    </button>
                    <?php endif; ?>
                    
                    <?php
                        $isCurrentUser = $user->id === auth()->id();
                        $adminUsers = \App\Models\User::role('admin')->get();
                        $isLastAdmin = $user->hasRole('admin') && $adminUsers->count() <= 1;
                        $canDelete = !$isCurrentUser && !$isLastAdmin;
                    ?>
                    
                    <?php if($canDelete): ?>
                        <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST" class="w-full">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" 
                                    class="w-full flex items-center justify-center px-4 py-2 border border-red-300 rounded-md text-sm font-medium text-red-700 hover:bg-red-50"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Supprimer l'utilisateur
                            </button>
                        </form>
                    <?php else: ?>
                        <div class="w-full flex items-center justify-center px-4 py-2 border border-gray-200 rounded-md text-sm font-medium text-gray-400 bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                            </svg>
                            <?php if($isCurrentUser): ?>
                                Vous ne pouvez pas supprimer votre propre compte
                            <?php elseif($isLastAdmin): ?>
                                Dernier administrateur du système
                            <?php else: ?>
                                Suppression non autorisée
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\HorizonImmo\resources\views\admin\users\show.blade.php ENDPATH**/ ?>