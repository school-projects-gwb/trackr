<form id="switch-form" method="POST" action="{{ route('language.switch', $possibleLanguage['locale']) }}" {{ $attributes->merge(['class' => 'fixed w-52']) }}>
    @csrf
    <span class="text-left-switcher flex items-center">
        {{ 'NL' }}
    </span>
    <label class="mode-toggler">
        <input id="toggler-checkbox" type="checkbox"
               class="mode-toggler-input"
               aria-required="true"
            {{$currentLanguage['locale'] == 'en' ? 'checked="checked"' : ''}}
        />
        <span class="mode-toggler-ball"></span>
    </label>
    <span class="text-right-switcher flex items-center">
        {{ 'EN' }}
    </span>
</form>

<script>
    const togglerCheckbox = document.getElementById('toggler-checkbox');
    const switchForm = document.getElementById('switch-form');
    togglerCheckbox.addEventListener('change', handleChange);

    function handleChange(event) {
        switchForm.submit();
    }
</script>
