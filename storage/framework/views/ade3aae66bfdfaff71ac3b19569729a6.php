

<?php $__env->startSection('title', isset($partner) ? 'Modifier le Partenaire' : 'Nouveau Partenaire'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="mb-6">
            <a href="<?php echo e(route('admin.home-content.index')); ?>" class="text-blue-600 hover:text-blue-800">
                ← Retour à la gestion du contenu
            </a>
            <h2 class="text-2xl font-bold text-gray-900 mt-4">
                <?php echo e(isset($partner) ? 'Modifier le Partenaire' : 'Nouveau Partenaire'); ?>

            </h2>
        </div>

        <form action="<?php echo e(isset($partner) ? route('admin.partners.update', $partner) : route('admin.partners.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php if(isset($partner)): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom du partenaire <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="<?php echo e(old('name', $partner->name ?? '')); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="website_url" class="block text-sm font-medium text-gray-700 mb-2">
                        Site web
                    </label>
                    <input type="url" 
                           id="website_url" 
                           name="website_url" 
                           value="<?php echo e(old('website_url', $partner->website_url ?? '')); ?>"
                           placeholder="https://exemple.com"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php $__errorArgs = ['website_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                        Ordre d'affichage <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="order" 
                           name="order" 
                           value="<?php echo e(old('order', $partner->order ?? 0)); ?>"
                           min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    <?php $__errorArgs = ['order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">
                        Logo <span class="text-red-500"><?php echo e(isset($partner) ? '' : '*'); ?></span>
                    </label>
                    <input type="file" 
                           id="logo" 
                           name="logo" 
                           accept="image/*"
                           <?php echo e(isset($partner) ? '' : 'required'); ?>

                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <?php if(isset($partner) && $partner->logo): ?>
                        <div class="mt-2">
                            <img src="<?php echo e(asset('storage/' . $partner->logo)); ?>" alt="Logo actuel" class="w-24 h-16 object-contain bg-gray-100 rounded">
                            <p class="text-xs text-gray-500 mt-1">Logo actuel</p>
                        </div>
                    <?php endif; ?>
                    <p class="text-xs text-gray-500 mt-1">
                        Formats acceptés: JPG, PNG, GIF, SVG. Taille recommandée: 200x100px
                    </p>
                </div>
            </div>

            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="3"
                          placeholder="Description optionnelle du partenaire..."
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo e(old('description', $partner->description ?? '')); ?></textarea>
                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="mt-6">
                <div class="flex items-center">
                    <input type="hidden" name="active" value="0">
                    <input type="checkbox" 
                           id="active" 
                           name="active" 
                           value="1"
                           <?php echo e(old('active', $partner->active ?? true) ? 'checked' : ''); ?>

                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="active" class="ml-2 block text-sm text-gray-700">
                        Partenaire actif (affiché sur le site)
                    </label>
                </div>
            </div>

            <!-- Aperçu -->
            <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-sm font-medium text-gray-700 mb-3">Aperçu :</h3>
                <div class="flex flex-col items-center text-center p-6 border border-gray-200 rounded-lg bg-white">
                    <div class="w-24 h-16 bg-gray-100 rounded mb-4 flex items-center justify-center">
                        <svg class="w-12 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h4 id="preview-name" class="text-lg font-semibold text-gray-900 mb-2"><?php echo e(old('name', $partner->name ?? 'Nom du partenaire')); ?></h4>
                    <p id="preview-description" class="text-sm text-gray-600 mb-2"><?php echo e(old('description', $partner->description ?? '')); ?></p>
                    <a id="preview-website" href="#" class="text-blue-600 hover:text-blue-800 text-sm" style="<?php echo e(old('website_url', $partner->website_url ?? '') ? '' : 'display: none;'); ?>">
                        Visiter le site
                    </a>
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-8">
                <a href="<?php echo e(route('admin.home-content.index')); ?>" 
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    <?php echo e(isset($partner) ? 'Mettre à jour' : 'Créer'); ?> le partenaire
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Script pour la prévisualisation en temps réel
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const websiteInput = document.getElementById('website_url');
    
    const previewName = document.getElementById('preview-name');
    const previewDescription = document.getElementById('preview-description');
    const previewWebsite = document.getElementById('preview-website');
    
    function updatePreview() {
        previewName.textContent = nameInput.value || 'Nom du partenaire';
        previewDescription.textContent = descriptionInput.value || '';
        
        if (websiteInput.value) {
            previewWebsite.href = websiteInput.value;
            previewWebsite.style.display = 'inline';
        } else {
            previewWebsite.style.display = 'none';
        }
    }
    
    nameInput.addEventListener('input', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);
    websiteInput.addEventListener('input', updatePreview);
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\HorizonImmo\resources\views\admin\partners\create.blade.php ENDPATH**/ ?>