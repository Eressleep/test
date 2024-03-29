<?php

namespace DOM\Services\Сonverter;

use DOM\Patterns\Singleton;
use DOM\Presentation\Json\DataFormat;
use DOM\Services\Collector\Input;
use DOM\Services\Reader\File;
use DOM\Validators\CheckFile;
use DOM\Validators\CheckInputParam;

class Action extends Singleton
{
	protected static $instance;

	const XMLFile = 'text.xml';
	const JsonFile = 'text.json';

	/**
	 * @param array $data
	 *
	 * @return void
	 */
	public function run(array $data) : void
	{
		try {
			$this->prepareData($data);
		} catch (\Throwable $exception) {
			print_r($exception);
		}
	}

	private function prepareData(array $data) : void {
		$out = CheckInputParam::checkKey($data);
		if(CheckFile::findFile($out))
		{
			$data = (new Input())->createFormData(File::read($out));
			$json = (new DataFormat($data))->getData();
			$xml = (new \DOM\Presentation\Xml\DataFormat($data))->getData();
			\DOM\Services\Save\File::save($json, self::JsonFile);
			\DOM\Services\Save\File::save($xml, self::XMLFile);
		}
	}

}
