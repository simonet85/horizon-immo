

<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- En-tête -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Dashboard Administrateur</h1>
                <p class="text-gray-600 mt-1">Aperçu général de l'activité de la plateforme</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Dernière mise à jour</p>
                <p class="text-lg font-semibold text-gray-900"><?php echo e(now()->format('d/m/Y H:i')); ?></p>
            </div>
        </div>
    </div>

    <!-- Cartes statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Propriétés -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Propriétés</p>
                    <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['total_properties']); ?></p>
                    <p class="text-sm text-green-600"><?php echo e($stats['available_properties']); ?> disponibles</p>
                </div>
            </div>
        </div>

        <!-- Utilisateurs -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-2.239"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Utilisateurs</p>
                    <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['total_users']); ?></p>
                    <p class="text-sm text-blue-600"><?php echo e($stats['client_users']); ?> clients</p>
                </div>
            </div>
        </div>

        <!-- Messages -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Messages</p>
                    <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['unread_messages']); ?></p>
                    <p class="text-sm text-yellow-600">Non lus</p>
                </div>
            </div>
        </div>

        <!-- Applications -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Applications</p>
                    <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['pending_applications']); ?></p>
                    <p class="text-sm text-purple-600">En attente</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques et activité récente -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Graphique d'activité -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Activité sur 6 mois</h3>
            <canvas id="activityChart" width="400" height="200"></canvas>
        </div>

        <!-- Propriétés récentes -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Propriétés récentes</h3>
                <a href="<?php echo e(route('admin.properties.index')); ?>" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Voir tout
                </a>
            </div>
            <div class="space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $recentProperties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0">
                            <?php if($property->image): ?>
                                <img src="<?php echo e(Storage::url($property->image)); ?>" alt="<?php echo e($property->title); ?>" class="w-12 h-12 rounded-lg object-cover">
                            <?php else: ?>
                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-gray-900"><?php echo e(Str::limit($property->title, 40)); ?></p>
                            <p class="text-sm text-gray-500"><?php echo e(number_format($property->price, 0, ',', ' ')); ?> €</p>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                <?php echo e($property->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                <?php echo e($property->status === 'available' ? 'Disponible' : 'Vendu'); ?>

                            </span>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-center py-4">Aucune propriété récente</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Messages et Applications récents -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Messages récents -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Messages récents</h3>
                <a href="<?php echo e(route('admin.messages.index')); ?>" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Voir tout
                </a>
            </div>
            <div class="space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $recentMessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-start p-3 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 <?php echo e($message->type === 'contact' ? 'bg-blue-100' : 'bg-green-100'); ?> rounded-full flex items-center justify-center">
                                <span class="<?php echo e($message->type === 'contact' ? 'text-blue-600' : 'text-green-600'); ?> font-medium text-sm">
                                    <?php if($message->type === 'contact'): ?>
                                        <?php echo e(substr($message->name ?? 'U', 0, 1)); ?>

                                    <?php else: ?>
                                        <?php echo e(substr($message->name ?? ($message->user->name ?? 'U'), 0, 1)); ?>

                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                        <div class="ml-3 flex-1">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-900">
                                    <?php if($message->type === 'contact'): ?>
                                        <?php echo e($message->name ?? 'Contact anonyme'); ?>

                                    <?php else: ?>
                                        <?php echo e($message->name ?? $message->user->name ?? 'Utilisateur'); ?>

                                    <?php endif; ?>
                                </p>
                                <span class="text-xs px-2 py-1 rounded-full <?php echo e($message->type === 'contact' ? 'bg-blue-100 text-blue-600' : 'bg-green-100 text-green-600'); ?>">
                                    <?php echo e($message->type === 'contact' ? 'Contact' : 'Propriété'); ?>

                                </span>
                            </div>
                            <p class="text-sm text-gray-500"><?php echo e(Str::limit($message->message, 50)); ?></p>
                            <?php if($message->type === 'property' && $message->property): ?>
                                <p class="text-xs text-gray-400"><?php echo e($message->property->title); ?></p>
                            <?php endif; ?>
                            <p class="text-xs text-gray-400 mt-1"><?php echo e($message->created_at->diffForHumans()); ?></p>
                        </div>
                        <?php if(($message->type === 'contact' && $message->status === 'unread') || 
                            ($message->type === 'property' && !$message->is_read)): ?>
                            <div class="flex-shrink-0">
                                <span class="inline-block w-2 h-2 bg-red-500 rounded-full"></span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-center py-4">Aucun message récent</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Applications récentes -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Applications récentes</h3>
                <a href="<?php echo e(route('admin.applications.index')); ?>" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Voir tout
                </a>
            </div>
            <div class="space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $recentApplications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $application): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-start p-3 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                <span class="text-purple-600 font-medium text-sm">
                                    <?php echo e(substr($application->name, 0, 1)); ?>

                                </span>
                            </div>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-gray-900"><?php echo e($application->name); ?></p>
                            <p class="text-sm text-gray-500"><?php echo e($application->budget_range); ?></p>
                            <p class="text-xs text-gray-400 mt-1"><?php echo e($application->created_at->diffForHumans()); ?></p>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                <?php echo e($application->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($application->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')); ?>">
                                <?php echo e(ucfirst($application->status)); ?>

                            </span>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-center py-4">Aucune application récente</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Graphique d'activité
const ctx = document.getElementById('activityChart').getContext('2d');
const activityChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($monthlyStats['months'], 15, 512) ?>,
        datasets: [
            {
                label: 'Propriétés',
                data: <?php echo json_encode($monthlyStats['properties'], 15, 512) ?>,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4
            },
            {
                label: 'Messages',
                data: <?php echo json_encode($monthlyStats['messages'], 15, 512) ?>,
                borderColor: 'rgb(245, 158, 11)',
                backgroundColor: 'rgba(245, 158, 11, 0.1)',
                tension: 0.4
            },
            {
                label: 'Applications',
                data: <?php echo json_encode($monthlyStats['applications'], 15, 512) ?>,
                borderColor: 'rgb(147, 51, 234)',
                backgroundColor: 'rgba(147, 51, 234, 0.1)',
                tension: 0.4
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\HorizonImmo\resources\views\admin\dashboard.blade.php ENDPATH**/ ?>