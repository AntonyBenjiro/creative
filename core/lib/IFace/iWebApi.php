<?php


namespace Core\IFace;


use Core\Request;

interface iWebApi
{

	public function __construct(Request $request);
}