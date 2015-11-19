<?php
namespace C5\AppKit\Menus;

use Illuminate\Support\Collection as BaseCollection;

class Collection extends BaseCollection
{
	/**
	 * Add attributes to the collection of menu items.
	 *
	 * @param  mixed
	 * @return \C5\AppKit\Menus\Collection
	 */
	public function attr()
	{
		$args = func_get_args();

		$this->each(function($item) use ($args) {
			if (count($args) >= 2) {
				$item->attr($args[0], $args[1]);
			} else {
				$item->attr($args[0]);
			}
		});

		return $this;
	}

	/**
	 * Add metadata to the collection of items.
	 *
	 * @param  mixed
	 * @return \C5\AppKit\Menus\Collection
	 */
	public function data()
	{
		$args = func_get_args();

		$this->each(function($item) use ($args) {
			if (count($args) >= 2) {
				$item->data($args[0], $args[1]);
			} else {
				$item->data($args[0]);
			}
		});

		return $this;
	}

	/**
	 * Appends text or HTML to the collection of items.
	 *
	 * @param  string  $html
	 * @return \C5\AppKit\Menus\Collection
	 */
	public function append($html)
	{
		$this->each(function($item) use ($html) {
			$item->title .= $html;
		});

		return $this;
	}

	/**
	 * Prepends text or HTML to the collection of items.
	 *
	 * @param  string  $html
	 * @return \C5\AppKit\Menus\Collection
	 */
	public function prepend($html)
	{
		$this->each(function($item) use ($html) {
			$item->title = $html.$item->title;
		});

		return $this;
	}
}