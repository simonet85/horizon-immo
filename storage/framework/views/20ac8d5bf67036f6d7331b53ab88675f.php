<div>
    <!-- Hero Section avec Image -->
    <div class="relative h-96 bg-gray-900">
        <?php if($property->images && count($property->images) > 0): ?>
            <img src="<?php echo e($property->images[0]); ?>" alt="<?php echo e($property->title); ?>" class="w-full h-96 object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <?php else: ?>
            <div class="w-full h-96 bg-gradient-to-r from-blue-600 to-green-600"></div>
        <?php endif; ?>
        
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <h1 class="text-4xl md:text-6xl font-bold mb-4"><?php echo e($property->title); ?></h1>
                <p class="text-xl md:text-2xl opacity-90"><?php echo e($property->city); ?></p>
            </div>
        </div>
    </div>

    <!-- Informations Principales -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Détails de la Propriété -->
            <div class="lg:col-span-2">
                <!-- Prix et Statut -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900 mb-2"><?php echo e($property->formatted_price); ?></h2>
                            <p class="text-gray-600 text-lg"><?php echo e($property->address); ?></p>
                        </div>
                        <div class="flex flex-col items-end space-y-2">
                            <?php if($property->status === 'available'): ?>
                                <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full font-medium">
                                    Disponible
                                </span>
                            <?php elseif($property->status === 'reserved'): ?>
                                <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full font-medium">
                                    Réservé
                                </span>
                            <?php else: ?>
                                <span class="px-4 py-2 bg-red-100 text-red-800 rounded-full font-medium">
                                    Vendu
                                </span>
                            <?php endif; ?>
                            
                            <?php if($property->is_featured): ?>
                                <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full font-medium">
                                    ⭐ En vedette
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Caractéristiques -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600"><?php echo e(ucfirst($property->type)); ?></div>
                            <div class="text-gray-600">Type</div>
                        </div>
                        <?php if($property->bedrooms): ?>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600"><?php echo e($property->bedrooms); ?></div>
                            <div class="text-gray-600">Chambres</div>
                        </div>
                        <?php endif; ?>
                        <?php if($property->bathrooms): ?>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600"><?php echo e($property->bathrooms); ?></div>
                            <div class="text-gray-600">Salles de bain</div>
                        </div>
                        <?php endif; ?>
                        <?php if($property->surface_area): ?>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600"><?php echo e(number_format($property->surface_area, 0)); ?></div>
                            <div class="text-gray-600">m²</div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Description</h3>
                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                        <?php echo nl2br(e($property->description)); ?>

                    </div>
                </div>

                <!-- Galerie d'Images -->
                <?php if($property->images && count($property->images) > 1): ?>
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Galerie Photos</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <?php $__currentLoopData = array_slice($property->images, 1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <img src="<?php echo e($image); ?>" alt="<?php echo e($property->title); ?>" class="w-full h-48 object-cover rounded-lg hover:scale-105 transition-transform duration-200 cursor-pointer">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar Contact -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-4">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Intéressé par cette propriété ?</h3>
                    
                    <div class="space-y-4">
                        <a href="/contact?property=<?php echo e($property->id); ?>" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 text-center block">
                            Poser une Question sur ce Bien
                        </a>
                        
                        <a href="/accompagnement" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 text-center block">
                            Demander un Accompagnement
                        </a>
                        
                        <a href="/catalogue" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 text-center block">
                            Voir Plus de Propriétés
                        </a>
                    </div>

                    <!-- Informations de Contact -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h4 class="font-semibold text-gray-900 mb-4">Horizon Immo</h4>
                        <div class="space-y-3 text-sm text-gray-600">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                Afrique du Sud
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                </svg>
                                +27 (0) 11 123 4567
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                                contact@horizonimmo.com
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Propriétés Similaires -->
    <?php if($similarProperties && $similarProperties->count() > 0): ?>
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Propriétés Similaires</h2>
                <p class="text-xl text-gray-600">Découvrez d'autres biens qui pourraient vous intéresser</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $__currentLoopData = $similarProperties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $similarProperty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 group">
                    <!-- Image -->
                    <div class="relative h-64 overflow-hidden">
                        <?php if($similarProperty->images && count($similarProperty->images) > 0): ?>
                            <img src="<?php echo e($similarProperty->images[0]); ?>" alt="<?php echo e($similarProperty->title); ?>" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        <?php else: ?>
                            <div class="w-full h-full bg-gradient-to-r from-blue-500 to-green-500 flex items-center justify-center">
                                <span class="text-white text-lg font-semibold"><?php echo e($similarProperty->type); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Badge statut -->
                        <div class="absolute top-4 left-4">
                            <?php if($similarProperty->status === 'available'): ?>
                                <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm font-medium">Disponible</span>
                            <?php elseif($similarProperty->status === 'reserved'): ?>
                                <span class="bg-yellow-600 text-white px-3 py-1 rounded-full text-sm font-medium">Réservé</span>
                            <?php else: ?>
                                <span class="bg-red-600 text-white px-3 py-1 rounded-full text-sm font-medium">Vendu</span>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Badge vedette -->
                        <?php if($similarProperty->is_featured): ?>
                        <div class="absolute top-4 right-4">
                            <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-medium">
                                ⭐ Vedette
                            </span>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Prix -->
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-white text-gray-900 px-3 py-1 rounded-full text-sm font-bold"><?php echo e($similarProperty->formatted_price); ?></span>
                        </div>
                    </div>

                    <!-- Contenu -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2"><?php echo e($similarProperty->title); ?></h3>
                        <p class="text-gray-600 mb-4 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            <?php echo e($similarProperty->city); ?>

                        </p>

                        <!-- Caractéristiques -->
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <?php echo e(ucfirst($similarProperty->type)); ?>

                            </span>
                            <?php if($similarProperty->bedrooms): ?>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                                </svg>
                                <?php echo e($similarProperty->bedrooms); ?> ch.
                            </span>
                            <?php endif; ?>
                            <?php if($similarProperty->surface_area): ?>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                </svg>
                                <?php echo e(number_format($similarProperty->surface_area, 0)); ?>m²
                            </span>
                            <?php endif; ?>
                        </div>

                        <!-- Description -->
                        <p class="text-gray-600 text-sm line-clamp-3 mb-4"><?php echo e(Str::limit($similarProperty->description, 120)); ?></p>

                        <!-- Actions -->
                        <div class="flex space-x-2">
                            <a href="<?php echo e(route('property.detail', $similarProperty->id)); ?>" 
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-200 text-center text-sm">
                                Voir Détails
                            </a>
                            <a href="/contact?property=<?php echo e($similarProperty->id); ?>" 
                               class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-200 text-center text-sm">
                                Question
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Lien vers le catalogue -->
            <div class="text-center mt-12">
                <a href="/catalogue" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition-all duration-200 text-lg">
                    Voir Tout le Catalogue
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div><?php /**PATH C:\laragon\www\HorizonImmo\resources\views\livewire\property-detail.blade.php ENDPATH**/ ?>