<?php


namespace DbDumper\Zip;


interface IEngine
{
	public function addGlob(string $pattern): array;
	
	public function zip(): bool;
	
	public function open(string $path): bool;
	
}