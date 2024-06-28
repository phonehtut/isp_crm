<x-dynamic-component :component="$getFieldWrapperView()" :id="$getId()" :label="$getLabel()" :label-sr-only="$isLabelHidden()" :helper-text="$getHelperText()"
    :hint="$getHint()" :hint-icon="$getHintIcon()" :required="$isRequired()" :state-path="$getStatePath()" :field="$field">

    <div
        class="relative flex items-center justify-start pe-6 overflow-hidden transition duration-75 bg-white rounded-lg shadow-sm fi-input-wrp ring-1 focus-within:ring-2 dark:bg-white/5 ring-gray-950/10 focus-within:ring-primary-600 dark:ring-white/20 dark:focus-within:ring-primary-500 fi-fo-text-input">


        <input {{ $isDisabled() ? 'disabled' : '' }} type="time" x-ref="timePicker" x-data="mdtimepicker($refs.timePicker, {
                okLabel: '{{ $getOkLabel() }}',
                cancelLabel: '{{ $getCancelLabel() }}',
                format: 'hh:mm:ss',
                timeFormat: 'hh:mm:ss',
                events: {
                    timeChanged: function(data, timepicker) {
                        @this.set('{!! $getStatePath() !!}', data.time);
                    },

                }
            },

        )"

            {{ $applyStateBindingModifiers('wire:model') }}="{{ $getStatePath() }}" @class([
                'time-input-picker fi-input block w-full border-none bg-transparent py-1.5 text-base text-gray-950 outline-none transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6',

            ])>
        <span
            class="absolute inset-y-0 right-0 flex items-center mx-2 pointer-events-none rtl:right-auto rtl:left-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
              </svg>
        </span>
    </div>
</x-dynamic-component>
