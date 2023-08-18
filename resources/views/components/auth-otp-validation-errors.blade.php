@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        <div class="alert alert-danger">
            <div class="font-medium text-red-600">
                {{ __('Whoops! Something went wrong.') }}
            </div>
    
            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                <li>Either you entered wrong code or your code is expired!</li>
            </ul>
        </div>
    </div>
@endif
