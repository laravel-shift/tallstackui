<li @class($personalize['panels.li']) 
    x-bind:class="{ 'cursor-pointer': navigate === true }"
    @if ($navigate) x-on:click="selected = item.step" @endif>
    <div @class($personalize['panels.wrapper'])>
        <span @class($personalize['panels.item']) >
            <span @class($personalize['panels.circle.wrapper'])
                  x-bind:class="{
                      '{{ $personalize['panels.circle.inactive'] }}': selected < item.step,
                      '{{ $personalize['panels.circle.current'] }}': selected == item.step && item.completed === false,
                      '{{ $personalize['panels.circle.active'] }}': selected > item.step || selected == item.step && item.completed === true,
                  }">
                <span x-text="item.step"
                      x-show="selected < item.step || selected == item.step && item.completed == false"
                      x-bind:class="{
                          '{{ $personalize['panels.text.number.active'] }}': selected <= item.step,
                          '{{ $personalize['panels.text.number.inactive'] }}': selected >= item.step,
                      }">
                </span>
                <x-dynamic-component :component="TallStackUi::component('icon')"
                                     :icon="TallStackUi::icon('check')"
                                     x-show="selected > item.step || selected == item.step && item.completed == true"
                                     @class($personalize['panels.check']) />
            </span>
            <div class="flex flex-col">
                <span @class($personalize['panels.text.title.wrapper'])
                      x-bind:class="{
                        '{{ $personalize['panels.text.title.inactive'] }}': selected == item.step && item.completed === false || selected < item.step,
                        '{{ $personalize['panels.text.title.active'] }}': selected > item.step || selected == item.step && item.completed === true,
                      }" x-text="item.title"></span>
                <span @class($personalize['panels.text.description']) x-text="item.description"></span>
            </div>
        </span>
    </div>
    <div x-show="item.step != steps.length"
         @class($personalize['panels.divider.wrapper'])>
        <svg @class($personalize['panels.divider.svg']) viewBox="0 0 22 80" fill="none" preserveAspectRatio="none">
            <path d="M0 -2L20 40L0 82" vector-effect="non-scaling-stroke" stroke="currentcolor" stroke-linejoin="round" />
        </svg>
    </div>
</li>
