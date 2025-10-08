<form wire:submit.prevent="updateAvatar">
    <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200">
        <h4>Avatar Upload</h4>
        <input type="file" wire:model="avatar" accept="image/*">
        
        <?php if($avatar): ?>
            <div>
                <p>File selected: <?php echo e($avatar->getClientOriginalName()); ?></p>
                <button class="mt-4 bg-blue-500 text-white py-2 px-4 rounded" type="submit">Update Avatar</button>
            </div>
        <?php endif; ?>
        
        <?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="text-red-600  "><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</form><?php /**PATH C:\laragon\www\HorizonImmo\resources\views\livewire\profile\update-avatar-form-simple.blade.php ENDPATH**/ ?>