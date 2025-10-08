<form wire:submit.prevent="updateAvatar">
    <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200">
        <h4>Avatar Upload</h4>
        <input type="file" wire:model="avatar" accept="image/*">
        
        @if($avatar)
            <div>
                <p>File selected: {{ $avatar->getClientOriginalName() }}</p>
                <button class="mt-4 bg-blue-500 text-white py-2 px-4 rounded" type="submit">Update Avatar</button>
            </div>
        @endif
        
        @error('avatar')
            <div class="text-red-600  ">{{ $message }}</div>
        @enderror
    </div>
</form>
