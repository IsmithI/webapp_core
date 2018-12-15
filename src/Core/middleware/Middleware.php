<?php

namespace Core\middleware;

interface Middleware {
	public function handle($req = null, $res = null, $service = null, $app = null);
}