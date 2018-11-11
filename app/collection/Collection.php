<?php

namespace app\collection;

class Collection implements \IteratorAggregate {

	protected $items = [];

	public function __construct(array $items = []) {
		$this->items = $items;
	}

	public function get() {
		return $this->items;
	}

	public function count() {
		return count($this->get());
	}

	public function getIterator() {
		return new \ArrayIterator($this->items);
	}

	public function merge(Collection $collection) {
		return $this->add($collection->get());
	}

	public function add(array $items) {
		$this->items = array_merge($this->items, $items);
	}

	public function push($item) {
		$this->items[] = $item;
	}

	public function toJson() {
		return json_encode($this->items);
	}

	public function sort(\Closure $comparator) {
		usort($this->items, $comparator);
	}

	public function search($value) {
		foreach ($this->items as $item)
			if ($item == $value) return $item;

		return false;
	}
}