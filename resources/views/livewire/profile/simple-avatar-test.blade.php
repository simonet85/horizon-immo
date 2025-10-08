<div>
    <h4>Simple Avatar Component Test</h4>
    <p>Current Avatar: {{ $currentAvatar ?? 'None' }}</p>
    <form wire:submit.prevent="test">
        <button type="submit">Test Button</button>
    </form>
</div>
