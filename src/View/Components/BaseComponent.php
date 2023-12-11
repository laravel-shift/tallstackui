<?php

namespace TallStackUi\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use TallStackUi\Foundation\Colors\ResolveColor;
use TallStackUi\Foundation\ResolveConfiguration;
use Throwable;

abstract class BaseComponent extends Component
{
    abstract public function blade(): View;

    public function render(): Closure
    {
        return function (array $data) {
            return $this->output($this->blade()->with($this->compile($data)), $data);
        };
    }

    /** @throws Throwable */
    private function compile(array $data): array
    {
        if (method_exists($this, 'validate')) {
            $this->validate();
        }

        // The setup method is a hook to allow interactions with the component after
        // validations. As the name suggests, it can be used for anything, but the
        // objective behind it is to enable interactions with the component after validation.
        if (method_exists($this, 'setup')) {
            $this->setup();
        }

        if ($colors = ResolveColor::from($this)) {
            $data = array_merge($data, ['colors' => [...$colors]]);
        }

        if ($configurations = ResolveConfiguration::from($this)) {
            $data = array_merge($data, ['configurations' => [...$configurations]]);
        }

        return [...$data];
    }

    private function output(View $view, array $data): string
    {
        $config = collect(config('tallstackui.debug'));

        if (! $config->get('status', false) ||
            ! ($environment = $config->get('environments', [])) ||
            ! in_array(app()->environment(), $environment)
        ) {
            return $view->render();
        }

        $ignores = ['slot', 'trigger', 'content'];
        $attributes = '';

        foreach (collect($data)
            ->filter(fn ($value) => ! is_array($value) && ! is_callable($value))
            ->filter(fn ($value, $key) => ! in_array($key, $ignores))
            ->toArray() as $key => $value) {
            $attributes .= "<span class=\"text-white\">$key:</span> <span class=\"text-red-500\">$value</span>";
            $attributes .= '<br>';
        }

        $html = $view->render();

        return <<<blade
            <x-tallstack-ui::debug>
                $html
                <x-slot:attributes>
                    $attributes              
                </x-slot:attributes>
            </x-tallstack-ui::debug>
        blade;
    }
}
