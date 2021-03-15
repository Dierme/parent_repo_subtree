<?php

namespace DbDumper\Zip;


use ZipArchive;

class DefaultZipper implements IEngine
{
	public $status;
	public $numFiles;
	/**
	 * @var ZipArchive
	 */
	private $Engine;
	
	/**
	 * DefaultZipper constructor.
	 * @param string $path
	 * @throws \Exception
	 */
	public function __construct(string $path)
	{
		$this->Engine = new ZipArchive();
		$this->open($path);
	}
	
	/**
	 * @param string $path
	 * @return bool
	 * @throws \Exception
	 */
	public function open(string $path): bool
	{
		if ($this->Engine->open($path, ZipArchive::CREATE) !== TRUE) {
			throw new \Exception("cannot open <$path>\n");
		}
		
		return true;
	}
	
	/**
	 * @param string $pattern
	 * @return array
	 */
	public function addGlob(string $pattern): array
	{
		# ZipArchive docs lie - returned type of ->addGlob() is array, NOT bool
		$found_files = $this->Engine->addGlob($pattern);
		
		$this->updateStatus();
		$this->numFiles = $this->Engine->numFiles;
		
		return $found_files;
	}
	
	public function updateStatus()
	{
		$this->status = $this->Engine->status;
	}
	
	/**
	 * @return bool
	 */
	public function zip(): bool
	{
		if ($this->Engine->close()) {
			$this->numFiles = 0;
			$this->updateStatus();
		};
		
		return true;
	}
}