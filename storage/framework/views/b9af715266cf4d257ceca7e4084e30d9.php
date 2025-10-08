

<?php $__env->startSection('title', 'Détails de la Propriété'); ?>

<?php $__env->startSection('content'); ?>
    <!-- En-tête -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e($property->title); ?>

        </h2>
        <div class="flex space-x-2">
            <a href="<?php echo e(route('admin.properties.edit', $property)); ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
                Modifier
            </a>
            <a href="<?php echo e(route('admin.properties.index')); ?>" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg">
                Retour à la liste
            </a>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Images -->
        <div class="lg:col-span-2">
            <?php if($property->images): ?>
                <?php $images = is_array($property->images) ? $property->images : json_decode($property->images, true); ?>
                <div class="space-y-4">
                    <!-- Image principale -->
                    <img src="<?php echo e($images[0]); ?>" alt="<?php echo e($property->title); ?>" class="w-full h-96 object-cover rounded-lg">
                    
                    <!-- Autres images -->
                    <?php if(count($images) > 1): ?>
                        <div class="grid grid-cols-3 md:grid-cols-4 gap-2">
                            <?php $__currentLoopData = array_slice($images, 1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <img src="<?php echo e($image); ?>" alt="<?php echo e($property->title); ?>" class="h-24 w-full object-cover rounded-lg">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                    <span class="text-gray-500">Aucune image disponible</span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Informations -->
        <div class="space-y-6">
            <!-- Prix et statut -->
            <div class="bg-white p-6 rounded-lg border">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900"><?php echo e($property->formatted_price); ?></h3>
                        <p class="text-gray-600"><?php echo e($property->city); ?></p>
                    </div>
                    <div class="flex flex-col items-end space-y-2">
                        <?php if($property->status === 'available'): ?>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                Disponible
                            </span>
                        <?php elseif($property->status === 'reserved'): ?>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Réservé
                            </span>
                        <?php else: ?>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                Vendu
                            </span>
                        <?php endif; ?>
                        
                        <?php if($property->is_featured): ?>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                ★ Vedette
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-700">Catégorie:</span>
                        <span class="text-gray-900"><?php echo e($property->category ? $property->category->name : 'Non définie'); ?></span>
                    </div>
                    <?php if($property->bedrooms): ?>
                        <div>
                            <span class="font-medium text-gray-700">Chambres:</span>
                            <span class="text-gray-900"><?php echo e($property->bedrooms); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if($property->bathrooms): ?>
                        <div>
                            <span class="font-medium text-gray-700">Salles de bain:</span>
                            <span class="text-gray-900"><?php echo e($property->bathrooms); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if($property->surface_area): ?>
                        <div>
                            <span class="font-medium text-gray-700">Surface:</span>
                            <span class="text-gray-900"><?php echo e(number_format($property->surface_area, 0)); ?> m²</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white p-6 rounded-lg border">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Actions</h4>
                <div class="space-y-2">
                    <a href="<?php echo e(route('admin.properties.edit', $property)); ?>" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg text-center block">
                        Modifier la propriété
                    </a>
                    <form action="<?php echo e(route('admin.properties.destroy', $property)); ?>" method="POST" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette propriété ?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg">
                            Supprimer la propriété
                        </button>
                    </form>
                </div>
            </div>

            <!-- Métadonnées -->
            <div class="bg-white p-6 rounded-lg border">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Informations</h4>
                <div class="space-y-2 text-sm">
                    <div>
                        <span class="font-medium text-gray-700">Créé le:</span>
                        <span class="text-gray-900"><?php echo e($property->created_at->format('d/m/Y à H:i')); ?></span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Modifié le:</span>
                        <span class="text-gray-900"><?php echo e($property->updated_at->format('d/m/Y à H:i')); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description complète -->
        <div class="lg:col-span-3">
            <div class="bg-white p-6 rounded-lg border">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Description</h3>
                <div class="prose max-w-none">
                    <?php echo nl2br(e($property->description)); ?>

                </div>
            </div>
        </div>

        <!-- Adresse -->
        <div class="lg:col-span-3">
            <div class="bg-white p-6 rounded-lg border">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Localisation</h3>
                <p class="text-gray-700"><?php echo e($property->address); ?></p>
                <p class="text-gray-600 text-sm mt-1"><?php echo e($property->city); ?></p>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\HorizonImmo\resources\views\admin\properties\show.blade.php ENDPATH**/ ?>